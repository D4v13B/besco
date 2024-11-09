<?php 
include('../conexion.php'); 
include('../funciones.php'); 

$pid = $_GET['pid'];
$id = obtener_valor("select fact_id from cons_facturas_pagos where prfp_id=$pid","fact_id");

$qsql ="delete from cons_facturas_pagos where prfp_id=$pid";

//echo $qsql;

mysql_query($qsql);

$qsql = "UPDATE cons_facturas a SET fact_saldo=fact_total-(SELECT COALESCE(SUM(prfp_monto),0) FROM cons_facturas_pagos WHERE fact_id=a.fact_id)
 WHERE fact_id='$id'";
mysql_query($qsql);

$qsql = "select fact_saldo, fact_total from cons_facturas where fact_id='$id'";
$rs = mysql_query($qsql);
$i=0;
$saldo = mysql_result($rs, $i, 'fact_saldo');
$monto = mysql_result($rs, $i, 'fact_total');

if($monto==$saldo)
{
	$qsql = "UPDATE cons_facturas a SET faes_id=1 where fact_id='$id'";
	mysql_query($qsql);
}
if($monto>$saldo)
{
	$qsql = "UPDATE cons_facturas a SET faes_id=2 where fact_id='$id'";
	mysql_query($qsql);
}
if($saldo<=0)
{
	$qsql = "UPDATE cons_facturas a SET faes_id=3 where fact_id='$id'";
	mysql_query($qsql);
}
?>
