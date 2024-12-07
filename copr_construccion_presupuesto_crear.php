<?php 
include('conexion.php');
include('funciones.php');

$i_proy_id=$_POST['i_proy_id'];
$i_copr_fecha=$_POST['i_copr_fecha'];
$i_coru_id=$_POST['i_coru_id'];
$i_copr_cantidad=$_POST['i_copr_cantidad'];
$i_copr_monto=$_POST['i_copr_monto'];
$i_copr_nota=$_POST['i_copr_nota'];

$cosu_id = obtener_valor("select cosu_id from construccion_rubros where coru_id='$i_coru_id'","cosu_id");

$qsql = "insert into construccion_presupuesto 
(
proy_id, 
copr_fecha, 
cosu_id, 
coru_id, 
copr_cantidad, 
copr_monto,
copr_pendientes,
copr_nota
) 
values (
'$i_proy_id', 
'$i_copr_fecha', 
'$cosu_id', 
'$i_coru_id', 
'$i_copr_cantidad', 
'$i_copr_monto',
'$i_copr_cantidad',
'$i_copr_nota')";
mysql_query($qsql);

//echo nl2br($qsql);
?>