<?php 
include('conexion.php');
include('funciones.php');

$id=$_GET['id'];

$qsql = "update cons_solicitudes set cose_id=2 where coso_id='$id'";
mysql_query($qsql);
?>