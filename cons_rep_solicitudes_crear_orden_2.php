<?php
session_start();
$user_check = $_SESSION['login_user'];

if ($user_check != "") {
   include('conexion.php');
   include('funciones.php');

   $id = $_POST["id"]; //ID de la solicitud
   $fecha = $_POST["fecha"];
   $adjuntar = $_POST["adjuntar"];
   $proy_id = obtener_valor("SELECT proy_id FROM cons_solicitudes WHERE coso_id='$id'", "proy_id"); //ID del proyecto
   $coso_numero = obtener_valor("SELECT coso_numero FROM  cons_solicitudes WHERE coso_id='$id'", "coso_numero"); //Numero de la solicitud

   /**
    * El proceso debe crear o adjuntar el detalle de la solicitud por cada proveedor
    */

   $rs_proveedores = mysql_query("SELECT copr_id FROM cons_solicitudes_detalles WHERE coso_numero='$coso_numero' GROUP BY copr_id");

   $prov_procesados = []; //Arreglo que tiene los ID de los proveedores procesados

   while ($fila = mysql_fetch_assoc($rs_proveedores)) {
      $prov_id = $fila["prov_id"];
      $orco_id = 0;

      if($adjuntar == 1){ //Si queremos adjuntar los detalles a una compra creada

         /**
          * Validamos si hay alguna orden de compra pendiente para ese proveedor
          *A su vez retorna el id de la orden_compra que esta pendiente y el count que dice que hay mas de 0
          */

          $orco_id = obtener_valor("SELECT COALESCE(orco_id,0) orco, COUNT(*) FROM cons_orden_compra where crpr_id='$prov_id' and ores_id=1 order by orco_id desc limit 1", "orco");


         if($orco_id != 0){ //Existen ordenes de compra pendientes y sin cerrar
            
            //Obtenemos el orco_temp_code

            $res_solicitud_detalle = mysql_query("SELECT * FROM cons_solicitudes_detalles a, construccion_rubros b, construccion_presupuesto c 
				WHERE a.coru_id = b.coru_id 
				AND b.coru_id = c.coru_id
				AND a.copr_id = '$prov_id' AND a.coso_numero = '$coso_numero'");

            
         }
      }
   }
}
