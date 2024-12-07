<?php session_start(); 
include('conexion.php');
$usua_id = $_SESSION["login_user"];

$i_prov_id=$_POST['i_prov_id'];
$i_copp_monto=$_POST['i_copp_monto'];
$i_copp_fecha=$_POST['i_copp_fecha'];
$qsql = "insert into cons_pre_pagos 
(
prov_id
, 
copp_monto
,
copp_saldo
,
copp_fecha
,
usua_id
) 
values (
'$i_prov_id', 
'$i_copp_monto',
'$i_copp_monto',
'$i_copp_fecha',
'$usua_id')";
mysql_query($qsql);
?>