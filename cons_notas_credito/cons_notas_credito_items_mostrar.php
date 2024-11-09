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
$qsql ="SELECT nocr_id, coru_nombre, nocr_detalle, nocr_cantidad, nocr_precio, nocr_itbms, nocd_id
FROM cons_notas_credito_detalle a, construccion_rubros b
WHERE a.prod_id=b.coru_id
  AND nocr_temp_code='$id'
";

// echo nl2br($qsql);

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
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'nocr_detalle'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'nocr_cantidad'); ?></td>
<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'nocr_precio'),4); ?></td>
<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'nocr_precio')*mysql_result($rs, $i, 'nocr_cantidad'),2); ?></td>
<td class=tabla_datos_iconos style="text-align:center"><?php echo mysql_result($rs, $i, 'nocr_itbms'); ?></td>
<td class=tabla_datos_iconos><a href='javascript:editar_item(<?php echo mysql_result($rs, $i, 'nocd_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>
<td class=tabla_datos_iconos><a href='javascript:borrar_item(<?php echo mysql_result($rs, $i, 'nocd_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>
</tr>
<?php
$ctotal += mysql_result($rs, $i, 'nocr_cantidad');
$mtotal += mysql_result($rs, $i, 'nocr_precio')*mysql_result($rs, $i, 'nocr_cantidad');
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