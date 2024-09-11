<?php 
session_start();
include('conexion.php');
include('funciones.php');

$proyecto = $_GET['proyecto'];

$where='';

?>
<table class=nicetable>
<tr>
<td class=tabla_datos_titulo>Proyecto</td>
<td class=tabla_datos_titulo>Categor&iacute;a</td>
<td class=tabla_datos_titulo>Sub-Categor&iacute;a</td>
<td class=tabla_datos_titulo>Rubro</td>
<td class=tabla_datos_titulo>Presupuesto</td>
<td class=tabla_datos_titulo>Utilizado</td>
<td class=tabla_datos_titulo>%</td>
<td class=tabla_datos_titulo>Disponible</td>
<td class=tabla_datos_icono style="width:30px !important"></td>
</tr>
<?php
if($proyecto!='null') $where .= " and a.proy_id in ($proyecto)";

$qsql ="SELECT a.copr_id, coca_nombre, cosu_nombre, coru_nombre, copr_monto, proy_nombre,
(select COALESCE(sum(copa_monto),0) from construccion_pagos where copr_id=a.copr_id) pagos
FROM construccion_presupuesto a, construccion_rubros b, construccion_subcategorias c, construccion_categorias d, proyectos e
WHERE a.coru_id=b.coru_id
AND a.cosu_id=b.cosu_id
AND b.cosu_id=c.cosu_id
AND c.coca_id=d.coca_id
AND a.proy_id=e.proy_id
$where
Order by proy_nombre, coca_nombre, cosu_nombre, coru_nombre
";

//echo $qsql;

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
    {
	$presupuesto=mysql_result($rs, $i, 'copr_monto');
	$pagos=mysql_result($rs, $i, 'pagos');
	$porcentaje = $pagos/$presupuesto*100;
	$disponible = $presupuesto-$pagos;
?>
<tr class="tabla_datos_tr">
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'proy_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coca_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosu_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coru_nombre'); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format(mysql_result($rs, $i, 'copr_monto'),2); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format(mysql_result($rs, $i, 'pagos'),2); ?></td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format($porcentaje,2); ?>%</td>
<td class=tabla_datos style="text-align:right !important"><?php echo number_format($disponible,2); ?></td>
<td class=tabla_datos_icono><a href="javascript:pagos(<?php echo mysql_result($rs, $i, 'copr_id'); ?>);"><img src="imagenes/datos.png" border=0></a></td>
</tr>
<?php
$i++;
}
?>
</table>