<?php 

include('../conexion.php'); 

include('../funciones_ui.php');

?> 

<script src='jquery/sorter/tablesort.min.js'></script>

<script src='jquery/sorter/sorts/tablesort.number.min.js'></script>

<script src='jquery/sorter/sorts/tablesort.date.min.js'></script>

<script>

$(function () {

	table = document.getElementById('proveedores');

	sort = new Tablesort(table);

	//alert(table);

});

</script>

<table class=nicetable_th id=proveedores style="width:99%">

<thead>

<tr>

<?php echo armar_encabezado_sorter("ID,Proveedor,Referencia,Fecha,Forma de Pago,Registrado por, Fecha de regristro, #Referencia de ACH, Monto, Total de pago agrupado")?>

</tr>

</thead>

<tbody>

<?php

$desde=$_GET['desde'];

$hasta=$_GET['hasta'];

$proveedor=$_GET['proveedor'];

$where="";



if($desde!='') $where .= " AND prfp_fecha>='$desde'";

if($hasta!='') $where .= " AND prfp_fecha<='$hasta'";

if($proveedor!='null') $where .= " AND b.copr_id in ($proveedor)";





$qsql ="SELECT prfp_id, fact_numero, prfp_monto, DATE_FORMAT(prfp_fecha, '%Y-%m-%d') fecha, fopa_nombre, copr_nombre, prfp_ach_refrencia,

(SELECT usua_nombre_completo FROM usuarios WHERE usua_id=a.usua_id) registrado, prfp_fecha_creacion,

(SELECT SUM(prfp_monto) FROM cons_facturas_pagos z WHERE a.prfp_numero = z.prfp_numero ORDER BY a.prfp_numero) total_pago_agrupado

FROM cons_facturas_pagos a, cons_facturas b, cons_forma_pago c, cons_proveedores d

WHERE a.fact_id=b.fact_id

AND a.fopa_id=c.fopa_id

AND b.copr_id=d.copr_id

$where";

//echo nl2br($qsql);

$rs = mysql_query($qsql);

$num = mysql_num_rows($rs);

$i=0;

while ($i<$num)

{

	$fecha=mysql_result($rs, $i, 'fecha');

	$fecha=str_replace("-","",$fecha);

?>

<tr class='tabla_datos_tr'>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'prfp_id'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'copr_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'fact_numero'); ?></td>

<td class=tabla_datos style="text-align:center" data-sort='<?php echo $fecha; ?>'><?php echo mysql_result($rs, $i, 'fecha'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'fopa_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'registrado'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'prfp_fecha_creacion'); ?></td>

<td class=tabla_datos style="text-align:right"><?php echo (mysql_result($rs, $i, 'prfp_ach_refrencia')); ?></td>

<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'prfp_monto'),2); ?></td>

<td class=tabla_datos style="text-align:right"><?php echo number_format(mysql_result($rs, $i, 'total_pago_agrupado'),2); ?></td>

</tr>

<?php

$ttotal += mysql_result($rs, $i, 'prfp_monto');

$i++;

}

?>

<!-- <tr data-sort-method='none'>

<td class=tabla_datos_titulo></td>

<td class=tabla_datos_titulo></td>

<td class=tabla_datos_titulo></td>

<td class=tabla_datos_titulo></td>

<td class=tabla_datos_titulo>  </td>

<td class=tabla_datos_titulo> </td>

<td class=tabla_datos_titulo>  </td>

<td class=tabla_datos_titulo>  </td>

<td class=tabla_datos_titulo style="text-align:right"><?php echo number_format($ttotal, 2)?></td>

</tr> -->

</tbody>

</table>