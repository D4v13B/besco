<?php include('conexion.php');

$i_cosu_id=$_POST['i_cosu_id'];

$i_coru_nombre=$_POST['i_coru_nombre'];

$i_coru_herramienta=$_POST['i_coru_herramienta'];

$qsql = "insert into construccion_rubros 

(

cosu_id, 

coru_nombre,

coru_herramienta

) 

values (

'$i_cosu_id[0]',

'$i_coru_nombre',

'$i_coru_herramienta')";

mysql_query($qsql);

?>