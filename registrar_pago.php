<?php include_once('funciones_ui.php'); ?>
<link rel="stylesheet" href="responsive/form-basic.css">
<script>
	$(function() {
		$("#i_fecha").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});



	function ajustar_monto(id) {
		//cambiar esto a que recorra todos los checks y sus montos y así calcule 
		monto = 0;
		$('input.chk_fact_id:checkbox:checked').each(function() {
			//alert(this.id)
			var id_temp = this.id;
			temp_monto = $('#m_' + id_temp).val() * 1;
			r_temp_monto = $('#r_' + id_temp).val() * 1;
			if (temp_monto > r_temp_monto) temp_monto = r_temp_monto;
			$('#m_' + id_temp).val(temp_monto);
			monto = monto + temp_monto;
		});



		$('#i_monto').val(parseFloat(monto).toFixed(2));
	}

	function imprimir_recibo(id) {
		$("#result").load("exportar_pdf_recibo_agrupado.php?id=" + id,
				function(data) {
					//alert(data);
					//abro el documento
					window.open('recibos/recibo_' + id + '.pdf');
					catalogo(location.reload());
				}
</script>
<?php echo autocompletar_filtro('i_proveedor', 'obtener_proveedores.php', 'proveedor', '3', 'i_copr_id') ?>
<div id='mainPage'>
	<form class="form-basic" method="post" action="#" id="frm_registro">
		<div class="form-title-row">
			<h1>Registro de Pago</h1>
		</div>

		<div class="form-row">
			<label>
				<span>proveedor:</span>
				<input type='text' id="i_proveedor" autocomplete='off' onchange="buscar_facturas()">
				<input type='hidden' id="i_copr_id">
			</label>
		</div>

		<div id="result_2"></div>

		<div class="form-row">
			<label>
				<span>Fecha:</span>
				<input type='text' id="i_fecha" autocomplete='off' value="<?php echo date('Y-m-d') ?>">
			</label>
		</div>

		<table style="margin-bottom: 22px;">
			<tr style="padding-bottom: 10px;">
				<?php echo catalogo('cons_forma_pago', 'Forma de Pago', 'fopa_nombre', 'i_tipa_id', 'fopa_id', 'fopa_nombre', 2, 0, 400); ?>
			</tr>
		</table>

		<div class="form-row">
			<label>
				<span># de RECIBO:</span>
				<input type='text' id="i_prfp_numero" autocomplete='off'>
			</label>
		</div>

		<div class="form-row">
			<label>
				<span>REFERENCIA DE ACH</span>
				<input type='text' id="i_prfp_referencia_ach" autocomplete='off'>
			</label>
		</div>

		<div class="form-row">
			<label>
				<span>Monto:</span>
				<input type='text' id="i_monto" autocomplete='off' value="0" readonly>
			</label>
		</div>

		<div class="form-row">
			<label>
				<div id="facturas_pendientes" style="width: 630px;"></div>
			</label>
		</div>

		<div class="form-row">
			<label>
				<span></span>
				<input type='button' value="Pagar" onclick="emitirPagos()">
			</label>
		</div>
	</form>
</div>

<script>
	function buscar_facturas() {
		$('#facturas_pendientes').load('registrar_pago_facturas_pendientes.php?id=' +
			$('#i_copr_id').val(),
			function() {

			}
		);

		$("#result_2").load("registrar_pago_abono_pendiente.php?prov_id="+$("#i_copr_id").val())
	}
</script>


<div id="result"></div>