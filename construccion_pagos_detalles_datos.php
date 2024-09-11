<?php include('conexion.php');
$id=$_GET['id'];
$qsql ="select * from construccion_pagos
where copa_id='$id'";
$rs=mysql_query($qsql);
$i=0;
echo mysql_result($rs,$i,'copa_monto') . '||';
echo mysql_result($rs,$i,'copa_cheque') . '||';
echo mysql_result($rs,$i,'banc_id') . '||';
echo mysql_result($rs,$i,'copa_comentario') . '||';
echo mysql_result($rs,$i,'copa_pagado_a') . '||';
echo mysql_result($rs,$i,'copa_fecha') . '||';
?>