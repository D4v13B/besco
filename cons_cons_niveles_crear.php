<?php include('conexion.php');
$i_proy_id=$_POST['i_proy_id'];
$i_nive_nivel=$_POST['i_nive_nivel'];
$qsql = "insert into cons_niveles 
(
proy_id
, 
nive_nivel
) 
values (
'$i_proy_id', 
'$i_nive_nivel')";
mysql_query($qsql);
?>

