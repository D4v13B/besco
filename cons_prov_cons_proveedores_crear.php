<?php include('conexion.php');
$i_copr_nombre=$_POST['i_copr_nombre'];
$qsql = "insert into cons_proveedores 
(
copr_nombre
) 
values (
'$i_copr_nombre')";
mysql_query($qsql);
?>

