<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from construccion_rubros
where coru_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'coru_id') . '||';
echo mysql_result($rs,$i,'cosu_id') . '||';
echo mysql_result($rs,$i,'coru_nombre') . '||';
echo mysql_result($rs,$i,'coru_herramienta') . '||';
?>