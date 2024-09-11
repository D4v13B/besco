<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cons_proveedores where copr_id=$id";
mysql_query($qsql);
?>

