<?php 
include('conexion.php'); 
include('funciones.php'); 
$id = $_GET[id];
$copr_id = $_GET['copr_id'];

$coso_numero= obtener_valor("select coso_numero from cons_solicitudes where coso_id='$id'","coso_numero");

$qsql = "update cons_solicitudes_detalles set copr_id='$copr_id' where coso_numero='$coso_numero'";
mysql_query($qsql);
?> 

