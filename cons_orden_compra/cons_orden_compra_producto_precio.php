<?php 
include('../conexion.php');
include('../funciones.php');

$id=$_GET['id'];
$proy_id=$_GET['proy_id'];
$qsql ="select coalesce(copr_monto,0) monto, count(*) from construccion_presupuesto
where proy_id='$proy_id'
AND coru_id='$id'";

echo obtener_valor($qsql, "monto");
?>