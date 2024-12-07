<?php include('./conexion.php');
$id=$_GET['id'];
$m_prov_id=$_POST['m_prov_id'];
$m_copp_monto=$_POST['m_copp_monto'];
$m_copp_fecha=$_POST['m_copp_fecha'];
$qsql = "update cons_pre_pagos set 
prov_id='$m_prov_id', 
copp_monto='$m_copp_monto', 
copp_fecha='$m_copp_fecha'
where copp_id='$id'";
mysql_query($qsql);
?>

