<?php   
include('conexion.php');

//$cliente = mysql_real_escape_string($_GET['cliente']);

$nivel = $_REQUEST["nivel"];
$proy_id = $_REQUEST["proy_id"];

$qsql="SELECT nive_id, nive_nivel
FROM cons_niveles 
WHERE nive_nivel like '%$nivel%'
AND proy_id='$proy_id'
order by nive_nivel";
$rs = mysql_query($qsql);
$json=array();
 
while($row = mysql_fetch_array($rs)) 
{
	$json[]=array(
	'id'=> $row['nive_id'],
	'label'=> $row['nive_nivel']
	);
}
echo json_encode($json);
?>