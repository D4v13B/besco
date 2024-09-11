<?php 
include('conexion.php');
include('funciones.php');

$id=$_GET['id'];
$m_cohp_monto=$_GET['m_cohp_monto'];
$m_cohp_cheque=$_GET['m_cohp_cheque'];
$m_banc_id=$_GET['m_banc_id'];
$m_pagado_a=$_GET['m_pagado_a'];
$m_fecha=$_GET['m_fecha'];
$m_cohp_comentario=$_GET['m_cohp_comentario'];

//saco el asesor

$qsql = "update construccion_pagos set 
copa_monto='$m_cohp_monto', 
copa_cheque='$m_cohp_cheque', 
banc_id='$m_banc_id', 
copa_pagado_a='$m_pagado_a', 
copa_fecha='$m_fecha', 
copa_comentario='$m_cohp_comentario'
where copa_id='$id'";
mysql_query($qsql);
?>