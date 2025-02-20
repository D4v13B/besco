<?php include('conexion.php'); ?> 

<table class=nicetable>

<tr>

<td class=tabla_datos_titulo>Categoría</td>

<td class=tabla_datos_titulo>Sub-categoría</td>

<td class=tabla_datos_titulo>Inventario</td>

<td class=tabla_datos_titulo>Herramienta</td>

<td class=tabla_datos_titulo_icono></td>

<td class=tabla_datos_titulo_icono></td>

</tr>

<?php

$nombre=$_GET['nombre'];


$f_coru_herramienta = $_GET["f_coru_herramienta"];
$f_coru_id = (isset($_GET["f_coru_id"]) and $_GET["f_coru_id"] != 'null') ? $_GET["f_coru_id"] : "";


$where  = "";
$where .= ($f_coru_id != '') ? " AND coru_herramienta = $f_coru_herramienta " : "";
$where .= ($f_coru_id != '') ? " AND coru_id IN ($f_coru_id) " : "";


$qsql ="SELECT c.coca_nombre, b.cosu_nombre, a.coru_id, a.coru_nombre,

if(coru_herramienta=1,'SI','NO') herramienta

FROM construccion_rubros a, construccion_subcategorias b, construccion_categorias c

WHERE a.cosu_id=b.cosu_id

AND b.coca_id=c.coca_id

$where

ORDER BY coca_nombre, cosu_nombre, coru_nombre";



$rs = mysql_query($qsql);

$num = mysql_num_rows($rs);

$i=0;

while ($i<$num)

{

?>

<tr class='tabla_datos_tr'>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coca_nombre'); ?></td>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosu_nombre'); ?></td>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coru_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'herramienta'); ?></td>

<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'coru_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>

<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'coru_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>

</tr>

<?php

$i++;

}

?>

</table>



