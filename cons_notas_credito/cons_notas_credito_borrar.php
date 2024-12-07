<?php include('../conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cons_notas_credito where nocr_id=$id";
mysql_query($qsql);
?>

