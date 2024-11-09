<?php  
include('../conexion.php'); 
include('../funciones.php'); 

$id = $_GET['id'];

$qsql = "SELECT coru_nombre, fade_cantidad, fade_monto
FROM cons_facturas_detalles a, construccion_rubros b
WHERE fact_id='$id'
AND a.prod_id=b.coru_id";
$rs3=mysql_query($qsql);
$num3=mysql_num_rows($rs3);
$j=0;
?>
<table class=nicetable style="width:99%">
<tr>
<td>Producto</td>
<td>Cantidad</td>
<td>Monto</td>
<td>TOTAL</td>
</tr>
<?php
while($j<$num3)
{
?>
<tr>
<td><?php echo mysql_result($rs3,$j,'coru_nombre')?></td>
<td><?php echo mysql_result($rs3,$j,'fade_cantidad')?></td>
<td style="text-align:right"><?php echo number_format(mysql_result($rs3,$j,'fade_monto'),2)?></td>
<td style="text-align:right"><?php echo number_format(mysql_result($rs3,$j,'fade_monto')*mysql_result($rs3,$j,'fade_cantidad'),2)?></td>
<tr>
<?php
$j++;
}
?>
</table>