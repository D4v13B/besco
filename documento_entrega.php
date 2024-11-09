<?php

require "conexion.php";
require "funciones.php";

$id = $_GET['id'];

$qsql = "SELECT *

FROM cons_salidas 

WHERE cosa_id='$id'";

$rs = mysql_query($qsql);

$num_proy = mysql_num_rows($rs);

$i = 0;



//VARIABLES

//$ = mysql_result($rs, $i, '');

//$recibo = mysql_result($rs, $i, 'prap_recibo');

$fecha = mysql_result($rs, $i, 'cosa_fecha');

$numero = mysql_result($rs, $i, 'cosa_numero');

$qsql = "select cote_detalle from correos_templates where cote_nombre='entregas'";

$machote = obtener_valor($qsql, "cote_detalle");


$machote = str_replace("[FECHA]", $fecha, $machote);

$machote = str_replace("[NUMERO]", $numero, $machote);


//saco los conceptos

$qsql = "SELECT *

FROM cons_salidas_detalles a, construccion_rubros b

WHERE a.coru_id=b.coru_id

AND cosa_numero='$numero'";



//echo $qsql;



$rsc = mysql_query($qsql);

$numc = mysql_num_rows($rsc);

$j = 0;

$lineas = 0;

$control = 22;

$no_pag = 0;

$conceptos = "<table style='width:800px; border-collapse: collapse' border=0 cellpadding=6><tr style='background-color: #aa1525'>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Producto</td>

<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Cantidad</td>

";



$subconceptos = $conceptos;



while ($j < $numc) {

	$conceptos .= "<tr>";

	$conceptos .= "<td style='font-size: 8pt;'><b>" . mysql_result($rsc, $j, 'coru_nombre') . "</b></td>";

	$conceptos .= "<td style='text-align:center;font-size: 8pt;'>" . number_format(mysql_result($rsc, $j, 'cosd_cantidad'), 2) . "</td>";

	$conceptos .= "</tr>";



	$lineas++;

	if ($lineas == $control) {

		$control = 30;

		$conceptos .= "</table><br><br><pagebreak>";

		$conceptos .= $subconceptos;

		$lineas = 0;

		$no_pag++;
	}



	$j++;
}

$conceptos .= "</table>";

$conceptos .= "<hr />";



echo $machote = str_replace("[DETALLE]", $conceptos, $machote);