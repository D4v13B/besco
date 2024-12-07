<?php session_start();


include "conexion.php";
include "funciones.php";

$usua_id = $_SESSION["login_user"];
$fopa_id = $_POST["metodoPago"];
$copr_id = $_POST["copr_id"]; //prov_id
$pagos_facturas = $_POST["pagos_facturas"];
$i_prfp_numero = $_POST["i_prfp_numero"];
$referencia_ach = !empty($_POST["i_prfp_referencia_ach"]) ? $_POST["i_prfp_referencia_ach"] : "";
$fecha = $_POST["i_fecha"];
$pago_agrupado = count($pagos_facturas) > 1 ? 1 : 0;

if (empty($fopa_id) or empty($pagos_facturas) or empty($i_prfp_numero) or empty($fecha)) {
   echo "Llenar todos los espacios requeridos";
   http_response_code(400);
   die();
}


if ($fopa_id == 12) {
   $factIdsString = '';

   if (is_array($pagos_facturas)) {
      foreach ($pagos_facturas as $factura) {
         // Asegurarse de que factId exista en cada factura
         if (isset($factura['factId'])) {
            // Concatenar el factId al string, separando por coma
            $factIdsString .= $factura['factId'] . ', ';
         }
      }
   }

   // Eliminar la última coma y espacio
   $factIdsString = rtrim($factIdsString, ', ');

   //Seleccionar todas las facturas que vamos a pagar con sus respectivos montos
   $sql = "SELECT * FROM cons_facturas WHERE fact_id IN ($factIdsString)";
   $facturas = mysql_query($sql);

   //Seleccionamos todos los abonos realizados con saldo pendiente de usar
   $sql = "SELECT copp_id, copp_saldo FROM cons_pre_pagos 
   WHERE copp_saldo > 0 AND prov_id = $copr_id 
   ORDER BY copp_fecha";
   $abonos = mysql_query($sql);

   while ($fila = mysql_fetch_assoc($facturas)) {
      $factSaldoPendiente = $fila["fact_saldo"];
      $fact_id = $fila["fact_id"];

      $result = current(array_filter($pagos_facturas, function ($item) use ($fact_id) {
         return $item['factId'] == $fact_id;
      }));

      if ($result && isset($result['monto'])) {
         $montoAplicar = $result['monto'];
      } else {
         $montoAplicar = null;
      }

      while ($abono = mysql_fetch_assoc($abonos)) {
         $abonoSaldo = $abono["copp_saldo"];
         $abonoId = $abono["copp_id"];

         // Determinar el monto a aplicar en esta iteración
         $montoFacturaAplicar = min($montoAplicar, $abonoSaldo);

         // Asegurarse de que el monto no sea negativo
         if ($montoFacturaAplicar <= 0) {
            continue;
         }

         // Restar el monto aplicado del saldo del abono y la factura
         $abonoSaldo -= $montoFacturaAplicar;
         $factSaldoPendiente -= $montoFacturaAplicar;

         // Actualizar el saldo de la factura en la base de datos
         $sql = "UPDATE cons_facturas SET fact_saldo = fact_saldo - $montoFacturaAplicar WHERE fact_id = $fact_id";
         mysql_query($sql);
         
         //Actualizar el estado dependiendo del saldo
         $sql = "UPDATE cons_facturas SET faes_id = 
            CASE
               WHEN fact_total = fact_saldo THEN 1 
               WHEN fact_saldo = 0 THEN 3
               WHEN fact_saldo < fact_total THEN 2 
            END
         WHERE fact_id = $fact_id";

         mysql_query($sql);

         // Actualizar el saldo del abono en la base de datos
         $sql = "UPDATE cons_pre_pagos SET copp_saldo = copp_saldo - $montoFacturaAplicar WHERE copp_id = $abonoId";
         mysql_query($sql);


         // Actualizar el saldo del abono en el array
         $abono["copp_saldo"] = $abonoSaldo;

         // Ajustar el monto a aplicar para la siguiente iteración
         $montoAplicar = $factSaldoPendiente;

         // Si no queda saldo pendiente en la factura, salir del bucle
         if ($factSaldoPendiente <= 0) {
            break;
         }
      }
   }
} else {
   foreach ($pagos_facturas as $pf) {
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

      //Actualizar el estado
      $qsql = "UPDATE cons_facturas SET faes_id = 
            CASE
               WHEN fact_total = fact_saldo THEN 1 
               WHEN fact_saldo = 0 THEN 3
               WHEN fact_saldo < fact_total THEN 2 
            END
         WHERE fact_id = $fact_id";
      mysql_query($qsql);
   }
}
