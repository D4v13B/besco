<?php 
include('../conexion.php');
include('../funciones.php');
$i_prod_id=$_GET['prod_id'];
$i_inde_cantidad=$_POST['i_cantidad'];
$ingr_id=$_POST['ingr_id'];
$r_detalle=$_POST['r_detalle'];
$i_ingr_precio=$_POST['i_precio'];
$i_inde_temp_code=$_POST['h_codigo'];
//borro si ya existe
$qsql = "delete from cons_orden_compra_detalles where orcd_temp_code='$i_inde_temp_code' and prod_id='$i_prod_id'";
mysql_query($qsql);

	$qsql = "insert into cons_orden_compra_detalles 
	(
	prod_id, 
	orcd_cantidad, 
	orcd_precio, 
	orco_id,
	orcd_detalle,
	orcd_temp_code
	) 
	values (
	'$i_prod_id', 
	'$i_inde_cantidad', 
	'$i_ingr_precio', 
	'$ingr_id',
	'$r_detalle',
	'$i_inde_temp_code')";
	mysql_query($qsql);
?>