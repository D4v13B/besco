<?php include('../conexion.php');
$id=$_GET['id'];
$qsql ="select * from cons_orden_compra_detalles
where orcd_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'orcd_id') . '||';
echo mysql_result($rs,$i,'orco_id') . '||';
echo mysql_result($rs,$i,'orcd_cantidad') . '||';
echo mysql_result($rs,$i,'orcd_precio') . '||';
echo mysql_result($rs,$i,'orcd_detalle') . '||';
echo mysql_result($rs,$i,'orcd_itbms') . '||';
?>
