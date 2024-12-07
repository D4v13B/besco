<?php include_once('../funciones_ui.php'); ?>
<link rel="stylesheet" href="responsive/form-basic.css">
<script>
	$(function() {
		$("#i_fecha").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});

	function buscar_facturas() {
		$('#facturas_pendientes').load('registrar_pago_facturas_pendientes.php?id=' +
			$('#i_clie_id').val(),
			function() {

			}
		);
	}

	function ajustar_monto(id) {
		//cambiar esto a que recorra todos los checks y sus montos y así calcule 
		monto = 0;
		$('input.chk_fact_id:checkbox:checked').each(function() {
			//alert(this.id);
			var id_temp = this.id;
			temp_monto = $('#m_' + id_temp).val() * 1;
			r_temp_monto = $('#r_' + id_temp).val() * 1;
			if (temp_monto > r_temp_monto) temp_monto = r_temp_monto;
			$('#m_' + id_temp).val(temp_monto);
			monto = monto + temp_monto;
		});



		$('#i_monto').val(parseFloat(monto).toFixed(2));
	}

	function emitir() {
		//debo validar que este todo para emitir
		if (
			$('#i_clie_id').val() != '' &&
			$('#i_fopa_id').val() != '' &&
			$('#i_fecha').val() != '') {
			//paso por todos los valores y armo una cadena
			arr_montos = "";
			arr_fact_id = "";
			$('input.chk_fact_id:checkbox:checked').each(function() {
				//debo armar dos cadenas con los montos y el id de la factura 
				var id_temp = this.id;
				temp_monto = $('#m_' + id_temp).val() * 1;

				arr_montos = arr_montos + '' + temp_monto + '|';
				arr_fact_id = arr_fact_id + '' + id_temp + '|';

			});
			//si no esta vacio el arreglo envio el pago
			if (arr_montos != '' && arr_fact_id != '') {
				$('#result').load('registrar_pago_emitir.php', {
						'clie_id': $('#i_clie_id').val(),
						'fecha': $('#i_fecha').val(),
						'fopa_id': $('#i_fopa_id').val(),
						'arr_montos': arr_montos,
						'arr_fact_id': arr_fact_id
					},
					function(datos) {
						alert('Pago Registrado!');

						console.log(datos);
						imprimir_recibo(datos);
						//limpio la pantalla
						$('#frm_registro').trigger("reset");
						$('#facturas_pendientes').html('');

					}
				);
			}
		} else {
			alert('Debe ingresar todos los datos!');
		}
	}

	function imprimir_recibo(id) {
		$("#result").load("exportar_pdf_recibo_agrupado.php?id=" + id,
			function(data) {
				//alert(data);
				//abro el documento
				window.open('recibos/recibo_' + id + '.pdf');
				location.reload();
			});
	}
</script>
<?php echo autocompletar_filtro('i_cliente', 'obtener_clientes.php', 'cliente', '3', 'i_clie_id') ?>
<div id='mainPage'>
	<form class="form-basic" method="post" action="#" id="frm_registro">
		<div class="form-title-row">
			<h1>Registro de Pago</h1>
		</div>

		<div class="form-row">
			<label>
				<span>Cliente:</span>
				<input type='text' id="i_cliente" autocomplete='off' onchange="buscar_facturas()">
				<input type='hidden' id="i_clie_id">
			</label>
		</div>

		<div id="result_2"></div>

		<div class="form-row">
			<label>
				<span>Fecha:</span>
				<input type='text' id="i_fecha" autocomplete='off' value="<?php echo date('Y-m-d') ?>">
			</label>
		</div>

		<div class="form-row">
			<?php echo catalogo('forma_pago', 'Forma de Pago', 'fopa_nombre', 'i_fopa_id', 'fopa_id', 'fopa_nombre', 2, 0, 200, '', '', '', '', 'r'); ?>
		</div>

		<div class="form-row">
			<label>
				<span>Monto:</span>
				<input type='text' id="i_monto" autocomplete='off' value="0" readonly>
			</label>
		</div>

		<div class="form-row">
			<label>
				<div id=facturas_pendientes></div>
			</label>
		</div>

		<div class="form-row">
			<label>
				<span></span>
				<input type='button' value="Pagar" onclick="emitir()">
			</label>
		</div>
	</form>
</div>

<div id=result></div>