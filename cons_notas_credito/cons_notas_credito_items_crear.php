<?php 
include('../conexion.php');
include('../funciones.php');
$i_prod_id=$_GET['prod_id'];
$i_inde_cantidad=$_POST['i_cantidad'];
$ingr_id=$_POST['ingr_id'];
$r_detalle=$_POST['r_detalle'];
$i_ingr_precio=$_POST['i_precio'];
$i_inde_temp_code=$_POST['h_codigo'];
$i_itbms = $_POST["i_itbms"];
//borro si ya existe
$qsql = "delete from cons_notas_credito_detalle where orcd_temp_code='$i_inde_temp_code' and prod_id='$i_prod_id'";
mysql_query($qsql);

	$qsql = "insert into cons_notas_credito_detalle
	(
	prod_id,
   nocr_cantidad,
   nocr_precio,
   nocr_id,
   nocr_detalle,
   nocr_temp_code,
	nocr_itbms,
	orco_id
	) 
	values (
	'$i_prod_id', 
	'$i_inde_cantidad', 
	'$i_ingr_precio', 
	'$ingr_id',
	'$r_detalle',
	'$i_inde_temp_code',
	'$i_itbms'
	)";
	mysql_query($qsql);
?>