<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cons_niveles where nive_id=$id";
mysql_query($qsql);
?>