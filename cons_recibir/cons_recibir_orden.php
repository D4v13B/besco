<script>
	function updater_cotizacion(campo_id, fila, id, original) {
		$('#result').load('cons_recibir/cons_recibir_orden_updater.php', {
				'id_campo': campo_id,
				'id': id,
				'i': fila,
				'valor': $('#' + campo_id).val()
			},
			function(data) {
				var obj_tr = document.getElementById('tr_' + fila).getElementsByTagName('td');

				var valor_ingresado = $('#' + campo_id).val() * 1;

				console.log(valor_ingresado);
				original = original * 1;
				console.log(original);

				if (valor_ingresado != 0 && valor_ingresado < original) {
					for (let i = 0; i < obj_tr.length; i++) {
						obj_tr[i].style.backgroundColor = "#faf47d";
					}
				}
			}
		);
	}

	function recibir(campo_id, fila, id, cantidad) {
		//marco la cantidad esperada
		$('#' + campo_id).val(cantidad);
		//alert('tr_' + fila);
		var obj_tr = document.getElementById('tr_' + fila).getElementsByTagName('td');

		//obj_tr[0].style.backgroundColor ="#80ff8e";
		for (let i = 0; i < obj_tr.length; i++) {
			obj_tr[i].style.backgroundColor = "#80ff8e";
		}
		updater_cotizacion(campo_id, fila, id, cantidad);
	}

	function convertir(tipo) {
		if ($('#fecha_factura').val() != '' && $('#numero_factura').val() != '') {
			$('#result').load('cons_recibir/cons_recibir_convertir.php', {
					'orco_id': $('#h_orco_id').val(),
					'tipo': tipo,
					'fecha_factura': $('#fecha_factura').val(),
					'numero_factura': $('#numero_factura').val()
				},
				function(data) {
					console.log(data);
					location.reload();
				}

			);
		} else {
			alert('Ingrese fecha y número de factura del proveedor!');
		}
	}
</script>
<?php
$id = $_GET['id'];
//saco los conceptos
$qsql = "SELECT orcd_id, coru_nombre, orcd_precio, orcd_cantidad,orcd_recibido, orcd_restante, (orcd_cantidad - orcd_recibido) restantes_real
FROM cons_orden_compra_detalles a, construccion_rubros b
WHERE orco_id='$id'
AND a.prod_id=b.coru_id
ORDER BY orcd_id";

//echo $qsql;

$rsc = mysql_query($qsql);
$numc = mysql_num_rows($rsc);
$j = 0;
$lineas = 0;
$control = 22;
$no_pag = 0;
$solo_lectura = "";
$ores_id = obtener_valor("select ores_id from cons_orden_compra where orco_id='$id'", "ores_id");
if ($ores_id == 2) $solo_lectura = " disabled ";

//verifico se quedan restantes por recibir
$hay_restantes = obtener_valor("SELECT COUNT(*) cant 
				FROM cons_orden_compra_detalles 
				WHERE orco_id='$id'
				AND orcd_recibido<orcd_cantidad", "cant");
?>
<input type=hidden id=h_orco_id value="<?php echo $id ?>">
<table class=nicetable style='width:99%; border-collapse: collapse' border=0 cellpadding=6>
	<tr style='background-color: #000033'>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Item</td>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Producto</td>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Precio</td>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;'>Cantidad</td>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;width:30px'>Recibido</td>
		<td style='text-align:center;color:#ffffff;font-size: 8pt;width:30px'>Restantes</td>
		<td style="width:25px !important"></td>
		<td style="width:25px !important"></td>
	</tr>
	<?
	while ($j < $numc) {

		$nitem = $j + 1;
		$orcd_id = mysql_result($rsc, $j, 'orcd_id');
		$orcd_recibido = mysql_result($rsc, $j, 'orcd_recibido');
		$orcd_restante = mysql_result($rsc, $j, 'orcd_restante');
		$original = mysql_result($rsc, $j, 'orcd_cantidad');
		$onchange1 = "'p" . $j . "_orcd_recibido', '$j', '$orcd_id', '$original'";
		$onchange2 = "'p" . $j . "_orcd_restante', '$j', '$orcd_id', '0'";

		$bgcolor = "#FFFFFF";
		if (mysql_result($rsc, $j, 'orcd_cantidad') != mysql_result($rsc, $j, 'orcd_recibido') && mysql_result($rsc, $j, 'orcd_recibido') > 0) $bgcolor = "#faf47d";
		if (mysql_result($rsc, $j, 'orcd_cantidad') == mysql_result($rsc, $j, 'orcd_recibido')) $bgcolor = "#80ff8e";
		$solo_lectura_2 = "";
		if ($original <= $orcd_recibido) $solo_lectura_2 = " disabled ";
	?>
		<tr id="<?php echo "tr_$j"; ?>">
			<td style='font-size: 8pt;text-align:center;background-color:<?php echo $bgcolor ?>'><?php echo $nitem ?></td>
			<td style='font-size: 8pt;background-color:<?php echo $bgcolor ?>'><b><?php echo mysql_result($rsc, $j, 'coru_nombre') ?></b></td>
			<td style='text-align:center;font-size: 8pt;background-color:<?php echo $bgcolor ?>'><input data-orcdid="<?php echo number_format(mysql_result($rsc, $j, 'orcd_id'))?>"  class="updater_precio" type="number" value="<?php echo number_format(mysql_result($rsc, $j, 'orcd_precio'), 2) ?>"></td>
			<td style='text-align:center;font-size: 8pt;background-color:<?php echo $bgcolor ?>'><?php echo number_format(mysql_result($rsc, $j, 'orcd_cantidad'), 0) ?></td>
			<?php echo str_replace("da'><input", "da' style='text-align:right;background-color:$bgcolor'><input class='input_right' ", entrada('input', '', 'p' . $j . '_orcd_recibido', '40', $orcd_recibido, $solo_lectura, 'onchange="updater_cotizacion(' . $onchange1 . ');"', 1)); ?>
			<td style='text-align:center;font-size: 8pt;background-color:<?php echo $bgcolor ?>'><?php echo number_format(mysql_result($rsc, $j, 'restantes_real'), 0) ?></td>
			<?php if ($solo_lectura != '')
				echo str_replace("da'><input", "da' style='text-align:right;background-color:$bgcolor'><input class='input_right' ", entrada('input', '', 'p' . $j . '_orcd_restante', '40', $orcd_restante, $solo_lectura_2, 'onchange="updater_cotizacion(' . $onchange2 . ');"', 1)); ?>
			<td style=";background-color:<?php echo $bgcolor ?>"><?php if ($ores_id == 1) { //solo lo muestro sino ha sido transformada
																					?><a href="javascript:recibir(<?php echo $onchange1 ?>)"><img src="imagenes/down.png" style="width:20px;heigth:20px"></a><?php } ?></td>
		</tr>
	<?
		$j++;
	}
	?>

</table>
<?php if ($ores_id == 1) { ?>
	<div style="display: flex;justify-content: center;align-items: baseline;width:600px;margin:auto;padding:10px">
		<div><?php echo entrada('input', '# Factura', 'numero_factura') ?></div>
		<div><?php echo entrada('fecha', 'Fecha Factura', 'fecha_factura') ?></div>
		<div class=boton><a href="javascript:convertir(1)">CONVERTIR A FACTURA</a></div>
	</div>
<?php } ?>
<!--SI AUN QUEDAN PUEDO FACTURAR EL RESTATE-->
<?php if ($ores_id == 2 && $hay_restantes != 0) { ?>
	<div style="display: flex;justify-content: center;align-items: baseline;width:600px;margin:auto;padding:10px">
		<div><?php echo entrada('input', '# Factura', 'numero_factura') ?></div>
		<div><?php echo entrada('fecha', 'Fecha Factura', 'fecha_factura') ?></div>
		<div class=boton><a href="javascript:convertir(2)">CONVERTIR A FACTURA (RESTANTE)</a></div>
	</div>
<?php } ?>

<div id=result></div>

<script>
	$(".updater_precio").change(function(){
		const val = $(this).val()
		const orcd_id = $(this).data("orcdid")
		$.ajax({
			method: "POST",
			url: "cons_recibir/cons_modificar_precio.php",
			data: {
				orcd_id,
				val
			},
			success: res => {
				console.log(res)
			}
		})
	})
</script>