<?php
include('funciones_ui.php');
?>
<link rel="stylesheet" href="responsive/form-basic.css">
<link rel="stylesheet" href="flujo.css?id=<?php echo date('YmdsH') ?>" type="text/css" media="screen" />
<script>
	$(function() {
		$(".form-row").on("change", "select", function() {
			let selectName = $(this).attr("name");
			let value = $(this).val()

			document.cookie = selectName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			if (selectName) {
				document.cookie = `${selectName}=` + value + "; path=/";
			}
		});
	})

	$(function() {
		$.get('cons_obtener_secuencia.php',
			function(datos) {
				$('#h_secuencia').val(datos);
			}
		);
	});

	function agregar_solicitud() {
		$('#datos').load('cons_recibir_solicitud_proceso.php', {
				'inventario': $('#h_coru_id').val(),
				'cosu_id': $("#i_cosu_id").val(),
				'coca_id': $("#i_coca_id").val(),
				'cantidad': $('#cantidad').val(),
				'secuencia': $('#h_secuencia').val(),
				'proy_id': $('#i_proy_id').val()

			},
			function() {
				llenar_solicitud();
				$('#frm_registro').trigger("reset");
			}
		);
	}

	function borrar(id) {
		var agree = confirm('¿Está seguro?');
		if (agree) {
			$('#result').load('cosd_cons_solicitudes_detalles_borrar.php?id=' + id,
				function() {
					llenar_solicitud();
				}
			);
		}
	}

	function llenar_solicitud() {
		$('#datos').load('cosd_cons_solicitudes_detalles_mostrar.php?nochk=jjjlae222' +
			"&coso_numero=" + $('#h_secuencia').val()
		);
	}
</script>
<input type=hidden id=h_secuencia>
<?php echo autocompletar_filtro('inventario', 'construccion_obtener_inventario.php', 'inventario', 2, 'h_coru_id') ?>

<div id='mainPage'>
	<form class="form-basic">
		<input type='hidden' id='h_coru_id'>
		<div class="form-title-row">
			<h1>SOLICITUD DE COMPRA</h1>
		</div>
		<div class="form-row">
			<label>
				<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'i_proy_id', 'proy_id', 'proy_nombre', 0, 0, 450, ' where proy_cons=1', '', '', '', '', '', '', '2') ?>
			</label>
		</div>
		<div class="form-row">
			<label>
				<?php echo catalogo('construccion_categorias', 'Categoria', 'coca_nombre', 'i_coca_id', 'coca_id', 'coca_nombre', '0', '0', 450, '', '', '', '', '', '', '', '2'); ?>
			</label>
		</div>
	</form>
	<form class="form-basic" method="post" action="#" id="frm_registro">
		<div class="form-row">
			<label>
				<span>Producto:</span>
				<input type=text id=inventario class=codigo_barra>
			</label>
			<label>
				<span>Cantidad:</span>
				<input type=text id=cantidad class=codigo_barra>
			</label>
		</div>
		<div class="form-row">
			<label>
				<a href="javascript:agregar_solicitud()" class="responsive_boton" id="btn_recibir">AGREGAR</a>
			</label>
		</div>

		<div class="form-row">
			<label>
				<span></span>
				<div id=datos class=flujo_datos></div>
			</label>
		</div>
	</form>
</div>
<div id=result></div>