<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cotizaciones where ingr_id=$id";
mysql_query($qsql);
?>

