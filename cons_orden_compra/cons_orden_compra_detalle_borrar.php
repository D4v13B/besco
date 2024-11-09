<?php

include "../conexion.php";

$id = $_GET["id"];
mysql_query("DELETE FROM cons_orden_compra_detalles WHERE orcd_id=$id");

?>