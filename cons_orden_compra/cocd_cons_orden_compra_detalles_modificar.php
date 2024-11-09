<?php include('../conexion.php');
$id=$_GET['id'];
$m_orco_id=$_POST['m_orco_id'];
$m_orcd_cantidad=$_POST['m_orcd_cantidad'];
$m_orcd_precio=$_POST['m_orcd_precio'];
$m_orcd_detalle=$_POST['m_orcd_detalle'];
$m_orcd_itbms=$_POST['m_orcd_itbms'];
$qsql = "update cons_orden_compra_detalles set 
orco_id='$m_orco_id', 
orcd_cantidad='$m_orcd_cantidad', 
orcd_precio='$m_orcd_precio', 
orcd_detalle='$m_orcd_detalle', 
orcd_itbms='$m_orcd_itbms'
where orcd_id='$id'";
mysql_query($qsql);
?>

