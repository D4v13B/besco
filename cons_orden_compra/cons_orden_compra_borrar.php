<?php 

include('../conexion.php');

include('../funciones.php');

$id = $_GET["id"];

$qsl = "DELETE FROM cons_orden_compra WHERE orco_id = $id";

mysql_query($qsl);

?>