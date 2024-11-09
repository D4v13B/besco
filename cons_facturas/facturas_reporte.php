<!--SCRIPTS-->

<script type="text/javascript" src="jquery/jquery.floatThead.min.js"></script>

<script>

$(function () {

		$("#desde").datepicker({ dateFormat: 'yymmdd' });

		$("#hasta").datepicker({ dateFormat: 'yymmdd' });

});

function cancelar(id){

	$.ajax({
		method: "GET",
		url: "cons_facturas/factura_devolver.php",
		data: {
			id
		},
		success: res => {
			mostrar()
		}
	})
}



function mostrar() {



$('#datos_mostrar').load('cons_facturas/facturas_reporte_mostrar.php?db=1'

	+ '&proveedor=' + encodeURI($('#f_proveedor').val())

	+ '&f_estatus=' + encodeURI($('#f_estatus').val())

	+ '&desde=' + encodeURI($('#desde').val())

	+ '&hasta=' + encodeURI($('#hasta').val())

	,

	function()

	{

	//

	}

	);

}



function exportar()

{

$("#datos_mostrar").table2excel({

					exclude: ".noExl",

					name: "Excel Document Name",

					filename: "facturacion",

					exclude_img: true,

					exclude_links: true,

					exclude_inputs: true

				});

}





function ver_detalle(id)

{

	$('#h6_id').val(id);

			$('#modal6').show();

			$('#overlay6').show();

	$('#detalle_guia').load("cons_facturas/facturas_reporte_datos.php?id=" + id,

			function()

			{

			$('#modal6').center();		

			}

			);

	

}



function ver_factura(id)

{

			$('#h6_id').val(id);

			$('#modal6').show();

			$('#overlay6').show();

	$('#detalle_guia').load("facturas_reporte_datos.php?id=" + id,

			function()

			{

			$('#modal6').center();		

			}

			);

	

}





function borrar(id)

{

var agree=confirm('¿Está seguro?');

if(agree) {

   $('#result').load('facturas_reporte_borrar.php?id=' + id

   ,

   function()

     {

     mostrar();

     }

  );

 }

}



//PAGOS 

function abonar(id)

{

	$('#modal6').show();

	$('#overlay6').show();

	$('#h6_id').val(id);

	$("#captura").load("cons_facturas/pago_proveedor_modal.php?id=" + id

	,

	function()

	{

		$("#detalle_guia").load("cons_facturas/ver_proveedores_pagos.php?pid=" + id

		,

		function()

		{

			$('#btn_modificar').hide();

			//limpiar();

		}

		);

	}

	);

}



function crear_abono()

{

	nvalor = $('#btn_abonar').val();

	if (nvalor!='Cancelar')

	{

		var monto = $("#i_monto").val();

		monto = monto.replace(/,/g, "");

		$("#i_monto").val(monto);

		

		//alert(lineas);

		if(lineas==0)

		{

			crear_pago_regular();	

		}

		else

		{

			crear_pago_arreglo();

		}

	}

	else

	{

		$('#btn_abonar').val('Abonar');

		$('#btn_modificar').hide();

		document.getElementById("captura").style.backgroundColor='#ffffff';

		limpiar();

		}

}

</script>



<div id="separador">

<table class=filtros>

	<tr>

	<?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'f_proveedor', 'copr_id', 'copr_nombre', '0', '1', '150');?>

	<?php echo catalogo('cons_facturas_estados', 'Estado', 'faes_nombre', 'f_estatus', 'faes_id', 'faes_nombre', '0', '1', '150');?>

	<?php echo entrada('fecha', 'Desde', 'desde',150)?>

	<?php echo entrada('fecha', 'Hasta', 'hasta',150)?>

	</tr>

	<tr>

	<td></td>

	<td></td>

	<td></td>

	<td></td>

	<td></td>

	<td></td>

	<td><a href="javascript:mostrar()" class=botones>Mostrar</a></td>

	<td><a href="javascript:exportar()"><img src="imagenes/excel.png" style="width:20px;height:20px"></a></td>

	</tr>

</table>

</div>

<div id="columna6">

	<div id="datos_mostrar" style="overflow:auto"></div>

</div>

<!--MODAL-->





<div id='overlay6'></div>

<div id='modal6'><div id='content6'>

	<input type=hidden id=h6_id>

	<div id=captura></div>

	<div id=detalle_guia></div>

</div>

<a href='javascript:void(0)' id='close6'>close</a>

</div>





<div id='overlay7'></div>

<div id='modal7'><div id='content7'>

	<input type=hidden id=h7_id>

	<div id=detalle_nota_credito></div>

</div>

<a href='javascript:void(0)' id='close7'>close</a>

</div>



<div id=result></div>