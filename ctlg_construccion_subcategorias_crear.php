<?php include('conexion.php');

$i_coca_id=$_POST['i_coca_id'];

$i_cosu_nombre=$_POST['i_cosu_nombre'];

$qsql = "insert into construccion_subcategorias 

(

coca_id, cosu_nombre

) 

values (

'$i_coca_id', 

'$i_cosu_nombre')";

mysql_query($qsql);

?>