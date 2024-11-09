<?php 
include('../conexion.php');
include('../funciones.php');
$id=$_POST['id'];
$i_orco_comentario=$_POST['i_orco_comentario'];

$qsql = "UPDATE cons_orden_compra SET orco_comentario = '$i_orco_comentario' WHERE orco_id = $id";

//echo $qsql;
mysql_query($qsql);

?>




