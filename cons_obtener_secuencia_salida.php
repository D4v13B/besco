<?php 
include('conexion.php');
include('funciones.php');

$secuencia = obtener_valor("select coss_id from construccion_salidas_secuencia", "coss_id");

echo $secuencia;
$n_secuencia = $secuencia+1;

$qsql = "update construccion_salidas_secuencia set coss_id='$n_secuencia'";
mysql_query($qsql);

?>