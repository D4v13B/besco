<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from construccion_subcategorias
where cosu_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'cosu_id') . '||';
echo mysql_result($rs,$i,'coca_id') . '||';
echo mysql_result($rs,$i,'cosu_nombre') . '||';
?>