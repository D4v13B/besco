<?php include('../conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cons_orden_compra_detalles where orcd_id=$id";
mysql_query($qsql);
?>

