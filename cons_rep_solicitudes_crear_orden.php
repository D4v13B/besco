<?php
session_start();
$user_check = $_SESSION['login_user'];

if ($user_check != '') {
	include('conexion.php');
	include('funciones.php');

	$id = $_POST['id']; //Este es el coso_id
	$fecha = $_POST['fecha'];
	$adjuntar = $_POST['adjuntar'];
	$proy_id = obtener_valor("SELECT proy_id FROM cons_solicitudes WHERE coso_id='$id'", "proy_id");
	$coso_numero = obtener_valor("SELECT coso_numero FROM  cons_solicitudes WHERE coso_id='$id'", "coso_numero");

	/*
	$qsql ="select secu_numero+1 secuencia from cons_secuencias where secu_libreta='orden_compra'";
	$secuencia = obtener_valor($qsql, "secuencia");
	$qsql ="update cons_secuencias set secu_numero='$secuencia' where  secu_libreta='orden_compra'";
	*/

	//DEBO HACER EL PROCESO TANTOS PROVEEDORES TENGA LA SOLICITUD
	/**
	 * Aqui vamos a traer todos los proveedores relacionados mediante el solicitudes_detalle al out de la query
	 */
	$qsql = "SELECT copr_id FROM cons_solicitudes_detalles WHERE coso_numero='$coso_numero'
	GROUP BY copr_id";
	$rs = mysql_query($qsql);
	$num = mysql_num_rows($rs);
	$i = 0;
	$prov_procesados = [];

	/**
	 * Este loop recorre todos los proveedores que extrajimos del la solicitudes_detalles
	 */
	while ($i < $num) {
		$prov_id = mysql_result($rs, $i, 'copr_id');
		$orco_id = 0;

		if ($adjuntar == 1) {
			/**
			 * Validamos si hay alguna orden_compra pendiente para ese proveedor que tenemos dentro de $prov_id
			 * 
			 * A su vez retorna el id de la orden_compra que esta pendiente y el count que dice que hay mas de 0
			 */
			$orco_id = obtener_valor("SELECT COALESCE(orco_id,0) orco, COUNT(*) FROM cons_orden_compra where crpr_id='$prov_id' and ores_id=1 order by orco_id desc limit 1", "orco");

			if ($orco_id != 0) {
				array_push($prov_procesados, $prov_id);
				/**
				 * Aqui vamos a tomar las lineas del solicitud_detalle y se la vamos a actualizar al orco_id que tenemos en $orco_id["orco"]
				 */
				$compra_id = $orco_id;

				/**
				 * Vamos a seleccionar todos los productos del detalle de la solicitud que tengan al proveedor $prov_id
				 */
				$qsql = "SELECT * FROM cons_solicitudes_detalles a 
                     JOIN construccion_rubros b ON a.coru_id = b.coru_id 
                     JOIN construccion_presupuesto c ON a.coru_id = c.coru_id 
                     WHERE a.copr_id = '$prov_id' AND a.coso_numero = '$coso_numero'";

				$solicitud_detalle = mysql_query($qsql);

				while ($fila = mysql_fetch_assoc($solicitud_detalle)) {
					$prod_id = $fila["coru_id"];
					$cosd_cantidad = $fila["cosd_cantidad"];
					$orcd_detalle = $fila["coru_nombre"];
					$precio = $fila["copr_monto"];

					/**
					 * Aqui hacemos una insercion de los rubros que estan siendo procesados dentro de la orden de compra con el proveedor que estamos procesando
					 */

					$qsql = "INSERT INTO cons_orden_compra_detalles(
					orco_id, 
					prod_id, 
					orcd_cantidad, 
					orcd_detalle, 
					orcd_precio) VALUES (
					'$compra_id', 
					'$prod_id', 
					'$cosd_cantidad', 
					'$orcd_detalle', 
					'$precio')";

					mysql_query($qsql);
				}
			} else {
				/**
				 * Creamos la orden de compra desde 0 y les adjuntamos los detalles que pertenecen al $prov_id actual
				 */
				/**
				 * Este query selecciona los codigos temporales para la secuencia de la orden de compra
				 */
				$qsql = "select cote_id from codigos_temporales_orden_compra";
				$codigo = obtener_valor($qsql, 'cote_id');
				$secuencia = obtener_valor("select max(orco_numero)+ 1 factura from cons_orden_compra", "factura");
				mysql_query("update codigos_temporales_orden_compra set cote_id=cote_id+1");
				//INSERTO LA CABECERA DE LA ORDEN DE COMPRA
				$qsql = "INSERT INTO cons_orden_compra 
					(coso_id, crpr_id, orco_fecha, orco_fecha_creacion, orco_numero, proy_id, usua_id)
					VALUES 
					(
					'$id',
					'$prov_id',
					'$fecha',
					NOW(),
					'$secuencia',
					'$proy_id',
					'$user_check'
					)";

				mysql_query($qsql);

				$orco_id = mysql_insert_id();

				$qsql = "INSERT INTO cons_orden_compra_detalles (orco_id, prod_id, orcd_cantidad, orcd_detalle, orcd_temp_code, orcd_precio)
				(SELECT '$orco_id', a.coru_id, cosd_cantidad, coru_nombre, '$codigo', copr_monto
				FROM cons_solicitudes_detalles a, construccion_rubros b, construccion_presupuesto c
				WHERE coso_numero ='$coso_numero' 
				AND a.copr_id='$prov_id'
				AND a.coru_id = b.coru_id
				AND a.coru_id = c.coru_id 
				AND copr_pendientes >= cosd_cantidad 
				AND c.proy_id='$proy_id')";
				mysql_query($qsql);
			}
		} else { //Si no queremos adjuntar, enviamos todo por cada proveedor

			$qsql = "select cote_id from codigos_temporales_orden_compra";
			$codigo = obtener_valor($qsql, 'cote_id');
			$secuencia = obtener_valor("select max(orco_numero)+ 1 factura from cons_orden_compra", "factura");
			mysql_query("update codigos_temporales_orden_compra set cote_id=cote_id+1");
			//CREAMOS LA CABECERA DE LA ORDEN DE COMPRA
			$qsql = "INSERT INTO cons_orden_compra 
					(coso_id, 
					crpr_id, 
					orco_fecha, 
					orco_fecha_creacion, 
					orco_numero, 
					proy_id, 
					usua_id)
					VALUES 
					(
					'$id',
					'$prov_id',
					'$fecha',
					NOW(),
					'$secuencia',
					'$proy_id',
					'$user_check'
					)";

			mysql_query($qsql);

			$orco_id = mysql_insert_id();

			$qsql = "INSERT INTO cons_orden_compra_detalles (orco_id, prod_id, orcd_cantidad, orcd_detalle, orcd_temp_code, orcd_precio)
				(SELECT '$orco_id', a.coru_id, cosd_cantidad, coru_nombre, '$codigo', copr_monto
				FROM cons_solicitudes_detalles a, construccion_rubros b, construccion_presupuesto c
				WHERE coso_numero ='$coso_numero' 
				AND a.copr_id='$prov_id'
				AND a.coru_id = b.coru_id
				AND a.coru_id = c.coru_id 
				AND copr_pendientes >= cosd_cantidad 
				AND c.proy_id='$proy_id')";
			mysql_query($qsql);
		}
		$i++;
	}

	/**
	 * Vamos a seleccionar todos los detalles del coso_numero = $coso_numero y con prov_id que no estan incluidos dentro de $prov_procesado[]
	 */

	// $qsql = "SELECT * FROM ";

	// if ($orco_id == 0) {

	// 	mysql_query($qsql);


	// }

	//INSERTO EL DETALLE





	//debo actualizar la solicitud
	$qsql = "UPDATE cons_solicitudes SET cose_id=2 WHERE coso_id='$id'";
	mysql_query($qsql);
}
