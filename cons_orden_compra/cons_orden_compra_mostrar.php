<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start();
$user_check = $_SESSION['login_user'];
include('../conexion.php');
include('../funciones.php');
$rol = obtener_rol($user_check);

switch ($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		require "../PHPMailer/src/PHPMailer.php";
		require "../PHPMailer/src/SMTP.php";

		if (isset($_POST["tipo_email"]) and !empty($_POST["tipo_email"])) {
			/**
			 * Vamos a enviar los emails dependiendo del parametro
			 * 1. Al ingeniero
			 * 2. A Ricardo
			 * 3. Al proveedor
			 */

			$machote = "NOTIFICACION PARA ORDEN DE COMPRA";
			$tipoEmail = $_POST["tipo_email"];
			$id = $_POST["id"];
			switch ($tipoEmail) {
				case "ingeniero":
					$machote .= " ORDEN DE COMPRA $id HA SIDO CARGADA";
					enviar_email('luis@e-integracion.com', 'PROMOTORA ORION', 'REVISAR ORDEN DE COMPRA', $machote, "twotowerpark@gmail.com", "", new PHPMailer());
					break;
				case "ricardo":
					$machote .= " ORDEN DE COMPRA $id HA SIDO APROBADA";
					enviar_email('luis@e-integracion.com', 'PROMOTORA ORION', 'REVISAR ORDEN DE COMPRA', $machote, "ricardo0415@hotmail.com", "", new PHPMailer());
					break;
				case "proveedor":
					$emailProv = $_POST["emailProv"];
					$machote .= " ORDEN DE COMPRA $id HA SIDO APROBADA PARA BESCO";
					enviar_email('luis@e-integracion.com', 'PROMOTORA ORION', 'REVISAR ORDEN DE COMPRA', $machote, $emailProv, "", new PHPMailer());
					break;
			}
		}
		exit;
}
?>
<table class=nicetable>
	<tr>
		<td class=tabla_datos_titulo>No. O/C</td>
		<td style="width:30px !important">APROBADA</td>
		<td class=tabla_datos_titulo>Proveedor</td>
		<td class=tabla_datos_titulo>Fecha</td>
		<td class=tabla_datos_titulo>Monto</td>
		<td class=tabla_datos_titulo>ITBMS</td>
		<td class=tabla_datos_titulo>TOTAL</td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono>Enviar a Ingeniero</td>
		<td class=tabla_datos_titulo_icono>Envair a Ricardo</td>
		<td class=tabla_datos_titulo_icono>Enviar en Provedor</td>
		<td class=tabla_datos_titulo_icono></td>
	</tr>
	<?php
	$factura = $_GET['factura'];
	$recibo = $_GET['recibo'];
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$copr_id = $_GET['copr_id'];

	$where = "";
	if ($factura != '') $where .= " AND orco_numero=$factura";
	if ($desde != '') $where .= " AND date_format(orco_fecha, '%Y%m%d')>=$desde";
	if ($hasta != '') $where .= " AND date_format(orco_fecha, '%Y%m%d')<=$hasta";
	if ($copr_id != '' && $copr_id != 'null') $where .= " AND b.copr_id in ($copr_id)";

	$qsql = "select orco_id, orco_numero, copr_nombre, orco_fecha,
(select sum(orcd_precio*orcd_cantidad) from cons_orden_compra_detalles where orco_id=a.orco_id) monto,
(select sum(orcd_precio*orcd_cantidad)*0.07 from cons_orden_compra_detalles where orco_id=a.orco_id and orcd_con_itbms=1) itbms,
if(orco_aprobada=1, 'SI','NO') aprobada
from cons_orden_compra a, cons_proveedores b
where a.crpr_id=b.copr_id
$where
order by orco_id desc
";
	//echo nl2br($qsql);

	$rs = mysql_query($qsql);
	$num = mysql_num_rows($rs);
	$i = 0;
	while ($i < $num) {
		$monto = mysql_result($rs, $i, 'monto');
		$itbms = mysql_result($rs, $i, 'itbms');
		$aprobada = mysql_result($rs, $i, 'aprobada');
	?>
		<tr class='tabla_datos_tr'>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'orco_numero'); ?></td>
			<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'aprobada'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copr_nombre'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'orco_fecha'); ?></td>
			<td class=tabla_datos style="text-align:right !important"><?php echo number_format($monto, 2); ?></td>
			<td class=tabla_datos style="text-align:right !important"><?php echo number_format($itbms, 2); ?></td>
			<td class=tabla_datos style="text-align:right !important"><?php echo number_format($monto + $itbms, 2); ?></td>
			<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)' ;><img src='imagenes/modificar.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a></td>
			<td class=tabla_datos_iconos><a href='javascript:imprimir_factura(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)' ;><img src='imagenes/invoice.png' style="width:25px;height:25px" border=0 title="Imprimir Factura" alt="Imprimir Factura"></a></td>

			<td class=tabla_datos_iconos><?php if ($rol == 1) { ?><a href='javascript:aprobar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)' ;><img src='imagenes/ok.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a><?php } ?></td>
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI' or 1 == 1) { ?><a href='index.php?p=cons_recibir/cons_recibir_orden&id=<?php echo mysql_result($rs, $i, 'orco_id'); ?>&responsive=1' ; target="_blank"><img src='imagenes/recibir.png' border=0 style="width:25px;height:25px" title="Recibir" alt="Recibir"></a><?php } ?></td>
			<!-- Ingeniero -->
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI' or 1 == 1) { ?><a href='javascript:enviar_oc(<?php echo mysql_result($rs, $i, 'orco_id'); ?>, "ingeniero")' ;><img src='imagenes/enviar_email.png' border=0 style="width:25px;height:25px" title="Enviar OC" alt="Enviar OC"></a><?php } ?></td>
			<!-- Ricardo -->
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI' or 1 == 1) { ?><a href='javascript:enviar_oc(<?php echo mysql_result($rs, $i, 'orco_id'); ?>, "ricardo")' ;><img src='imagenes/enviar_email.png' border=0 style="width:25px;height:25px" title="Enviar OC" alt="Enviar OC"></a><?php } ?></td>
			<!-- Proveedor -->
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI' or 1 == 1) { ?><a href='javascript:enviarCorreoProv(<?php echo mysql_result($rs, $i, 'orco_id'); ?>, "proveedor")' ;><img src='imagenes/enviar_email.png' border=0 style="width:25px;height:25px" title="Enviar OC" alt="Enviar OC"></a><?php } ?></td>
			<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)' ;><img src='imagenes/trash.png' border=0 style="width:25px;height:25px" title="Eliminar" alt="Eliminar"></a></td>
		</tr>
	<?php
		$tmonto += $monto;
		$tcosto += $costo;
		$tmargen += $margen;

		$i++;
	}
	?>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="text-align:right !important"><?php echo number_format($tmonto, 2) ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>
		</td>
</table>