<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cotizaciones_detalle where inde_id=$id";
mysql_query($qsql);
?>

