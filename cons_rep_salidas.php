<script>
	function ver(id) {
		$('#modal').show();
		$('#overlay').show();
		$('#modal').center();
		$('#h_id').val(id);
		$('#datos').load('cons_rep_salidas_detalles_mostrar.php?nochk=jjjlae222' +
			"&cosa_id=" + id
		);
	}

	function mostrar() {
		$('#datos_mostrar').load('cons_rep_salidas_mostrar.php?nochk=jjjlae222' +
			"&f_cose_id=" + $('#f_cose_id').val() +
			"&f_coso_numero=" + $('#f_coso_numero').val()
		);
	}

	function borrar(id) {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('paquetes_borrar.php?id=' + id,
				function() {
					mostrar();
				}
			);
		}
	}

	function procesar(id) {
		$('#result').load('cons_salida_inventario_procesar.php?id=' + id,
			function() {
				$("#result").load("exportar_pdf_generico_v3.php?id=" + id, {
						'contenido': 'documento_entrega.php',
						'archivo': 'documento_entrega'
					},
					function() {
						//abro el documento
						window.open('documentos_temporales/documento_entrega.pdf');
						// alert('Salida procesada');
						mostrar();
					});
			}
		);
	}

	function instalar(id) {
		// $('#modal3').show();
		// $('#overla3').show();
		// $('#modal3').center();
		$('#h3_id').val(id);
		$('#result').load('cons_salida_inventario_instalar.php?id=' + id,
			function() {
				alert('Salida Instalada');
				mostrar();
			}
		);
		// $('#content_3').load('cons_salida_inventario_datos.php?id=' + id,
		// 	function() {
				
		// 	}
		// );
	}

	function editarInstalacion(id){
		$('#h3_id').val(id);
		$('#modal3').show();
		$('#overlay3').show();
		$('#modal3').center();
		$('#content_3').load('cons_salida_inventario_datos.php?id=' + id + 
		"&nochk=jjjlae222",
			function() {
				
			}
		);
	}

	function crearInstalacion(){

		$.ajax({
			method: "POST"
		})
	}

	function retornar(id) {
		$('#result').load('cons_salida_inventario_retornar.php?id=' + id,
			function() {
				alert('Salida Retornada');
				mostrar();
			}
		);
	}
</script>
<div id='separador'>
	<table width='' class=filtros>
		<tr>
		<tr>
			<?php echo catalogo('cons_salidas_estados', 'Estado', 'cose_nombre', 'f_cose_id', 'cose_id', 'cose_nombre', '0', '1', '150'); ?>
			<?php echo entrada('input', 'Número de Salida', 'f_coso_numero', '150') ?>
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
		<div style="overflow:auto;height:300px;width:500px">
			<div id=datos></div>
		</div>
	</div>
	<a href='javascript:void(0)' id='close'>close</a>
</div>

<div id='overlay2'></div>
<div id='modal2'>
	<div id='content'>
		<table>
			<tr>
				<?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'i_copr_id', 'copr_id', 'copr_nombre', 0, 2, 200) ?>
			</tr>
			<tr>
				<?php echo entrada('fecha', 'Fecha', 'i_fecha', 200) ?>
			</tr>
			<tr>
				<td><a href="javascript:crear_orden_proceso()" class=botones>Convertir</a></td>
			</tr>
		</table>
		<div id="result"></div>
	</div>
	<a href='javascript:void(0)' id='close2'>close</a>
</div>

<div id='overlay3'></div>
<div id='modal3'>
	<div id='content'>
		<input type=hidden id=h3_id>
		<input type=hidden id=cantidad_total>
		<div id="content_3"></div>
	</div>
	<a href='javascript:void(0)' id='close3'>close</a>
</div>

<div id=result></div>

<script>
	$("#i_retorno").attr("readonly", "readonly")
</script>