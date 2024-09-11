<?php 
include('../conexion.php'); 
$id=$_GET['id'];
?> 
<table class=nicetable>
<tr>
<td class=tabla_datos_titulo>Producto</td>
<td class=tabla_datos_titulo>Detalle</td>
<td class=tabla_datos_titulo>Cantidad</td>
<td class=tabla_datos_titulo_icono>Precio</td>
<td class=tabla_datos_titulo_icono>Total</td>
<td class=tabla_datos_titulo_icono>ITBMS</td>
<td class=tabla_datos_titulo_icono></td>
<td class=tabla_datos_titulo_icono></td>
</tr>
<?php
$qsql ="SELECT orcd_id, coru_nombre, orcd_detalle, orcd_cantidad, orcd_precio,
IF(orcd_con_itbms=1,'SI','NO') con_itbms
FROM cons_orden_compra_detalles a, construccion_rubros b
WHERE a.prod_id=b.coru_id
AND orcd_temp_code='$id'
";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
$mtotal=0;
$ctotal=0;
while ($i<$num)
{
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coru_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'orcd_detalle'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'orcd_cantidad'); ?></td>
<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'orcd_precio'),4); ?></td>
<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'orcd_precio')*mysql_result($rs, $i, 'orcd_cantidad'),2); ?></td>
<td class=tabla_datos_iconos style="text-align:center"><?php echo mysql_result($rs, $i, 'con_itbms'); ?></td>
<td class=tabla_datos_iconos><a href='javascript:editar_item(<?php echo mysql_result($rs, $i, 'orcd_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>
<td class=tabla_datos_iconos><a href='javascript:borrar_item(<?php echo mysql_result($rs, $i, 'orcd_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>
</tr>
<?php
$ctotal += mysql_result($rs, $i, 'orcd_cantidad');
$mtotal += mysql_result($rs, $i, 'orcd_precio')*mysql_result($rs, $i, 'orcd_cantidad');
$i++;
}
?>
<tr>
<td></td>
<td></td>
<td style="text-align:center"><?php echo number_format($ctotal,2)?></td>
<td></td>
<td style="text-align:right"><?php echo number_format($mtotal,2)?></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>