<?php include('../conexion.php');
$id=$_POST['id'];
$m_prod_id=$_POST['m_prod_id'];
$m_inde_detalle=$_POST['m_inde_detalle'];
$m_inde_cantidad=$_POST['m_inde_cantidad'];
$m_inti_id=$_POST['m_inti_id'];
$m_ingr_precio=$_POST['m_ingr_precio'];
$m_inde_temp_code=$_POST['m_inde_temp_code'];
$m_orcd_con_itbms=$_POST['m_orcd_con_itbms'];
$qsql = "UPDATE cons_orden_compra_detalles SET 
orcd_cantidad='$m_inde_cantidad', 
orcd_detalle='$m_inde_detalle',
orcd_precio='$m_ingr_precio',
orcd_con_itbms='$m_orcd_con_itbms'
WHERE orcd_id='$id'";
mysql_query($qsql);

//tengo que recalcular los montos totales

?>