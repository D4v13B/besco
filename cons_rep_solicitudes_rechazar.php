<?php 

include "./conexion.php";

$id = $_GET["id"];

echo $sql = "DELETE FROM cons_solicitudes WHERE coso_id = $id";

mysql_query($sql);   

?>