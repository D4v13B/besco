<?php include('./conexion.php');
$id=$_GET['id'];
$qsql ="select * from cons_pre_pagos
where copp_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'copp_id') . '||';
echo mysql_result($rs,$i,'prov_id') . '||';
echo mysql_result($rs,$i,'copp_monto') . '||';
echo mysql_result($rs,$i,'copp_fecha') . '||';
?>
