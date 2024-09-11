<?php include('conexion.php'); 
$id = $_GET['id'];
$qsql ="delete from construccion_pagos where copa_id=$id";
mysql_query($qsql);
?>