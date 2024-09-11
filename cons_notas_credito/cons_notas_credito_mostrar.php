<?php
session_start();
$user_check = $_SESSION['login_user'];
include('../conexion.php');
include('../funciones.php');
$rol = obtener_rol($user_check);
?>
<table class=nicetable>
	<tr>
		<td class=tabla_datos_titulo>No. N/C</td>
		<td class=tabla_datos_titulo>Proveedor</td>
		<td class=tabla_datos_titulo>Fecha</td>
		<td class=tabla_datos_titulo>Monto</td>
		<td class=tabla_datos_titulo>ITBMS</td>
		<td class=tabla_datos_titulo>TOTAL</td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
		<td class=tabla_datos_titulo_icono></td>
	</tr>
	<?php
	$factura = $_GET['factura'];
	$recibo = $_GET['recibo'];
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$copr_id = $_GET['copr_id'];

	$where = "";
	// if($factura!='') $where .= " AND orco_numero=$factura";
	// if($desde!='') $where .= " AND date_format(orco_fecha	, '%Y%m%d')>=$desde";
	// if($hasta!='') $where .= " AND date_format(orco_fecha, '%Y%m%d')<=$hasta";
	// if($copr_id!='' && $copr_id!='null') $where .= " AND b.copr_id in ($copr_id)";

	$qsql = "select nocr_id, copr_nombre, a.nocr_fecha,
       (select sum(nocr_precio*nocr_cantidad) from cons_notas_credito_detalle where nocr_id=a.nocr_id) monto,
       (select sum(nocr_precio*nocr_cantidad)*0.07 from cons_notas_credito_detalle where nocr_id=a.nocr_id and nocr_con_itbms=1) itbms
from cons_notas_credito a, cons_proveedores b
where a.crpr_id=b.copr_id
$where
order by nocr_id desc
";
	//echo nl2br($qsql);

	$rs = mysql_query($qsql);
	$num = mysql_num_rows($rs);
	$i = 0;
	while ($i < $num) {
		$monto = mysql_result($rs, $i, 'monto');
		$itbms = mysql_result($rs, $i, 'itbms');
	?>
		<tr class='tabla_datos_tr'>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'nocr_id'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copr_nombre'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'nocr_fecha'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'monto'); ?></td>
			<td class=tabla_datos><?php echo mysql_result($rs, $i, 'itbms'); ?></td>
			<td class=tabla_datos><?php echo (mysql_result($rs, $i, 'itbms') + mysql_result($rs, $i, 'monto')); ?></td>
			<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'nocr_id'); ?>)' ;><img src='imagenes/modificar.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a></td>
			<td class=tabla_datos_iconos><a href='javascript:imprimir_factura(<?php echo mysql_result($rs, $i, 'nocr_id'); ?>)' ;><img src='imagenes/invoice.png' style="width:25px;height:25px" border=0 title="Imprimir Factura" alt="Imprimir Factura"></a></td>
			<td class=tabla_datos_iconos><?php if ($rol == 1) { ?><a href='javascript:aprobar(<?php echo mysql_result($rs, $i, 'nocr_id'); ?>)' ;><img src='imagenes/ok.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a><?php } ?></td>
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI') { ?><a href='index.php?p=cons_recibir/cons_recibir_orden&id=<?php echo mysql_result($rs, $i, 'nocr_id'); ?>&responsive=1' ;><img src='imagenes/recibir.png' border=0 style="width:25px;height:25px" title="Recibir" alt="Recibir"></a><?php } ?></td>
			<td class=tabla_datos_iconos><?php if ($aprobada == 'SI') { ?><a href='javascript:enviar_oc(<?php echo mysql_result($rs, $i, 'nocr_id'); ?>)' ;><img src='imagenes/enviar_email.png' border=0 style="width:25px;height:25px" title="Enviar OC" alt="Enviar OC"></a><?php } ?></td>
			<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'nocr_id'); ?>)' ;><img src='imagenes/trash.png' border=0 style="width:25px;height:25px" title="Eliminar" alt="Eliminar"></a>
			</td>
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
</table>