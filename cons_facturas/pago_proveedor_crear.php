<?php
session_start();
$usuario=$_SESSION['login_user'];
include('../conexion.php');
include('../funciones.php');
include('../funciones_internas.php'); 
 
$pid = $_GET['pid'];
$monto=$_GET['monto'];
$recibo=$_GET['recibo'];
$fecha=$_GET['fecha'];
$concepto = $_GET['concepto'];

$forma = $_GET['forma'];
$banco = $_GET['banco'];
$tipo = $_GET['tipo'];
$cheque = $_GET['cheque'];
$arreglo = $_GET['arreglo'];


//si arreglo es 0 solo pasa una vez por aqui

if($arreglo==1)
	{

	$arr_tipo = explode("|", $tipo);
	$arr_monto = explode("|", $monto);

	$cantidad = count($arr_tipo);

	for ($i = 0; $i < $cantidad; $i++) 
		{
		crear_proveedor_pago($pid, $usuario, $fecha, $arr_monto[$i], $prerecibo, $recibo, $concepto, $arr_tipo[$i], $banco, $cheque, $arr_tipo[$i]);
		}
	}
else
	{
		//echo "$pid, $usuario, $fecha, $monto, $prerecibo, $recibo, $concepto, $tipo, $banco, $cheque, $tipo";
		crear_proveedor_pago($pid, $usuario, $fecha, $monto, $prerecibo, $recibo, $concepto, $tipo, $banco, $cheque, $tipo);
	}
?>