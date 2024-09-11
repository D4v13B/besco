<?php 
include('../conexion.php');
include('../funciones.php');

$orco_id=$_POST['orco_id'];
$tipo=$_POST['tipo'];
$numero_factura=$_POST['numero_factura'];
$fecha_factura=$_POST['fecha_factura'];

if($tipo==1)
{
	$campo_cantidad = "orcd_recibido";
}
else 
{
	$campo_cantidad = "orcd_restante";
}
//inserto el encabezado
$copr_id = obtener_valor("select crpr_id from cons_orden_compra where orco_id='$orco_id'","crpr_id");
$qsql ="insert into cons_facturas (orco_id, copr_id, fact_numero, fact_fecha, usua_id, fact_saldo)
values('$orco_id', '$copr_id', '$numero_factura', '$fecha_factura', '$user_check', 0)
";
mysql_query($qsql);
$fact_id = mysql_insert_id();

//saco el subtotal
$subtotal = obtener_valor("select sum($campo_cantidad*orcd_precio) subtotal from cons_orden_compra_detalles where orco_id='$orco_id'", "subtotal");
$impuesto =  obtener_valor("SELECT COALESCE(SUM($campo_cantidad*orcd_precio*.07),0) subtotal 
									FROM cons_orden_compra_detalles 
									WHERE orco_id='$orco_id' AND orcd_con_itbms=1", "subtotal");
$total = $subtotal+$impuesto;
$qsql = "update cons_facturas set fact_subtotal=$subtotal,
fact_impuesto=$impuesto, fact_total=$total, fact_saldo=$total where fact_id='$fact_id'";
mysql_query($qsql);

//ahora inserto el detalle
$qsql = "INSERT INTO cons_facturas_detalles (fact_id, prod_id, fade_cantidad, fade_monto, fade_itbms) 
(SELECT '$fact_id', prod_id, $campo_cantidad, orcd_precio, 
		IF(orcd_con_itbms=1, $campo_cantidad*orcd_precio*0.07,0) itbms FROM cons_orden_compra_detalles WHERE orco_id='$orco_id')";
mysql_query($qsql);
//actualizo la orden de compra para que este facturada

$qsql ="update cons_orden_compra set ores_id=2 where orco_id='$orco_id'";
mysql_query($qsql);

//ahora debo actualizar el presupuesto
$qsql = "SELECT prod_id, fade_cantidad FROM cons_facturas_detalles WHERE fact_id='$fact_id'";
$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;

$proy_id = obtener_valor("SELECT proy_id FROM cons_orden_compra WHERE orco_id='$orco_id'", "proy_id");
while($i<$num)
{
	$prod_id=mysql_result($rs, $i, 'prod_id');
	$fade_cantidad=mysql_result($rs, $i, 'fade_cantidad');
	//saco cuanto se lleva comprada para el item que voy a actualizar 
	$qsql = "SELECT copr_comprados FROM construccion_presupuesto WHERE proy_id='$proy_id' AND coru_id='$prod_id'";
	$comprados = obtener_valor($qsql, "copr_comprados");
	//a los ya comprados le sumo lo nuevo 
	$comprados_total = $comprados + $fade_cantidad;
	//actualizo presupuesto
	$qsql = "update construccion_presupuesto set copr_pendientes = copr_cantidad - $comprados_total,
	copr_comprados=$comprados_total,
	copr_inventario = copr_inventario+$fade_cantidad
	where proy_id='$proy_id' 
	and coru_id='$prod_id'";
	mysql_query($qsql);
	

	
	$i++;
}

	//le sumo la cantidad restante al recibido en la o/c
	if($tipo==2)
	{
		$qsql = "UPDATE cons_orden_compra_detalles SET orcd_recibido = orcd_recibido+orcd_restante
					WHERE orco_id='$orco_id'";
		mysql_query($qsql);
		$qsql = "update cons_orden_compra_detalles set orcd_restante=0 where orco_id='$orco_id'";
		mysql_query($qsql);
	}
?>