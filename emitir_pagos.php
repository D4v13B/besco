<?php session_start();


include "conexion.php";
include "funciones.php";

$usua_id = $_SESSION["login_user"];
$fopa_id = $_POST["metodoPago"];
$copr_id = $_POST["copr_id"];
$pagos_facturas = $_POST["pagos_facturas"];
$i_prfp_numero = $_POST["i_prfp_numero"];
$referencia_ach = !empty($_POST["i_prfp_referencia_ach"]) ? $_POST["i_prfp_referencia_ach"] : "";
$fecha = $_POST["i_fecha"];
$pago_agrupado = count($pagos_facturas) > 1 ? 1 :0 ;

if(empty($fopa_id) or empty($pagos_facturas) or empty($i_prfp_numero) or empty($fecha)){
   echo "Llenar todos los espacios requeridos";
   http_response_code(400);
   die();
}

foreach($pagos_facturas as $pf){
   //Insertar en construccion pagos
   $monto = $pf["monto"];
   $fact_id = $pf["factId"];

   $qsql = "INSERT INTO cons_facturas_pagos
   (
      fact_id, prfp_monto, fopa_id, usua_id, prfp_fecha_creacion, prfp_fecha, prpf_agrupada, prfp_numero, prfp_ach_refrencia
   ) 
   VALUES
   (
      '$fact_id',
      '$monto',
      '$fopa_id',
      '$usua_id',
      NOW(),
      '$fecha',
      '$pago_agrupado',
      '$i_prfp_numero',
      '$referencia_ach'
   )";

   mysql_query($qsql);

   //Actualizar el saldo en la tabla facturas
   $qsql = "UPDATE cons_facturas SET fact_saldo = fact_saldo - $monto WHERE fact_id = $fact_id";
   mysql_query($qsql);
}
?>