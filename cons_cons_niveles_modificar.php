<?php include('conexion.php');
$id=$_GET['id'];
$m_proy_id=$_POST['m_proy_id'];
$m_nive_nivel=$_POST['m_nive_nivel'];
$qsql = "update cons_niveles set 
proy_id='$m_proy_id', 
nive_nivel='$m_nive_nivel'
where nive_id='$id'";
mysql_query($qsql);
?>

