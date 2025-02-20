<?php 

$qsql ="SELECT DATE_FORMAT(orco_fecha, '%d/%m/%Y') fecha, copr_nombre proveedor, orco_numero, orco_aprobada, orco_comentario,

(SELECT SUM(orcd_cantidad*orcd_precio) FROM cons_orden_compra_detalles WHERE orco_id='$id') monto

FROM cons_orden_compra a, cons_proveedores b 

WHERE a.crpr_id=b.copr_id

AND orco_id='$id'";





$rs = mysql_query($qsql);

$num_proy = mysql_num_rows($rs);

$i=0;



//VARIABLES

//$ = mysql_result($rs, $i, '');

//$recibo = mysql_result($rs, $i, 'prap_recibo');

$fecha = mysql_result($rs, $i, 'fecha');

$proveedor = mysql_result($rs, $i, 'proveedor');

$monto = mysql_result($rs, $i, 'monto');

$factura = mysql_result($rs, $i, 'orco_numero');

$aprobada = mysql_result($rs, $i, 'orco_aprobada');

$observaciones = mysql_result($rs, $i, 'orco_comentario');





	$qsql = "select cote_detalle from correos_templates where cote_nombre='Orden Compra'";

	$machote = obtener_valor($qsql, "cote_detalle");	



$fecha_vencimiento = date('d-m-Y', strtotime("+10 days"));



//$machote = str_replace("[RECIBO]",$recibo,$machote);

//$machote = str_replace("[FECHA]",armar_fecha_palabras($fecha),$machote);

$machote = str_replace("[FECHA]",$fecha,$machote);

$machote = str_replace("[FECHA_VENCIMIENTO]",$fecha_vencimiento,$machote);

$machote = str_replace("[PROVEEDOR]",$proveedor,$machote);

$machote = str_replace("[RECIBO]",str_pad($factura, 3, "0", STR_PAD_LEFT),$machote);

$machote = str_replace("[MONTO]","  $ " . number_format($monto,2),$machote);

$machote = str_replace("[OBSERVACIONES]", $observaciones, $machote);

//saco los conceptos

$qsql ="SELECT coru_nombre, orcd_cantidad, orcd_precio, orcd_detalle 

FROM cons_orden_compra_detalles a, construccion_rubros b

WHERE a.prod_id=b.coru_id

AND orco_id='$id'";



//echo $qsql;



$rsc=mysql_query($qsql);

$numc=mysql_num_rows($rsc);

$j=0;

$lineas=0;

$control=22;

$no_pag=0;

$conceptos="<table style='width:800px; border-collapse: collapse' border=0 cellpadding=6><tr style='background-color: #aa1525'>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Producto</td>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Cantidad</td>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Precio</td>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Total</td></tr>";



$subconceptos= $conceptos;



while($j<$numc)

{

	$conceptos .= "<tr>";

	$conceptos .= "<td style='font-size: 8pt;'><b>" . mysql_result($rsc, $j, 'coru_nombre') . "</b><br>" . mysql_result($rsc, $j, 'orcd_detalle') ."</td>";-

	$conceptos .= "<td style='text-align:center;font-size: 8pt;'>" . number_format(mysql_result($rsc, $j, 'orcd_cantidad'),0) . "</td>";

	$conceptos .= "<td style='text-align:right;font-size: 8pt;'>$ " . number_format(mysql_result($rsc, $j, 'orcd_precio'),4) . "</td>";

	$conceptos .= "<td style='text-align:right;font-size: 8pt;'>$ " . number_format(mysql_result($rsc, $j, 'orcd_precio')*mysql_result($rsc, $j, 'orcd_cantidad'),4) . "</td>";

	$conceptos .= "</tr>";

	

	$lineas++;

	if($lineas==$control) 

	{

		$control=30;

		$conceptos .= "</table><br><br><pagebreak>";

		$conceptos .= $subconceptos;

		$lineas=0;

		$no_pag++;

	}

	

	$j++;

}

$conceptos .= "</table>";

$conceptos .= "<hr />";

//por ahora abonado igual a cancelado

$itbms=0;

$itbms = $monto * 0.07;

$conceptos .="<table style='width:800px;' border=0 cellpadding=6>

<tr><td style='text-align:right;font-size: 8pt;'>Total:</td><td style='text-align:right;width:150px;font-size: 8pt;'>$ " . number_format($monto,2) . "</td></tr>

<tr><td style='text-align:right;font-size: 8pt;'>ITBMS:</td><td style='text-align:right;font-size: 8pt;'>$ " . number_format($itbms,2) . "</td></tr>

<tr><td style='text-align:right;font-size: 8pt;'>Saldo Total:</td><td style='text-align:right;font-size: 8pt;'>$ " . number_format($monto+$itbms,2) . "</td></tr>

</table>";



$machote = str_replace("[CONCEPTOS]",$conceptos,$machote);

if($aprobada){
	$machote = str_replace("[APROBADO]", "<img style='width: 200px'  src='../alanalifirma.jpg'>", $machote);
}else{
	$machote = str_replace("[APROBADO]", "", $machote);
}

?>

<html>

<head>

<?php echo $machote?>

</body>

</html>