<?php
session_start();
$usuario=$_SESSION['login_user'];
include('../conexion.php'); 
include('../funciones.php');
include('../funciones_ui.php');
?> 
<script src='../jquery/sorter/tablesort.min.js'></script>
<script src='../jquery/sorter/sorts/tablesort.number.min.js'></script>
<script src='../jquery/sorter/sorts/tablesort.date.min.js'></script>
<script>
$(function () {
	//DESHABILITO LOS CONTROLES QUE SON EXCLUSIVOS POR ROL
	$(".btn_borrar_factura").hide();

	<?php echo pantalla_roles(str_replace("/","",$_SERVER['PHP_SELF']), $usuario)?>
});

$(function() {
  new Tablesort(document.getElementById('resultado'));
});
</script>


 
<table class="nicetable_th" id="resultado" style="width:99%">
<thead>
<tr>
<th class=tabla_datos_titulo>ESTATUS</th>
<th class=tabla_datos_titulo>No. Factura</th>
<th class=tabla_datos_titulo>Fecha</th>
<th class=tabla_datos_titulo>Proveedor</th>
<th class=tabla_datos_titulo>Detalle</th>
<th class=tabla_datos_titulo>Sub-Total</th>
<th class=tabla_datos_titulo>ITBMS</th>
<th class=tabla_datos_titulo>Total</th>
<th class=tabla_datos_titulo>Saldo</th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<?php
$f_proveedor=$_GET['proveedor'];
$f_estatus=$_GET['f_estatus'];
$desde=$_GET['desde'];
$hasta=$_GET['hasta'];

if($f_proveedor!='null') $where .= " and a.copr_id in ($f_proveedor)";
if($f_estatus!='null') $where .= " and a.faes_id in ($f_estatus)";
if($desde!='') $where .= " and date_format(fact_fecha, '%Y%m%d') >= '$desde'";
if($hasta!='') $where .= " and date_format(fact_fecha, '%Y%m%d') <= '$hasta'";

$qsql ="SELECT fact_id, faes_nombre, fact_numero, fact_fecha, copr_nombre, fact_subtotal, fact_impuesto, fact_total, fact_saldo
FROM cons_facturas a, cons_proveedores b, cons_facturas_estados c 
WHERE a.copr_id=b.copr_id 
AND a.faes_id=c.faes_id 
$where
ORDER BY fact_numero desc, fact_fecha desc";

//echo nl2br($qsql);

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
{
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'faes_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'fact_numero'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'fact_fecha'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copr_nombre');?></td>
<td class=tabla_datos_iconos><a href='javascript:ver_detalle(<?php echo mysql_result($rs, $i, 'fact_id'); ?>)';><img src='imagenes/invoice.png' title="Ver Detalle" border=0 style="width:20px;height:20px"></a></td>
<td class="tabla_datos e-int_derecha"><?php echo number_format(mysql_result($rs, $i, 'fact_subtotal'),2); ?></td>
<td class="tabla_datos e-int_derecha"><?php echo number_format(mysql_result($rs, $i, 'fact_impuesto'),2); ?></td>
<td class="tabla_datos e-int_derecha"><?php echo number_format(mysql_result($rs, $i, 'fact_total'),2); ?></td>
<td class="tabla_datos e-int_derecha"><?php echo number_format(mysql_result($rs, $i, 'fact_saldo'),2);; ?></td>
<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'fact_id'); ?>)'; class='btn_borrar_factura'><img src='imagenes/trash.png' border=0></a></td>
<td class=tabla_datos_iconos><a href='javascript:abonar(<?php echo mysql_result($rs, $i, 'fact_id'); ?>)';><img src='imagenes/invoice.png' border=0 style="width:20px;height:20px" title="Pagar Factura"></a></td>
</tr>
<?php
$total += mysql_result($rs, $i, 'fact_total');
$tsaldo += mysql_result($rs, $i, 'fact_saldo');
$i++;
}
?>
<tr  data-sort-method='none'>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo></td>
<td class=tabla_datos_titulo>Total</td>
<td class="tabla_datos_titulo e-int_derecha"><?php echo number_format($total,2)?></td>
<td class="tabla_datos_titulo e-int_derecha"><?php echo number_format($tsaldo,2)?></td>
<td></td>
<td></td>
</tr>
</tbody>
</table>