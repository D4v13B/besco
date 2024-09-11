<?php 
include('../conexion.php');
include('../funciones.php');
$copr_id=$_POST['copr_id'];
$proy_id=$_POST['proy_id'];
$h_codigo=$_POST['h_codigo'];
$i_ingr_fecha=$_POST['i_ingr_fecha'];
$i_numero_factura=$_POST['i_numero_factura'];

$qsql = "INSERT INTO cons_orden_compra 
(crpr_id, 
orco_fecha,
orco_numero,
proy_id,
orco_fecha_creacion
) 
VALUES (
'$copr_id', 
'$i_ingr_fecha',
'$i_numero_factura',
'$proy_id',
NOW()
)";
mysql_query($qsql);
//despues que la creo debo ponerle el código final a todos los detalles
//saco el código recien creado
$ingr_id = mysql_insert_id();
$qsql ="update cons_orden_compra_detalles set orco_id=$ingr_id where orcd_temp_code=$h_codigo";
mysql_query($qsql);
?>
