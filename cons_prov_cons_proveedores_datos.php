<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from cons_proveedores
where copr_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'copr_id') . '||';
echo mysql_result($rs,$i,'copr_nombre') . '||';
?>
