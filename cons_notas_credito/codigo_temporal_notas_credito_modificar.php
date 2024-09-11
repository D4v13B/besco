<?php
include('../conexion.php');
include('../funciones.php');
$nocr_id = $_GET['id'];

$qsql ="select nocr_temp_code from cons_notas_credito where nocr_id='$nocr_id'";
$rs=mysql_query($qsql);

if(!$rs){
	die("Hola 2222");
}

$num=mysql_num_rows($rs);
$i=0;

if($num>0)
{
	$codigo=mysql_result($rs,$i,'nocr_temp_code');
}
else
{
	$qsql ="select cote_id from codigos_temporales_orden_compra";
	$codigo=obtener_valor($qsql,'cote_id');
	mysql_query("update codigos_temporales_orden_compra set cote_id=cote_id+1");
}
//ahora le sumo 1
echo $codigo;
?>