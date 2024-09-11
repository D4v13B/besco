<?php include('../conexion.php'); ?>
<div class=nicetable style="width:700px !important">
<table>
<tr>
<td class=tabla_datos_titulo>Proveedor</td>
<td class=tabla_datos_titulo>Fecha</td>
<td class=tabla_datos_titulo>Fecha Captura</td>
<td class=tabla_datos_titulo>Monto</td>
<td class=tabla_datos_titulo>Forma</td>
<td class=tabla_datos_titulo>Ingresado por</td>
<!--<td></td>-->
<td></td>
</tr>
<?php
$pid = $_GET['pid'];

$qsql = "SELECT prfp_id, prfp_fecha, prfp_monto, copr_nombre proveedor, 
(SELECT fopa_nombre FROM cons_forma_pago WHERE fopa_id=a.fopa_id) forma, prfp_fecha_creacion,
(SELECT usua_nombre FROM usuarios WHERE usua_id=a.usua_id) usua_nombre
FROM cons_facturas_pagos a, cons_facturas b, cons_proveedores c
WHERE a.fact_id=b.fact_id 
AND b.copr_id=c.copr_id 
AND a.fact_id='$pid'
ORDER BY prfp_fecha DESC";
//echo $qsql;

$rs_proy = mysql_query($qsql);
$num_proy = mysql_num_rows($rs_proy);
$i=0;

while ($i<$num_proy)
    {
?>
<tr class="tabla_datos_tr">
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'proveedor'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'prfp_fecha'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'prfp_fecha_creacion'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'prfp_monto'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'forma'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs_proy, $i, 'usua_nombre'); ?></td>
<td class=tabla_datos_iconos><a href="javascript:borrar_pago(<?php echo mysql_result($rs_proy, $i, 'prfp_id'); ?>)"><img src="imagenes/trash.png" border=0></a></td>
</tr>
<?php
$i++;
}
?>
</table>
</div>