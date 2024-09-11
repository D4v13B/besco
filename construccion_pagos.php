<script>
$(function () {
        $("#i_fecha").datepicker({ dateFormat: 'yymmdd' });
		$("#m_fecha").datepicker({ dateFormat: 'yymmdd' });
    });
	
function mostrar()
{
		$("#clientes").load("construccion_pagos_mostrar.php?id=1" 
		+ "&proyecto=" + $('#proy_id').val()
		);
}

function exportar()
{
$("#clientes").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Reporte de Comisiones",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
}

function pagos(id)
{
$('#modal').show();
$('#overlay').show();
$('#h_id').val(id);

$('#d_pagos').load('construccion_pagos_detalles_mostrar.php?copr_id=' + id);
}

function crear() {
$('#result').load('construccion_pagos_detalles_crear.php?idmp=1'
	 + '&copr_id=' + encodeURI($('#h_id').val())
     + '&i_cohp_monto=' + encodeURI($('#i_cohp_monto').val())
     + '&i_cohp_cheque=' + encodeURI($('#i_cohp_cheque').val())
     + '&i_banc_id=' + encodeURI($('#i_banc_id').val())
	 + '&i_pagado_a=' + encodeURI($('#i_pagado_a').val())
	 + '&i_fecha=' + encodeURI($('#i_fecha').val())
     + '&i_cohp_comentario=' + encodeURI($('#i_cohp_comentario').val())
    ,
    function(){
        pagos($('#h_id').val());
    }
  );
}
function modificar() {
		$('#result').load('construccion_pagos_detalles_modificar.php?id=' + $('#h2_id').val()
			 + '&m_cohp_monto=' + encodeURI($('#m_cohp_monto').val())
			 + '&m_cohp_cheque=' + encodeURI($('#m_cohp_cheque').val())
			 + '&m_banc_id=' + encodeURI($('#m_banc_id').val())
			 + '&m_pagado_a=' + encodeURI($('#m_pagado_a').val())
			 + '&m_fecha=' + encodeURI($('#m_fecha').val())
			 + '&m_cohp_comentario=' + encodeURI($('#m_cohp_comentario').val())
			 ,
			function(){
			   $('#modal2').hide('slow');
			   $('#overlay2').hide();
			   pagos($('#h_id').val());
			}
		  );	
}

function borrar(id)
{
var agree=confirm('¿Está seguro?');
if(agree) {
   $('#result').load('construccion_pagos_detalles_borrar.php?id=' + id
   ,
   function()
     {
     pagos($('#h_id').val());
     }
  );
 }
}
function editar(id)
{
$('#modal2').show();
$('#overlay2').show();
$('#h2_id').val(id);
$.get('construccion_pagos_detalles_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(resp);
     $('#m_cohp_monto').val(r_array[0]);
     $('#m_cohp_cheque').val(r_array[1]);
     $('#m_banc_id').val(r_array[2]);
     $('#m_cohp_comentario').val(r_array[3]);
	 $('#m_pagado_a').val(r_array[4]);
	 $('#m_fecha').val(r_array[5]);
     });
}
</script>
<div id="separador_ancho">
<table class=filtros>
	<tr>
	<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'proy_id', 'proy_id', 'proy_nombre', 0,1,150);?>
	<td class=tabla_datos_titulo><div id="b_mostrar" class="botones"><a href="javascript:mostrar()">Mostrar</a></div></td>
	<td><a href="javascript:exportar();"><img src="imagenes/excel.png" border=0></a></td>
	</tr>
</table>
</div>
<div id="columna6">
	<div id="clientes"></div>
</div>

<div id='overlay'></div>
<div id='modal'><div id='content'>
<input type=hidden id=h_id>
<table>
<tr>
<td class='etiquetas'>Monto:</td>
<td><input type='text' id=i_cohp_monto size=40 class='entradas'></td>
</tr>
<tr>
<?php echo entrada('input', 'Fecha', 'i_fecha');?>
</tr>
<tr>
<td class='etiquetas'>Cheque:</td>
<td><input type='text' id=i_cohp_cheque size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('bancos', 'Banco', 'banc_nombre', 'i_banc_id', 'banc_id', 'banc_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo entrada('input', 'Pagado a', 'i_pagado_a');?>
</tr>
<tr>
<td class='etiquetas'>Comentario:</td>
<td><input type='text' id=i_cohp_comentario size=40 class='entradas'></td>
</tr>
<tr>
<td colspan=2><a href='javascript:crear()' class='botones'>Crear</a></td>
</tr>
</table>
<div id=d_pagos></div>
</div>
<a href='#' id='close'>close</a>
</div>


<div id='overlay2'></div>
<div id='modal2'><div id='content2'>
<input type=hidden id=h2_id><table>
<tr>
<td class='etiquetas'>Monto:</td>
<td><input type='text' id=m_cohp_monto size=40 class='entradas'></td>
</tr>
<tr>
<?php echo entrada('input', 'Fecha', 'm_fecha');?>
</tr>
<tr>
<td class='etiquetas'>Cheque:</td>
<td><input type='text' id=m_cohp_cheque size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('bancos', 'Banco', 'banc_nombre', 'm_banc_id', 'banc_id', 'banc_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo entrada('input', 'Pagado a', 'm_pagado_a');?>
</tr>
<tr>
<td class='etiquetas'>Comentario:</td>
<td><input type='text' id=m_cohp_comentario size=40 class='entradas'></td>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='#' id='close2'>close</a>
</div>

<div id=result></div>
