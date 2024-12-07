<?php   
include('conexion.php');

//$cliente = mysql_real_escape_string($_GET['cliente']);

$inventario = $_REQUEST["inventario"];
$proy_id = $_GET["proy_id"];

$qsql="SELECT coru_id, concat(c.coca_nombre, '-', b.cosu_nombre, '-', a.coru_nombre, 'DISP:',
(SELECT COALESCE(SUM(copr_inventario), 0) AS inventario
FROM construccion_presupuesto
WHERE proy_id = '$proy_id' AND coru_id = a.coru_id)
) rubro
FROM construccion_rubros a, construccion_subcategorias b, construccion_categorias c
WHERE ((a.cosu_id=b.cosu_id
  AND b.coca_id=c.coca_id) 
  OR coru_herramienta = 1)
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