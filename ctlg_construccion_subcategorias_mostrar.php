<?php include('conexion.php'); ?> 

<table class=nicetable>

<tr>

<td class=tabla_datos_titulo>Categoria</td>

<td class=tabla_datos_titulo>Subcategoria</td>

<td class=tabla_datos_titulo_icono>&nbsp;</td>

<td class=tabla_datos_titulo_icono>&nbsp;</td>

</tr>

<?php

$nombre=$_GET['nombre'];

$qsql ="select cosu_id, cosu_nombre, b.coca_nombre from construccion_subcategorias a, construccion_categorias b
where a.coca_id=b.coca_id";



$rs = mysql_query($qsql);

$num = mysql_num_rows($rs);

$i=0;

while ($i<$num)

{

?>

<tr class='tabla_datos_tr'>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coca_nombre'); ?></td>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosu_nombre'); ?></td>

<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'cosu_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>

<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'cosu_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>

</tr>

<?php

$i++;

}

?>

</table>



