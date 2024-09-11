<?php 
include('../conexion.php');
include('../funciones.php');
$id = $_POST['id']; 
$id_campo = $_POST['id_campo'];
$valor = $_POST['valor'];
$i = $_POST['i'];

$id_campo = str_replace("p". $i . "_","",$id_campo);

$qsql = "update cons_orden_compra_detalles set 
$id_campo='$valor'
where orcd_id='$id'";
mysql_query($qsql);

//echo $qsql;
?>