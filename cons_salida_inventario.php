<?php
include('funciones_ui.php');
?>
<link rel="stylesheet" href="responsive/form-basic.css">
<link rel="stylesheet" href="flujo.css?id=<?php echo date('YmdsH') ?>" type="text/css" media="screen" />
<script>
	$(function() {
		$.get('cons_obtener_secuencia_salida.php',
			function(datos) {
				$('#h_secuencia').val(datos);
			}
		);
	});

	function agregar_solicitud() {
		$('#datos').load('cons_salida_inventario_agregar.php', {
				'inventario': $('#h_coru_id').val(),
				'cantidad': $('#cantidad').val(),
				'secuencia': $('#h_secuencia').val(),
				'proy_id': $('#i_proy_id').val(),
				'nive_id': $('#h_nive_id').val(),
				'responsable': $('#i_cosa_responsable').val()

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
			$('#result').load('cosd_cons_salidas_detalles_borrar.php?id=' + id,
				function() {
					llenar_solicitud();
				}
			);
		}
	}

	function llenar_solicitud() {
		$('#datos').load('cosd_cons_salidas_detalles_mostrar.php?nochk=jjjlae222' +
			"&coso_numero=" + $('#h_secuencia').val()
		);
	}

	function buscar_disponible() {
		$.get('cons_salida_inventario_disponible.php?id=' + $('#h_coru_id').val() +
			"&proy_id=" + $('#i_proy_id').val(),
			function(datos) {
				$('#bodega').val(datos);
			});
	}

	function procesar_salida() {
		$('#result').load('cons_salida_inventario_procesar.php?id=' + $('#h_secuencia').val() + '&i_cosa_responsable=' + $("#i_cosa_responsable").val() + "&nive_id=" + $("#nivel").val(),
			function() {
				alert('Salida procesada');
				location.reload();
			}
		);
	}

	function verificar_cantidad() {
		bodega = $('#bodega').val() * 1;
		cantidad = $('#cantidad').val() * 1;

		if (cantidad > bodega) $('#cantidad').val(bodega);
		if (bodega < 0) $('#cantidad').val(0);
	}
</script>
<input type=hidden id=h_secuencia>
<?php echo autocompletar_filtro('inventario', 'construccion_obtener_inventario.php', 'inventario', 2, 'h_coru_id', ',proy_id:', '$("#i_proy_id").val()', '', '', 'buscar_disponible()') ?>
<?php echo autocompletar_filtro('nivel', 'construccion_obtener_nivel.php', 'nivel', 1, 'h_nive_id', ',proy_id:', '$("#i_proy_id").val()', '', '', '') ?>

<div id='mainPage'>
	<form class="form-basic">
		<input type='hidden' id='h_coru_id'>
		<input type='hidden' id='h_nive_id'>
		<div class="form-title-row">
			<h1>SALIDA DE INVENTARIO</h1>
		</div>
		<div class="form-row">
			<label>
				<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'i_proy_id', 'proy_id', 'proy_nombre', 0, 0, 450, ' where proy_cons=1', '', '', '', '', '', '', '2') ?>
			</label>
		</div>
		<div class="form-row">
			<!-- <!-- <label> -->
						<!-- <?php echo catalogo('cons_solicitudes_responsables', 'Responsable', 'csre_nombre', 'csre_id', 'csre_id', 'csre_nombre', 0, 0, 450, '', '', '', '', '', '', '', '2') ?> -->
			<!-- <?php echo entrada('input', 'Responsable', 'i_cosa_responsable', '150') ?> -->
			<!-- </label> -->
			<label>
				<span>Responsable:</span>
				<input type=text id=i_cosa_responsable class=codigo_barra>
			</label>
		</div>
		<div class="form-row">
			<label>
				<span>Nivel:</span>
				<input type=text id=nivel class=codigo_barra>
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
				<span>En Bodega:</span>
				<input type=text id=bodega class=codigo_barra readonly>
			</label>
			<label>
				<span>Cantidad:</span>
				<input type=text id=cantidad class=codigo_barra onchange="verificar_cantidad()">
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

		<div class="form-row">
			<label>
				<a href="javascript:procesar_salida()" class="responsive_boton" id="btn_recibir">PROCESAR SALIDA</a>
			</label>
		</div>
	</form>
</div>
<div id=result></div>