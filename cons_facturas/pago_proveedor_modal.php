<?php

include('../conexion.php');

include('../funciones.php');

$id = $_GET['id'];

$qsql = "SELECT a.fact_id, copr_nombre, faes_nombre, fact_total, fact_saldo, fact_numero
FROM cons_facturas a, cons_proveedores b, cons_facturas_estados c 
WHERE a.copr_id=b.copr_id 
AND a.faes_id=c.faes_id 
AND fact_id ='$id'
";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i = 0;


if ($num > 0) {

	$cliente = mysql_result($rs, $i, 'copr_nombre');

	$numero = mysql_result($rs, $i, 'fact_numero');

	$estado = mysql_result($rs, $i, 'faes_nombre');

	$total = mysql_result($rs, $i, 'fact_total');

	$saldo = mysql_result($rs, $i, 'fact_saldo');
}



?>

<script>
	$(function() {

		$("#i_fecha").datepicker({
			dateFormat: 'yymmdd'
		});

		$("#i_inicio").datepicker({
			dateFormat: 'yymmdd'
		});

	});




	var lineas = 0;



	function otra_linea()

	{

		var $tableBody = $('#tbl').find("tbody"),

			$trLast = $tableBody.find("tr:first"),

			$trNew = $trLast.clone();



		$($trNew).find("td input:text,td select").each(function() {

			textVal = this.value;

			inputName = $(this).attr('id', this.id + '_' + lineas);

			//alert(inputName);

		});



		$trLast.after($trNew);

		lineas++;

		//alert(lineas);

	}



	function quiensoy(id)

	{

		//alert(id.id);

	}



	function crear_pago_regular()

	{

		$('#result').load("cons_facturas/pago_proveedor_crear.php?pid=" + $("#h6_id").val()

			+
			"&monto=" + encodeURI($('#i_monto').val())

			+
			"&recibo=" + encodeURI($('#i_recibo').val())

			+
			"&fecha=" + encodeURI($('#i_fecha').val())

			+
			"&concepto=" + encodeURI($('#i_concepto').val())

			+
			"&forma=" + encodeURI($('#i_forma').val())

			+
			"&banco=" + encodeURI($('#i_banco').val())

			+
			"&tipo=" + encodeURI($('#i_tipo').val())

			+
			"&cheque=" + encodeURI($('#i_cheque').val())

			+
			"&arreglo=0"

			,

			function(data) {

				//alert(data);

				alert('Pago Realizado');

				$('#modal6').hide('slow');

				$('#overlay6').hide();

				//limpiar();





				mostrar();



			}

		);

	}



	function crear_pago_arreglo()

	{

		//armo el arreglo del tipo

		var tipo = $('#i_tipo').val();

		var monto = $('#i_aplicado').val();



		var tmonto = $('#i_aplicado').val() * 1;



		for (i = 0; i < lineas; i++)

		{

			tipo = tipo + '|' + $('#i_tipo_' + i).val();

			monto = monto + '|' + $('#i_aplicado_' + i).val();

			tmonto = tmonto + $('#i_aplicado_' + i).val() * 1;

		}



		//alert(tmonto);



		if (tmonto == $('#i_monto').val())

		{

			$('#result').load("pago_proveedor_crear.php?pid=" + $("#h6_id").val()

				+
				"&monto=" + monto

				+
				"&recibo=" + encodeURI($('#i_recibo').val())

				+
				"&fecha=" + encodeURI($('#i_fecha').val())

				+
				"&concepto=" + encodeURI($('#i_concepto').val())

				+
				"&forma=" + encodeURI($('#i_forma').val())

				+
				"&banco=" + encodeURI($('#i_banco').val())

				+
				"&tipo=" + tipo

				+
				"&cheque=" + encodeURI($('#i_cheque').val())

				+
				"&arreglo=1"

				,

				function() {

					alert('Pago Realizado');

					$('#modal6').hide('slow');

					$('#overlay6').hide();

					//limpiar();





					mostrar();



				}

			);

		} else

		{

			alert('Monto no concuerda!');

		}

	}



	function poner_valor()

	{

		$('#i_aplicado').val($('#i_monto').val());

	}



	function borrar_pago(id)

	{

		var resp = confirm("Esta seguro que desea eliminar este pago?");

		if (resp)

		{

			$('#result').load("cons_facturas/pago_proveedor_borrar.php?pid=" + id,

				function()

				{

					$("#detalle_guia").load("cons_facturas/ver_proveedores_pagos.php?pid=" + $('#h6_id').val());

					mostrar();

				}

			);



		}

	}
</script>

<table class=nicetable style="width:98%">

	<td>Nota de crédito</td>

	<td>Monto total</td>

	<td>Saldo sin utilizar</td>

	<td></td>

	<td></td>

	<?php

	$prov_id = obtener_valor("SELECT copr_id FROM cons_facturas WHERE fact_id = '$id'", "copr_id");
	$qsql = "SELECT * FROM cons_notas_credito WHERE crpr_id = $prov_id AND nocr_saldo > 0";
	$res = mysql_query($qsql);

	while ($fila = mysql_fetch_assoc($res)) { 
		?>
		<tr>
			<td>NC- <?php echo $fila["nocr_id"] ?></td>
			<td><?php echo $fila["nocr_monto"] ?></td>
			<td class="saldo">
				<?php echo $fila["nocr_saldo"] ?>
			</td>
			<td>
				<input type="number" class="inpMontoCredito" value="0.00" data-nocrid="<?php echo $fila["nocr_id"] ?>" readonly data-tope="<?php echo $fila["nocr_saldo"] ?>">
			</td>
			<td>
				<input type="checkbox" class="chk_nota_credito" value="0" data-notacredito="<?php echo $fila["nocr_id"] ?>" data-saldo="<?php echo $fila["nocr_saldo"] ?>" data-nocrid="<?php echo $fila["nocr_id"] ?>">
			</td>
		</tr>

	<?php } ?>


</table>

<table>

	<tr>

		

	</tr>

</table>

<script>
	$(document).ready(function() {
		removeItemLocalStorage()
	})

	$(".inpMontoCredito").on("input", function() {
		let tr = $(this).closest("tr")
		calcularTotal()
		let localStorage = getLocalStorage()

		let tope = $(this).data("tope")

		if ($(this).val() <= tope) {
			tr.find(".saldo").text(tope - $(this).val())

			let dataTmp = {
				nocr_id: $(this).data("nocrid"),
				saldo_usar: $(this).val()
			}

			localStorage = localStorage.filter(item => item.nocr_id != dataTmp.nocr_id)

			localStorage.push(dataTmp)

			setItemLocalStorage(localStorage)
		} else {
			$(this).val(tope)
			$(".inpMontoCredito").trigger("input")
		}
	})

	$(".chk_nota_credito").on("change", function() {
		let tr = $(this).closest("tr"), // Más claro usar closest para encontrar el tr más cercano
			inpMonto = tr.find(".inpMontoCredito"),
			saldoDisponible = parseFloat($(this).data("saldo")); // Asegúrate de convertir a número
		let localStorage = getLocalStorage()

		let dataTmp = {
			nocr_id: $(this).data("nocrid"),
			saldo_usar: saldoDisponible
		}

		if ($(this).is(":checked")) {
			inpMonto.val(saldoDisponible); // Asignar el saldo disponible al campo de entrada

			inpMonto.removeAttr("readonly")

			localStorage = localStorage.filter(item => item.nocr_id != dataTmp.nocr_id)

			localStorage.push(dataTmp)

			setItemLocalStorage(localStorage)

		} else {
			inpMonto.val(0); // Si se desmarca el checkbox, poner 0
			inpMonto.attr("readonly", "readonly")

			localStorage = localStorage.filter(item => item.nocr_id != dataTmp.nocr_id)

			console.log(localStorage);

			setItemLocalStorage(localStorage)
		}
		inpMonto.trigger("input")
		calcularTotal()
	});

	function calcularTotal() {
		let total = 0
		let inputMonto = $("#i_monto")

		$(".inpMontoCredito").each(function() {
			let valor = parseFloat($(this).val()) || 0; // Obtener el valor del input, usar 0 si no es un número
			total += valor;
		});

		inputMonto.val(total)
	}

	function getLocalStorage() {
		return JSON.parse(localStorage.getItem("notasCreditoPagos")) ?? []
	}

	function setItemLocalStorage(data) {
		localStorage.setItem("notasCreditoPagos", JSON.stringify(data))
	}

	function removeItemLocalStorage() {
		localStorage.removeItem("notasCreditoPagos")
	}

	function pago_nota_credito() {
		let notas_credito = getLocalStorage() //Objeto JSON


		$.ajax({
			url: "cons_facturas/facturas_registrar_pago_notas.php",
			method: "POST",
			data: {
				notas_credito: JSON.stringify(notas_credito),
				fopa_id: $("#i_tipo").val(),
				i_fecha: $("#i_fecha").val(),
				copr_id: <?php echo $prov_id?>
			}, // Convertir objeto a JSON
			success: res => {
				console.log(res);
			}
		});
	}
</script>


<table class=nicetable style="width:98%">

	<tr>

		<td>Proveedor</td>

		<td>Referencia</td>

		<td>Estatus</td>

		<td>Monto</td>

		<td>Saldo</td>

	</tr>

	<tr>

		<td><?php echo $cliente ?></td>

		<td><?php echo $numero ?></td>

		<td><?php echo $estado ?></td>

		<td><?php echo $total ?></td>

		<td><?php echo $saldo ?></td>

	</tr>

</table>

<table>

	<tr>

		<td class=etiquetas>Monto:</td>

		<td class=etiquetas align=left style="text-align:left !important"><input type=text id=i_monto onchange="poner_valor()" autocomplete=off value="<?php echo $saldo ?>"></td>

	</tr>

	<tr>

		<td class=etiquetas>Fecha:</td>

		<td class=etiquetas><input type=text id=i_fecha autocomplete=off></td>

	</tr>

</table>

<table>

	<tr>

		<td>

			<table id=tbl>

				<tbody>

					<tr id=tr_a_clonar>

						<?php echo catalogo('cons_forma_pago', 'Forma de Pago', 'fopa_nombre', 'i_tipo', 'fopa_id', 'fopa_nombre', '0', '0', '80 ') ?>

						<td class=etiquetas>Monto Aplicado:</td>

						<td><input type=text id=i_aplicado style="width:50px" onclick="quiensoy(this)" autocomplete=off></td>

					</tr>

				</tbody>

			</table>

		</td>

	</tr>

</table>

<table>

	<tr>

		<td colspan=2><a href="javascript:crear_abono()" class=botones>Abonar</a>

			<input type=button id="btn_modificar" value="Modificar" class="botones">
		</td>

		<td colspan=2><a href="javascript:pago_nota_credito()" class=botones>Pagar con crédito</a>

			<input type=button id="btn_modificar" value="Modificar" class="botones">
		</td>

	</tr>

	

</table>