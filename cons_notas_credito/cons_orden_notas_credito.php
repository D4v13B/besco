<?php 
include('../conexion.php');
include('../funciones.php');
$id=$_GET['id'];

$qsql = "UPDATE cons_notas_credito SET orco_aprobada=IF(orco_aprobada=1,0,1) WHERE orco_id='$id'";
mysql_query($qsql);

?>