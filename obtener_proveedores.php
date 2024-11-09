<?php 

require "conexion.php";

$stmt = "SELECT * FROM cons_proveedores";

$rs = mysql_query($stmt);
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