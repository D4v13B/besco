<script>
	function ver(id) {
		$('#modal').show();
		$('#overlay').show();
		$('#modal').center();
		$('#h_id').val(id);

		validar_estado(id);


	}

	function validar_estado(id) {
		$.get('cons_rep_solicitudes_estado.php?id=' + id,
			function(data) {
				if (data >= 2) {
					$('#dv_aprobar_orden').hide();
					$('#dv_crear_orden').show();
				} else {
					$('#dv_aprobar_orden').show();
					$('#dv_crear_orden').hide();
				}
				cargar_datos(id);
			}

		);
	}

	function cargar_datos(id) {
		$('#datos').load('cons_rep_solicitudes_detalles_mostrar.php?nochk=jjjlae222' +
			"&coso_id=" + id
		);
	}

	function mostrar() {
		$('#datos_mostrar').load('cons_rep_solicitudes_mostrar.php?nochk=jjjlae222' +
			"&f_cose_id=" + $('#f_cose_id').val() +
			"&f_coso_numero=" + $('#f_coso_numero').val() +
			"&f_coso_fecha=" + $('#f_coso_fecha').val() +
			"&f_usua_id=" + $('#f_usua_id').val()
		);
	}

	function crear_orden() {
		$('#modal2').show();
		$('#overlay2').show();
		$('#modal2').center();
	}

	function crear_orden_proceso() {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('cons_rep_solicitudes_crear_orden.php', {
					'id': $('#h_id').val(),
					'adjuntar': $('#i_adjuntar').val(),
					'prov_id': $('#i_copr_id').val(),
					'fecha': $('#i_fecha').val()
				},
				function() {
					$('#modal').hide();
					$('#overlay').hide();
					$('#modal2').hide();
					$('#overlay2').hide();
					mostrar();
				}
			);
		}
	}

	function borrar(id) {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('cons_rep_solicitudes_borrar_detalle.php?id=' + id,
				function() {
					cargar_datos($('#h_id').val());
				}
			);
		}
	}

	function asignar_proveedor(valor) {
		$.get('cons_rep_asignar_proveedor.php?id=' + $('#h_id').val() +
			"&copr_id=" + valor,
			function() {
				cargar_datos($('#h_id').val());
			}
		);
	}
	$(function() {
		$("#i_copr_id").multipleSelect({
			onClick: function(view) {
				valor = view.value;
				asignar_proveedor(valor);
			},
			filter: true,
			single: true
		});
	});

	function editar_detalle(id) {
		$('#modal3').show();
		$('#overlay3').show();
		$('#modal3').center();
		$('#h3_id').val(id);
		$.get('cosd_cons_solicitudes_detalles_datos.php?id=' + id, function(data) {
			var resp = data;
			r_array = resp.split('||');
			//alert(r_array[0]);
			$('#m_cosd_cantidad').val(r_array[1]);
			$('#m_copr_id').val(r_array[2]);
		});
	}

	function modificar_detalle() {
		$('#result').load('cosd_cons_solicitudes_detalles_modificar.php?id=' + $('#h3_id').val(), {
				'm_cosd_id': $('#m_cosd_id').val(),
				'm_cosd_cantidad': $('#m_cosd_cantidad').val(),
				'm_copr_id': $('#m_copr_id').val()
			},
		function() {
				$('#modal3').hide('slow');
				$('#overlay3').hide();
				cargar_datos($('#h_id').val());
			}
		);
	}

	function aprobar_orden() {
		$.get('cons_rep_solicitudes_aprobar.php?id=' + $('#h_id').val(),
			function() {
				validar_estado($('#h_id').val());
			}
		);
	}
</script>
<div id='separador'>
	<table width='' class=filtros>
		<tr>
		<tr>
			<?php echo catalogo('cons_solicitudes_estados', 'Estado', 'cose_nombre', 'f_cose_id', 'cose_id', 'cose_nombre', '0', '1', '150'); ?>
			<?php echo entrada('input', 'Número de Solicitud', 'f_coso_numero', '150') ?>
			<td class='tabla_datos'>
				<div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
			</td>
		</tr>
	</table>
</div>
<div id='columna6'>
	<div id='datos_mostrar'></div>
</div>
<!--MODAL-->
<div id='overlay'></div>
<div id='modal'>
	<div id='content'>
		<input type=hidden id=h_id>
		<div style="overflow:auto;height:300px;width:500px;display:flex;padding:5px; flex-direction: column;justify-content: center;">
			<div style="margin: 10px;"><?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'i_copr_id', 'copr_id', 'copr_nombre', 0, 2, 200, '', ' onselect="asignar_proveedor()"', '', '', '', '', '', '2') ?></div>
			<div style="margin: 10px;"><?php echo catalogo('sino', 'Adjuntar a Pendiente', 'sino_nombre', 'i_adjuntar', 'sino_id', 'sino_nombre', 0, 0, 50, '', '', '', '', '', '', '', '2') ?></div>
			<div style="margin: 10px;" id=datos></div>
		</div>
		<div id=dv_aprobar_orden>
			<?php if ($rol == 1 || $rol == 2) { ?><a href="javascript:aprobar_orden()" class=botones>Aprobar</a><?php } ?>
		</div>
		<div id=dv_crear_orden>
			<a href="javascript:crear_orden()" class=botones>Crear Orden de Compra</a>
		</div>
	</div>
	<a href='javascript:void(0)' id='close'>close</a>
</div>

<div id='overlay2'></div>
<div id='modal2'>
	<div id='content'>
		<TABLE>
			<tr>
				<?php //echo catalogo('cons_proveedores', 'Proveedor','copr_nombre','i_copr_id','copr_id','copr_nombre', 0,2,200)
				?>
			</tr>
			<tr>
				<?php echo entrada('fecha', 'Fecha', 'i_fecha', 200) ?>
			</tr>
			<tr>
				<td><a href="javascript:crear_orden_proceso()" class=botones>Convertir</a></td>
			</tr>
		</TABLE>
	</div>
	<a href='javascript:void(0)' id='close2'>close</a>
</div>

<div id='overlay3'></div>
<div id='modal3'>
	<div id='content2'>
		<input type=hidden id=h3_id>
		<table>
			<tr>
				<?php echo entrada('input', 'CANTIDAD', 'm_cosd_cantidad', '150'); ?>
			</tr>
			<tr>
				<?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'm_copr_id', 'copr_id', 'copr_nombre', '0', '0', '150'); ?>
			</tr>
			<tr>
				<td colspan=2><a href='javascript:modificar_detalle()' class='botones'>Modificar</a></td>
			</tr>
		</table>
	</div>
	<a href='javascript:void(0);' id='close3'>close</a>
</div>

<div id=result></div>