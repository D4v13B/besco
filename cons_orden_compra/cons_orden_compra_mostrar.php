<?php 
session_start();
$user_check=$_SESSION['login_user'];
include('../conexion.php'); 
include('../funciones.php'); 
$rol = obtener_rol($user_check);
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
<td class=tabla_datos_titulo_icono></td>
<td class=tabla_datos_titulo_icono></td>
</tr>
<?php
$factura=$_GET['factura'];
$recibo=$_GET['recibo'];
$desde=$_GET['desde'];
$hasta=$_GET['hasta'];
$copr_id=$_GET['copr_id'];

$where ="";
if($factura!='') $where .= " AND orco_numero=$factura";
if($desde!='') $where .= " AND date_format(orco_fecha, '%Y%m%d')>=$desde";
if($hasta!='') $where .= " AND date_format(orco_fecha, '%Y%m%d')<=$hasta";
if($copr_id!='' && $copr_id!='null') $where .= " AND b.copr_id in ($copr_id)";

$qsql ="select orco_id, orco_numero, copr_nombre, orco_fecha,
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
$i=0;
while ($i<$num)
{
	$monto = mysql_result($rs, $i, 'monto');
	$itbms = mysql_result($rs, $i, 'itbms');
	$aprobada = mysql_result($rs, $i, 'aprobada');
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'orco_numero'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'aprobada'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copr_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'orco_fecha'); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format($monto,2); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format($itbms,2); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format($monto+$itbms,2); ?></td>
<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)';><img src='imagenes/modificar.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a></td>
<td class=tabla_datos_iconos><a href='javascript:imprimir_factura(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)';><img src='imagenes/invoice.png' style="width:25px;height:25px" border=0 title="Imprimir Factura" alt="Imprimir Factura"></a></td>

<td class=tabla_datos_iconos><?php if($rol==1) {?><a href='javascript:aprobar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)';><img src='imagenes/ok.png' border=0 style="width:25px;height:25px" alt="Editar" title="Editar"></a><?php }?></td>
<td class=tabla_datos_iconos><?php if($aprobada=='SI') {?><a href='index.php?p=cons_recibir/cons_recibir_orden&id=<?php echo mysql_result($rs, $i, 'orco_id'); ?>&responsive=1';><img src='imagenes/recibir.png' border=0 style="width:25px;height:25px" title="Recibir" alt="Recibir"></a><?php }?></td>
<td class=tabla_datos_iconos><?php if($aprobada=='SI') {?><a href='javascript:enviar_oc(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)';><img src='imagenes/enviar_email.png' border=0 style="width:25px;height:25px" title="Enviar OC" alt="Enviar OC"></a><?php }?></td>
<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'orco_id'); ?>)';><img src='imagenes/trash.png' border=0 style="width:25px;height:25px" title="Eliminar" alt="Eliminar"></a></td>
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
<td style="text-align:right !important"><?php echo number_format($tmonto,2)?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td
<td></td>
</table>