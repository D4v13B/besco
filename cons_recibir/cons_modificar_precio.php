<?php 

include "../conexion.php";
include "../funciones.php";

$orcd_id = $_POST["orcd_id"];
$val = $_POST["val"];

echo $sql = "UPDATE cons_orden_compra_detalles SET orcd_precio = $val WHERE orcd_id = $orcd_id";
mysql_query($sql);

?>