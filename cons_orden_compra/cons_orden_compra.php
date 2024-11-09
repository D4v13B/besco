<?php
include('funciones_ui.php');
?>
<script>
	$(function() {
		$("#i_ingr_fecha").datepicker({
			dateFormat: 'yymmdd'
		});
		$("#f_desde").datepicker({
			dateFormat: 'yymmdd'
		});
		$("#f_hasta").datepicker({
			dateFormat: 'yymmdd'
		});
		$('#div_modificar').hide();
	});

	function crear() {
		$('#result').load('cons_orden_compra/cons_orden_compra_crear.php', {
				'copr_id': $('#h_copr_id').val(),
				'h_codigo': $('#h_codigo').val(),
				'i_ingr_fecha': $('#i_ingr_fecha').val(),
				'i_numero_factura': $('#i_numero_factura').val(),
				'proy_id': $('#i_proy_id').val()
			},
			function() {
				$('#modal').hide('slow');
				$('#overlay').hide();
				mostrar();
			}
		);
	}

	function modificar() {
		$('#result').load('cons_orden_compra/cotizaciones_modificar.php', {
				'id': $('#h_id').val(),
				'copr_id': $('#h_copr_id').val(),
				'i_ingr_fecha': $('#i_ingr_fecha').val(),
				'i_numero_factura': $('#i_numero_factura').val(),
				'i_orco_comentario': $("#i_orco_comentario").val()
			},
			function(data) {
				//alert(data);
				$('#modal').hide('slow');
				$('#overlay').hide();
				mostrar();
			}
		);
	}

	function borrar(id) {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('cons_orden_compra/cons_orden_compra_borrar.php?id=' + id,
				function() {
					mostrar();
				}
			);
		}
	}

	function editar(id) {
		$('#h_id').val(id);
		$('#div_crear').hide();
		$('#div_modificar').show();
		$("#h_codigo").val(id)
		$.get('cons_orden_compra/codigo_temporal_orden_compra_modificar.php?id=' + id,
			function(data) {
				// $('#h_codigo').val(data);
				//ahora muestro los items para esa factura
				mostrar_items();
				$.get('cons_orden_compra/cons_orden_compra_datos.php?id=' + id, function(data) {
					var resp = data;
					r_array = resp.split('||');
					//alert(r_array[0]);
					$("#h_codigo").val(r_array[0])
					$('#h_copr_id').val(r_array[1]);
					$('#i_ingr_fecha').val(r_array[2]);
					$('#i_numero_factura').val(r_array[3]);
					$('#proveedor').val(r_array[4]);
					$('#i_proy_id').val(r_array[5]);
					$('#i_orco_comentario').val(r_array[6]);

					$('#modal').show();
					$('#overlay').show();
					$('#modal').center();
				});
			}
		);
	}


	function mostrar() {
		$('#datos_mostrar').load('cons_orden_compra/cons_orden_compra_mostrar.php?id=1' +
			"&factura=" + $('#f_factura').val() +
			"&desde=" + $('#f_desde').val() +
			"&hasta=" + $('#f_hasta').val() +
			"&copr_id=" + $('#f_proveedor').val()
		);
	}

	function precio() {
		//alert($('#prod_id').val());
		$.get('cotizaciones_producto_precio.php?id=' + $('#prod_id').val(),
			function(data) {
				$('#i_precio').val(data);
				if ($('#prod_id').val() != null) disponibilidad();
			}
		);
	}

	function disponibilidad() {
		$.get('cotizaciones_producto_disponible.php?id=' + $('#prod_id').val(),
			function(datos) {
				if (datos <= 0) $('#dvd_mensaje').html('<span style="color:#ff0000">Agotado</span>');
				if (datos > 0) $('#dvd_mensaje').html('');
				$('#i_disponibles').val(datos);
			}
		);
	}

	function nuevo() {
		$('#div_crear').show();
		$('#div_modificar').hide();
		$('#h_id').val('');
		$.get('cons_orden_compra/codigo_temporal_orden_compra.php?',
			function(data) {
				var resp = data;
				r_array = resp.split('||');
				$('#h_codigo').val(r_array[0]);

				$('#i_numero_factura').val(r_array[1]);
				//ahora muestro los items para esa factura
				mostrar_items();
				$('#modal').show();
				$('#overlay').show();
				$('#modal').center();
			}
		);
	}

	function mostrar_items() {
		$('#i_detalle').load('cons_orden_compra/cons_orden_compra_items_mostrar.php?id=' + $('#h_codigo').val());
	}

	function agregar_item() {
		$('#dvd_mensaje').text(""); //limpio el mensaje
		$('#result').load('cons_orden_compra/cons_orden_compra_items_crear.php?prod_id=' + $('#h_coru_id').val(), {
				'i_precio': $('#i_precio').val(),
				'r_detalle': $('#r_detalle').val(),
				'h_codigo': $('#h_codigo').val(),
				'i_cantidad': $('#i_cantidad').val(),
				'ingr_id': $('#h_id').val()
			},
			function(data) {
				$('#h_coru_id').val('');
				$('#inventario').val('');
				$('#i_precio').val('');
				$('#r_detalle').val('');
				$('#i_cantidad').val('');
				mostrar_items();
			}
		);
	}

	function mostrar_disponible() {
		$.get('cons_orden_compra/cons_orden_compra_producto_disponible.php?id=' + $('#h_coru_id').val() +
			"&proy_id=" + $('#i_proy_id').val(),
			function(datos) {
				$('#i_disponibles').val(datos);
			}
		);
	}

	function mostrar_precio() {
		$.get('cons_orden_compra/cons_orden_compra_producto_precio.php?id=' + $('#h_coru_id').val() +
			"&proy_id=" + $('#i_proy_id').val(),
			function(datos) {
				$('#i_precio').val(datos);
			}
		);
	}

	function verificar_cantidad() {
		cantidad = $('#i_cantidad').val() * 1;
		disponible = $('#i_disponibles').val() * 1;

		if (cantidad > disponible) $('#i_cantidad').val(disponible);
	}

	function verificar_cantidad_m() {
		cantidad = $('#m_inde_cantidad').val() * 1;
		disponible = $('#m_disponible').val() * 1;

		if (cantidad > disponible) $('#m_inde_cantidad').val(disponible);
	}

	function imprimir_factura(id) {
		$("#result").load("cons_orden_compra/exportar_pdf_v7.php?contenido=documento_orden_compra.php&id=" + id,
			function() {
				//abro el documento
				window.open('orden_compra/orden_compra_' + id + '.pdf');
			});
	}

	function editar_item(id) {
		$('#modal2').show();
		$('#overlay2').show();
		$('#modal2').center();
		$('#h2_id').val(id);
		$.get('cons_orden_compra/cons_orden_compra_detalle_datos.php?id=' + id +
			"&proy_id=" + $('#i_proy_id').val(),
			function(data) {
				var resp = data;
				r_array = resp.split('||');
				//alert(r_array[0]);
				$('#m_prod_id').val(r_array[1]);
				$('#m_inde_cantidad').val(r_array[2]);
				$('#m_inti_id').val(r_array[3]);
				$('#m_ingr_precio').val(r_array[4]);
				$('#m_inde_temp_code').val(r_array[5]);
				$('#m_inde_detalle').val(r_array[6]);
				$('#m_disponible').val(r_array[7]);
				$('#m_orcd_con_itbms').val(r_array[8]);
			});
	}

	function borrar_item(id) {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('cons_orden_compra/cons_orden_compra_detalle_borrar.php?id=' + id,
				function() {
					mostrar_items();
				}
			);
		}
	}

	function modificar_item() {
		$('#result').load('cons_orden_compra/cons_orden_compra_detalle_modificar.php', {
				'id': $('#h2_id').val(),
				'm_prod_id': $('#m_prod_id').val(),
				'm_inde_detalle': $('#m_inde_detalle').val(),
				'm_inde_cantidad': $('#m_inde_cantidad').val(),
				'm_inti_id': $('#m_inti_id').val(),
				'm_ingr_precio': $('#m_ingr_precio').val(),
				'm_orcd_con_itbms': $('#m_orcd_con_itbms').val()

			},
			function() {
				$('#modal2').hide('slow');
				$('#overlay2').hide();
				mostrar_items();
			}
		);
	}

	function aprobar(id) {
		$.get('cons_orden_compra/cons_orden_compra_aprobar.php?id=' + id,
			function() {
				mostrar();
			});
	}


	function enviar_oc(id, tipo_email) { //Id es igual a la orden de compra
		// $("#result").load("cons_orden_compra/cons_orden_compra_.php?id=" + id,
		// 	function(data) {
		// 		alert('O/C Enviada');
		// 		//alert(data);
		// 		//abro el documento
		// 	});

			let datos = {
				tipo_email,
				id
			}

			if($("#inpCorreoProveedor").val() != ""){
				datos.emailProv = $("#inpCorreoProveedor").val()
			}

			$.ajax({
				method: "POST",
				url: "cons_orden_compra/cons_orden_compra_mostrar.php",
				data: datos,
				success: res => {
					console.log(res)
				}
			})
	}
</script>
<input type='hidden' id='h_coru_id'>
<?php echo autocompletar_filtro(
	'inventario',
	'../construccion_obtener_inventario.php',
	'inventario',
	2,
	'h_coru_id',
	'',
	'',
	'',
	'',
	'mostrar_disponible();mostrar_precio();'
) ?>
<input type='hidden' id='h_copr_id'>
<?php echo autocompletar_filtro('proveedor', '../construccion_obtener_proveedor.php', 'proveedor', 2, 'h_copr_id') ?>
<div id='separador'>
	<table class=filtros>
		<tr>
			<?php echo entrada('input', 'Cotización', 'f_factura') ?>
			<?php echo entrada('input', 'Desde', 'f_desde') ?>
			<?php echo entrada('input', 'Hasta', 'f_hasta') ?>
		</tr>
		<tr>
			<?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'f_proveedor', 'copr_id', 'copr_nombre', 0, 1, 150) ?>
			<td></td>
			<td></td>
			<td class='tabla_datos'>
				<div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
			</td>
			<td><a href='javascript:nuevo()' class=botones>Nuevo</a>
				<input type=hidden id=h_codigo>
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
		<table>
			<tr>
				<td colspan=6>
					<table class=filtros style="width:1000px">
						<tr>
							<?php echo entrada('input', 'Proveedor', 'proveedor', '200'); ?>
							<?php echo entrada('fecha', 'Fecha', 'i_ingr_fecha', '100'); ?>
							<?php echo entrada('input', 'No. Orden', 'i_numero_factura', '100'); ?>
							<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'i_proy_id', 'proy_id', 'proy_nombre', 0, 0, 150); ?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan=6>
					<table class=filtros style="width:1000px">
						<tr>
							<?php echo entrada('input', 'Producto', 'inventario', '200'); ?>
							<?php echo entrada('input', 'Detalle', 'r_detalle') ?>
							<?php echo entrada('input', 'Cantidad', 'i_cantidad', '50', '', '', ' onchange="verificar_cantidad()"') ?>
							<?php echo entrada('input', 'Precio', 'i_precio', '80') ?>
							<?php echo entrada('input', 'Disp.', 'i_disponibles', '50') ?>
							<td>
								<div id=dvd_mensaje></div>
							</td>
							<td><a href='javascript:agregar_item()' class=botones>Agregar</a></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan=6>
					<div id=i_detalle style="overflow:auto;height:400px"></div>
				</td>
			</tr>
			<tr>
				<table>
					<tr>
						<td><textarea id="i_orco_comentario" cols="100" rows="5" placeholder="Comentarios"></textarea></td>
					</tr>
				</table>
			</tr>
			<tr>
				<td colspan=2>
					<div id=div_crear><a href='javascript:crear()' class='botones'>Crear</a></div>
					<div id=div_modificar><a href='javascript:modificar()' class='botones'>Modificar</a></div>
				</td>
			</tr>
		</table>
	</div>
	<a href='javascript:void(0)' id='close'>close</a>
</div>


<div id='overlay2'></div>
<div id='modal2'>
	<div id='content2'>
		<input type=hidden id=h2_id>
		<table>
			<tr>
				<td class='etiquetas'>Detalle:</td>
				<td><input type='text' id=m_inde_detalle size=40 class='entradas'></td>
			</tr>
			<tr>
				<td class='etiquetas'>Cantidad:</td>
				<td><input type='text' id=m_inde_cantidad size=40 class='entradas' onchange="verificar_cantidad_m()"></td>
			</tr>
			<tr>
				<td class='etiquetas'>Disponible:</td>
				<td><input type='text' id=m_disponible size=40 class='entradas' readonly></td>
			</tr>
			<tr>
				<td class='etiquetas'>precio:</td>
				<td><input type='text' id=m_ingr_precio size=40 class='entradas'></td>
			</tr>
			<tr>
				<?php echo catalogo('sino', 'Con Itbms', 'sino_nombre', 'm_orcd_con_itbms', 'sino_id', 'sino_nombre', 0, 0, 150) ?>
			</tr>
			<tr>
				<td colspan=2><a href='javascript:modificar_item()' class='botones'>Modificar</a></td>
			</tr>
		</table>
	</div>
	<a href='javascript:void(0);' id='close2'>close</a>
</div>

<!--EDITAR UBICACION-->
<div id='overlay3'></div>
<div id='modal3'>
	<div id='content3'>
		<input type=hidden id=h3_id>
		<table>
			<tr>
				<td class='etiquetas'>
					<div id="dv_ubicacion_actual"></div>
				</td>
			</tr>
			<tr>
				<td class='etiquetas'>
					<div id="dv_ubicacion_disponible"></div>
				</td>
			</tr>
		</table>
	</div>
	<a href='javascript:void(0);' id='close3'>close</a>
</div>

<script>
	function enviarCorreoProv(id, tipoEmail){
		$("#overlay4").show()
		$("#modal4").show()

		$("#h4_id").val(id)
		$("#hdtipoEmail").val(tipoEmail)

		$("#btnEnviarOC").click(function(){
			enviar_oc(id, tipoEmail)
		})
	}
</script>

<!--ENVIAR AL PROVEEDOR-->
<div id='overlay4'></div>
<div id='modal4'>
	<div id='content4'>
		<input type=hidden id=h4_id>
		<input type="hidden" id=hdtipoEmail>
		<table>
			<td>
			<td class='etiquetas'>Correo de Proveedor:</td>
			<td><input type='text' id=inpCorreoProveedor size=40 class='entradas'></td>
			</td>
			<td>
				<button class="btn btn-success" id="btnEnviarOC">ENVIAR CORREO</button>
			</td>
		</table>
	</div>
	<a href='javascript:void(0);' id='close4'>close</a>
</div>

<div id=result style="visibility:hidden"></div>
<div id=escondido style="visibility:hidden"></div>