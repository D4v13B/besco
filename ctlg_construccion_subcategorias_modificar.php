<?php include('conexion.php');
$id=$_GET['id'];
$m_coca_id=$_POST['m_coca_id'];
$m_cosu_nombre=$_POST['m_cosu_nombre'];
$qsql = "update construccion_subcategorias set 
coca_id='$m_coca_id', 
cosu_nombre='$m_cosu_nombre'
where cosu_id='$id'";
mysql_query($qsql);
?>