<?php   
include('conexion.php');

//$cliente = mysql_real_escape_string($_GET['cliente']);

$inventario = $_REQUEST["inventario"];

$qsql="SELECT coru_id, concat(c.coca_nombre, '-', b.cosu_nombre, '-', a.coru_nombre) rubro
FROM construccion_rubros a, construccion_subcategorias b, construccion_categorias c
WHERE a.cosu_id=b.cosu_id
  AND b.coca_id=c.coca_id
  AND coru_nombre like '%$inventario%' order by coru_nombre";
$rs = mysql_query($qsql);
$json=array();
 
while($row = mysql_fetch_array($rs)) 
{
	$json[]=array(
	'id'=> $row['coru_id'],
	'label'=> $row['rubro']
	);
}
echo json_encode($json);
?>