<?php   
include('conexion.php');

//$cliente = mysql_real_escape_string($_GET['cliente']);

$proveedor = $_REQUEST["proveedor"];

$qsql="SELECT copr_id, copr_nombre from cons_proveedores
where copr_nombre like '%$proveedor%' order by copr_nombre";
$rs = mysql_query($qsql);
$json=array();
 
while($row = mysql_fetch_array($rs)) 
{
	$json[]=array(
	'id'=> $row['copr_id'],
	'label'=> $row['copr_nombre']
	);
}
echo json_encode($json);
?>