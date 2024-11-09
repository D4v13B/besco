<?php

include "../conexion.php";
$id = $_GET["id"];

$qsql = "DELETE FROM cons_notas_credito_detalle WHERE nocd_id = $id";
mysql_query($qsql);


?>