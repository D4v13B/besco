<?php 
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=magaya.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

include('conexion.php');

$where="";
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
if($desde!='') $where .= " AND date_format(fact_fecha, '%Y%m%d')>='$desde'";
if($hasta!='') $where .= " AND date_format(fact_fecha, '%Y%m%d')<='$hasta'";

/*
$qsql = "SELECT clie_nombre, fact_numero, date_format(fact_fecha, '%Y-%m-%d') fecha, 
(SELECT SUM(paqu_peso) FROM paquetes WHERE paqu_id IN (SELECT paqu_id FROM consolidados_detalles WHERE cons_id=a.cons_id)) libras,
(SELECT GROUP_CONCAT(paqu_tracking) FROM paquetes WHERE paqu_id IN (SELECT paqu_id FROM consolidados_detalles WHERE cons_id=a.cons_id)) tracking,
clie_tarifa, fact_total
FROM facturas a, clientes b, consolidados c
WHERE b.clie_id=c.clie_id
AND a.cons_id=c.cons_id
$where
";
*/

$qsql = "SELECT clie_nombre, fact_numero, DATE_FORMAT(fact_fecha, '%Y-%m-%d') fecha, 
fade_cantidad, fade_monto, fade_monto/fade_cantidad precio_unitario, paqu_tracking,
IF(paqu_tracking IN (SELECT serv_nombre FROM servicios ), paqu_tracking, 'Flete') cargo
FROM facturas a, clientes b, facturas_detalles c, consolidados d
WHERE b.clie_id=d.clie_id
AND a.fact_id=c.fact_id
AND a.cons_id=d.cons_id
$where
";
//echo $qsql;

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;

echo '<table border="">';
echo '<tr><th>Applied To</th>
	<th>Number</th>
	<th>Transaction Date</th>
	<th>Due Date</th>
	<th>Account Name</th>	
	<th>Notes</th>
	<th>Charge Count</th>
	<th>Quantity</th>
	<th>Charge/Type</th>
	<th>Description</th>
	<th>Unit Price</th>
	<th>Amount</th>
	</tr>';

while($i<$num)
{
	$cliente = mysql_result($rs, $i, 'clie_nombre');
	$fact_numero = mysql_result($rs, $i, 'fact_numero');
	$fecha = mysql_result($rs, $i, 'fecha');
	$fecha_due = $fecha; //cambiar
	$account_name = 'cuentas por cobrar';
	$notes = '';
	$charge_count = '';
	$peso = mysql_result($rs, $i, 'fade_cantidad');
	$charge = mysql_result($rs, $i, 'cargo');
	$descripcion = mysql_result($rs, $i, 'paqu_tracking');
	$precio_unitario = mysql_result($rs, $i, 'precio_unitario');
	$total = mysql_result($rs, $i, 'fade_monto');
	echo "<tr>
	<th>$cliente</th>
	<th>$fact_numero</th>
	<th>$fecha</th>
	<th>$fecha_due</th>
	<th>$account_name</th>	
	<th>$notes</th>
	<th>$charge_count</th>
	<th>$peso</th>
	<th>$charge</th>
	<th>$descripcion</th>
	<th>$precio_unitario</th>
	<th>$total</th>";
	
	$i++;
}

echo '</table>';