<?php include('conexion.php'); ?> 
<table class=nicetable style='width:600px'>
<tr>
<td class=tabla_datos_titulo>Fecha</td>
<td class=tabla_datos_titulo>Monto</td>
<td class=tabla_datos_titulo>Cheque</td>
<td class=tabla_datos_titulo>Banco</td>
<td class=tabla_datos_titulo>Pagado a</td>
<td class=tabla_datos_titulo>Comentario</td>
<td class=tabla_datos_titulo_icono>&nbsp;</td>
<td class=tabla_datos_titulo_icono>&nbsp;</td>
</tr>
<?php
$copr_id=$_GET['copr_id'];

$qsql ="SELECT copa_id, copa_fecha, copa_monto, copa_cheque, banc_nombre, copa_pagado_a, copa_comentario
FROM construccion_pagos a, bancos b
WHERE a.banc_id=b.banc_id
AND a.copr_id=$copr_id
";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
{
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copa_fecha'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copa_monto'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copa_cheque'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'banc_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copa_pagado_a'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'copa_comentario'); ?></td>
<td class=tabla_datos_iconos><a href='javascript:editar(<?php echo mysql_result($rs, $i, 'copa_id'); ?>)';><img src='imagenes/modificar.png' border=0></a></td>
<td class=tabla_datos_iconos><a href='javascript:borrar(<?php echo mysql_result($rs, $i, 'copa_id'); ?>)';><img src='imagenes/trash.png' border=0></a></td>
</tr>
<?php
$i++;
}
?>
</table>