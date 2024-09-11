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

if($inventario!='' && $cantidad!='')
	{
		//INSERTO EL ENCABEZADO Y COMO ES UNIQUE IGNORA LOS FUTUROS
		$qsql = "insert into cons_solicitudes (coso_numero, proy_id, coso_fecha,usua_id) values (
		'$secuencia',
		'$proy_id',
		now(),
		'$user_check');";
		mysql_query($qsql);
		$qsql = "delete from cons_solicitudes_detalles where coru_id='$inventario' and coso_numero='$secuencia'";
		mysql_query($qsql);
		
		//INSERTO EL DETALLE
		$qsql = "insert into cons_solicitudes_detalles (coso_numero, coru_id, cosd_cantidad) values (
		'$secuencia',
		'$inventario',
		'$cantidad');";
		mysql_query($qsql);
	}
}
?>