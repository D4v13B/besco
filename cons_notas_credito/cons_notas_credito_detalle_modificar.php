<?php include('../conexion.php');
$id=$_POST['id'];
$m_prod_id=$_POST['m_prod_id'];
$m_inde_detalle=$_POST['m_inde_detalle'];
$m_inde_cantidad=$_POST['m_inde_cantidad'];
$m_inti_id=$_POST['m_inti_id'];
$m_ingr_precio=$_POST['m_ingr_precio'];
$m_inde_temp_code=$_POST['m_inde_temp_code'];
$m_itbms=$_POST['m_itbms'];
$qsql = "UPDATE cons_notas_credito_detalle SET 
nocr_cantidad='$m_inde_cantidad', 
nocr_detalle='$m_inde_detalle',
nocr_precio='$m_ingr_precio',
nocr_itbms='$m_itbms'
WHERE nocd_id='$id'";
echo $qsql;
mysql_query($qsql);

//tengo que recalcular los montos totales

?>