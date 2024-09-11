<?php 
include('conexion.php');
include('funciones.php');
$id=$_POST['id'];
$m_clie_id=$_POST['i_clie_id'];
$m_ingr_fecha=$_POST['i_ingr_fecha'];
$i_numero_factura=$_POST['i_numero_factura'];

$qsql = "update cotizaciones set 
clie_id='$m_clie_id', 
ingr_fecha='$m_ingr_fecha',
ingr_numero_factura=$i_numero_factura
where ingr_id='$id'";
//echo $qsql;
mysql_query($qsql);

?>




