<script>
function mostrar() {
$('#datos_mostrar').load('cons_facturas/rep_pago_proveedores_mostrar.php?nochk=1222'
	+ "&desde=" + $('#desde').val()
	+ "&hasta=" + $('#hasta').val()
	+ "&proveedor=" + $('#f_prov_id').val()
	);
}
</script>
<div id='separador'>
<table width='' class=filtros>
<tr>
<?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'f_prov_id', 'copr_id', 'copr_nombre', '0', '1', '150');?>
<?php echo entrada('fecha', 'Desde', 'desde') ?>
<?php echo entrada('fecha', 'Hasta', 'hasta') ?>
<td class='tabla_datos'><div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div></td>
<td><div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div></td>
</tr>
</table>
</div>
<div id='columna6'>
<div id='datos_mostrar'></div>
</div>

<div id=result></div>

