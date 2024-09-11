<?php 
include('conexion.php'); 
$id = $_GET['id'];

$qsql ="UPDATE consolidados SET cons_facturado=0 WHERE cons_id='$id'";
mysql_query($qsql);

$qsql ="DELETE FROM facturas_historial WHERE cons_id = '$id'";
mysql_query($qsql);

$qsql ="DELETE FROM facturas WHERE cons_id = '$id'";
mysql_query($qsql);

$qsql ="DELETE FROM facturas_detalles WHERE cons_id = '$id'";
mysql_query($qsql);
?>