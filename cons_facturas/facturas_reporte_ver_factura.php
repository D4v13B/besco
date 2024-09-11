<?php  
include('conexion.php'); 
include('funciones.php'); 

$id = $_GET['id'];
$fact_id = $_GET['fact_id'];

$qsql = "SELECT fahi_factura
FROM facturas_historial
WHERE cons_id='$id'
";

$rs=mysql_query($qsql);
$num=mysql_num_rows($rs);
$i=0;

if($num>0) 
{
	//saco el número de factura
	$numero = obtener_valor("select fact_numero from facturas where cons_id='$id' and fact_id='$fact_id'", "fact_numero");
	$contenido = mysql_result($rs, $i, 'fahi_factura');	
	$contenido = str_replace("[NUMERO]", $numero, $contenido);
	echo $contenido;
}
?>