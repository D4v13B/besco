<?php 

include('conexion.php'); 
include('funciones.php'); 

$id = $_GET['id'];

$sql = "DELETE FROM cons_solicitudes_detalles WHERE cosd_id =". $id;
mysql_query($sql);


?>