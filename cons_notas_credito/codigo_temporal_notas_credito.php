<?php
include('../conexion.php');
include('../funciones.php');
//busco el último código temporal y le sumo 1
$qsql ="select cote_id from codigos_temporales_orden_compra limit 1";
$codigo=obtener_valor($qsql,'cote_id');
//saco el siguiente número de factura
// $factura = obtener_valor("select max(orco_numero)+ 1 factura from cons_notas_credito", "factura");

//ahora le sumo 1
mysql_query("update codigos_temporales_orden_compra set cote_id=cote_id+1");
echo $codigo . '||';
?>

