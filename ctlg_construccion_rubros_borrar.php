<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from construccion_rubros where coru_id=$id";
mysql_query($qsql);
?>