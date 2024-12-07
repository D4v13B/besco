<?php include('./conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from cons_pre_pagos where copp_id=$id";
mysql_query($qsql);
?>

