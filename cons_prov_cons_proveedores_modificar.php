<?php include('conexion.php');
$id=$_GET['id'];
$m_copr_nombre=$_POST['m_copr_nombre'];
$qsql = "update cons_proveedores set 
copr_nombre='$m_copr_nombre'
where copr_id='$id'";
mysql_query($qsql);
?>

