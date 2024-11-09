<?php include('../conexion.php');
$i_orco_id=$_POST['i_orco_id'];
$i_orcd_cantidad=$_POST['i_orcd_cantidad'];
$i_orcd_precio=$_POST['i_orcd_precio'];
$i_orcd_detalle=$_POST['i_orcd_detalle'];
$i_orcd_itbms=$_POST['i_orcd_itbms'];
$qsql = "insert into cons_orden_compra_detalles 
(
orco_id
, 
orcd_cantidad
, 
orcd_precio
, 
orcd_detalle
, 
orcd_itbms
) 
values (
'$i_orco_id', 
'$i_orcd_cantidad', 
'$i_orcd_precio', 
'$i_orcd_detalle', 
'$i_orcd_itbms')";
mysql_query($qsql);
?>

