<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select prod_precio from productos where prod_id='$id'";
$rs=mysql_query($qsql); 
$num=mysql_num_rows($rs);
$i=0;
if($num>0) {
	echo mysql_result($rs,$i,'prod_precio');
} else
{ echo "0.00";}
?>
