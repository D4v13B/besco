<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from cons_niveles
where nive_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'nive_id') . '||';
echo mysql_result($rs,$i,'proy_id') . '||';
echo mysql_result($rs,$i,'nive_nivel') . '||';
?>
