<?php include('conexion.php');
$id=$_GET['id'];
$m_cosu_id=$_POST['m_cosu_id'];
$m_coru_nombre=$_POST['m_coru_nombre'];
$m_coru_herramienta=$_POST['m_coru_herramienta'];
$qsql = "update construccion_rubros set 
cosu_id='$m_cosu_id[0]', 
coru_nombre='$m_coru_nombre',
coru_herramienta ='$m_coru_herramienta'
where coru_id='$id'";
mysql_query($qsql);
?>