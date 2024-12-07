<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from construccion_subcategorias where cosu_id=$id";
mysql_query($qsql);
?>