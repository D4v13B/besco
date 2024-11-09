<?php

session_start();
require "../conexion.php";

$notas_credito_pago = json_decode($_POST["notas_credito"], true);
$copr_id = $_POST["copr_id"];
$usua_id = $_SESSION["login_user"];
$fopa_id = $_POST["fopa_id"];
$fecha = !empty($_POST["i_fecha"]) ? $_POST["i_fecha"] : date("d-m-Y");
$pago_agrupado = count($notas_credito_pago) > 1 ? 1 : 0;

foreach ($notas_credito_pago as $ncp) {
   $nocr_id = $ncp["nocr_id"];
   $monto = $ncp["saldo_usar"];

   $qsql = "INSERT INTO cons_facturas_pagos
   (
      prfp_monto, 
      fopa_id,
      usua_id, 
      prfp_fecha_creacion, 
      prfp_fecha, 
      prpf_agrupada,
      prfp_nota_credito
   ) 
   VALUES
   (
      '$monto',
      '$fopa_id',
      '$usua_id',
      NOW(),
      '$fecha',
      '$pago_agrupado',
      '$nocr_id'
   )";

   $res = mysql_query($qsql);

   $res = mysql_affected_row($res);

   if($res > 0){
      $qsql = "UPDATE cons_notas_credito SET nocr_saldo = nocr_saldo - $monto WHERE nocr_id = $nocr_id";
      mysql_query($qsql);
   }else{
      http_response_code(400);
      die();
   }
}

// INSERT INTO cons_facturas_pagos ( 
//    prfp_monto, 
//    fopa_id, 
//    usua_id, 
//    prfp_fecha_creacion, 
//    prfp_fecha, 
//    prpf_agrupada, 
//    prfp_nota_credito ) 
//    VALUES ( 
//       '20', 
//       '', 
//       '1', 
//       NOW(), 
//       '20240918', 
//       '1', 
//       '', 
//       '3' 
//       )