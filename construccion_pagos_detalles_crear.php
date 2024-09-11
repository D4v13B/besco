<?php 
session_start();
$user_check=$_SESSION['login_user'];

include('conexion.php');
include('funciones.php');

$copr_id=$_GET['copr_id'];

$i_cohp_monto=$_GET['i_cohp_monto'];
$i_cohp_cheque=$_GET['i_cohp_cheque'];
$i_banc_id=$_GET['i_banc_id'];
$i_pagado_a=$_GET['i_pagado_a'];
$i_fecha=$_GET['i_fecha'];
$i_cohp_comentario=$_GET['i_cohp_comentario'];
$qsql = "insert into construccion_pagos
(copr_id, copa_monto, copa_cheque, copa_fecha, copa_fecha_registro, usua_id, banc_id, copa_pagado_a, copa_comentario) 
values (
'$copr_id', 
'$i_cohp_monto', 
'$i_cohp_cheque', 
'$i_fecha',
now(),
'$user_check',
'$i_banc_id',
'$i_pagado_a', 
'$i_cohp_comentario')";
mysql_query($qsql);
//echo $qsql;
?>