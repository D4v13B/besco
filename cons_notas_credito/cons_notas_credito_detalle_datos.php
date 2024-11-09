<?php 
include('../conexion.php');
include('../funciones.php');
$id=$_GET['id'];
$proy_id=$_GET['proy_id'];
$qsql ="select * from cons_notas_credito_detalle
where nocd_id='$id'";

$rs=mysql_query($qsql);
$i=0;
$coru_id = mysql_result($rs,$i,'prod_id');
// $disponible = obtener_valor("select coalesce(copr_pendientes,0) pendientes, count(*) from construccion_presupuesto
// where proy_id='$proy_id'
// AND coru_id='$coru_id'", "pendientes");

echo mysql_result($rs,$i,'nocd_id') . '||';
echo mysql_result($rs,$i,'prod_id') . '||';
echo mysql_result($rs,$i,'nocr_cantidad') . '||';
echo mysql_result($rs,$i,'nocr_id') . '||';
echo mysql_result($rs,$i,'nocr_precio') . '||';
echo mysql_result($rs,$i,'nocr_temp_code') . '||';
echo mysql_result($rs,$i,'nocr_detalle') . '||';
echo "0" . '||';
echo mysql_result($rs,$i,'nocr_itbms') . '||';
?>
