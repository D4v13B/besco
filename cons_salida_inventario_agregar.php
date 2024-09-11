<?php 
session_start();
$user_check=$_SESSION['login_user'];

if($user_check!='')
{
include('conexion.php');
include('funciones.php');

$inventario = $_POST['inventario'];
$cantidad = $_POST['cantidad'];
$secuencia = $_POST['secuencia'];
$proy_id = $_POST['proy_id'];
$nive_id = $_POST['nive_id'];
$responsable = $_POST['responsable'];

if($inventario!='' && $cantidad!='')
	{
		//INSERTO EL ENCABEZADO Y COMO ES UNIQUE IGNORA LOS FUTUROS
		$qsql = "insert into cons_salidas (cosa_numero, proy_id, cosa_fecha,usua_id, nive_id, cosa_responsable) values (
		'$secuencia',
		'$proy_id',
		now(),
		'$user_check',
		'$nive_id',
		'$responsable'
		);";
		mysql_query($qsql);
		
		//SI YA EXISTE LA BORRO
		$qsql = "delete from cons_salidas_detalles where cosa_numero='$secuencia' and coru_id='$inventario'";
		mysql_query($qsql);
		//INSERTO EL DETALLE
		$qsql = "insert into cons_salidas_detalles (cosa_numero, coru_id, cosd_cantidad) values (
		'$secuencia',
		'$inventario',
		'$cantidad');";
		mysql_query($qsql);
	}
}
?>