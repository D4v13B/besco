<?php 

function armar_encabezado_sorter($columnas, $ordenar_por='')

{

	$i=0;

	$columnas_header = explode(",", $columnas);

	foreach ($columnas_header as $valor)

	{

		if($i==$ordenar_por) {$data_sort='data-sort-default';} else {$data_sort='';}

		$encabezado .= "<th class=tabla_datos_titulo $data_sort >$valor</th>";

		$i++;

	}

	

	return $encabezado;

}



function autocompletar_filtro($campo, $obtener_link, $variable_request, $min_largo, $variable_id, 

				$post_campo='', $post_valor='', $con_modal='',$funcion_modal='', $onseleccion='')

{

	/*

	$campo = el que va a ser input y va a funcionar con el autocomplete 

	$obtener_link = es el php que hace la búsqueda del autocomplete 

	$variable_request = recibe el valor texto escogido en el POST

	$min_largo = desde que caracter comienza a buscar 

	$variable_id = es el hidden input que va a guardar el resultado que se seleccione 

	*/

	$script_autocompletar = "$('#". $campo ."' ).autocomplete({

                source: function( request, response ) {

                    $.ajax({

                        url: '$obtener_link',

                        dataType: 'json',

                        data: {

                            $variable_request: request.term

							$post_campo $post_valor

                        },

                        success: function( data ) {

                            response( data );

                        }

                    });

                },

				minLength:$min_largo

				,

				open: function()

				{

					setTimeout(function () {

						$('.ui-autocomplete').css('z-index', 99999999999999);

					}, 0);

				},

				select: function(event, ui) {

				  var e = ui.item;

				  $('#". $variable_id . "').val(e.id);

				  $onseleccion

		  

				}

            });

		";

	if($con_modal!='')

	{

	$modal = "<div id='overlay" . $modal . "'></div>

			<div id='modal" . $modal . "'><div id='content" . $modal . "'>

			<input type=hidden id=h" . $modal . "_id>

				<div id='div_modal_" . $modal . "'>

					<input type='text' style='width:250px;height:40px;font-size:14pt' id=in_buscar_cliente class=in_buscar_cliente autocomplete='off'>

					<input type=hidden id=cliente_busqueda>

					<div class=botones onclick='$funcion_modal'>ASIGNAR CLIENTE</DIV>

				</div>

			</div>

			<a href='javascript:void(0);' id='close" . $modal . "'>close</a>

			</div>";

	}		

	echo "<script>

	$(function () {

	$script_autocompletar

	});

	</script>";

}



?>