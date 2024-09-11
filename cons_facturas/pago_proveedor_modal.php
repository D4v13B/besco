<?php
include('../conexion.php');
include('../funciones.php');
$id = $_GET['id'];

$qsql ="SELECT a.fact_id, copr_nombre, faes_nombre, fact_total, fact_saldo, fact_numero
FROM cons_facturas a, cons_proveedores b, cons_facturas_estados c 
WHERE a.copr_id=b.copr_id 
AND a.faes_id=c.faes_id 
AND fact_id ='$id'
";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
if($num>0)
{
	$cliente = mysql_result($rs, $i, 'copr_nombre');
	$numero = mysql_result($rs, $i, 'fact_numero');
	$estado = mysql_result($rs, $i, 'faes_nombre');
	$total = mysql_result($rs, $i, 'fact_total');
	$saldo = mysql_result($rs, $i, 'fact_saldo');
}

?>
<script>
$(function () {
        $("#i_fecha").datepicker({ dateFormat: 'yymmdd' });
		$("#i_inicio").datepicker({ dateFormat: 'yymmdd' });
});

	var lineas=0;

function otra_linea()
{
	var $tableBody = $('#tbl').find("tbody"),
    $trLast = $tableBody.find("tr:first"),
    $trNew = $trLast.clone();
	
	$($trNew).find("td input:text,td select").each(function() {
            textVal = this.value;
            inputName = $(this).attr('id', this.id + '_' + lineas);
			//alert(inputName);
    });
	
    $trLast.after($trNew);
	lineas++;
	//alert(lineas);
}

function quiensoy(id)
{
	//alert(id.id);
}

function crear_pago_regular()
{
	$('#result').load("cons_facturas/pago_proveedor_crear.php?pid=" + $("#h6_id").val()
		+ "&monto=" + encodeURI($('#i_monto').val())
		+ "&recibo=" + encodeURI($('#i_recibo').val())
		+ "&fecha=" + encodeURI($('#i_fecha').val())
		+ "&concepto=" + encodeURI($('#i_concepto').val())
		+ "&forma=" + encodeURI($('#i_forma').val())
		+ "&banco=" + encodeURI($('#i_banco').val())
		+ "&tipo=" + encodeURI($('#i_tipo').val())
		+ "&cheque=" + encodeURI($('#i_cheque').val())
		+ "&arreglo=0"
		,
		function(data){
		//alert(data);
		alert ('Pago Realizado');
		$('#modal6').hide('slow');
		$('#overlay6').hide();
		//limpiar();
			
		
		mostrar();
		
		}
		);
}

function crear_pago_arreglo()
{
	//armo el arreglo del tipo
	var tipo = $('#i_tipo').val();
	var monto = $('#i_aplicado').val();
	
	var tmonto = $('#i_aplicado').val()*1;
	
	for (i = 0; i < lineas; i++) 
	{ 
		tipo = tipo + '|' + $('#i_tipo_' + i).val();
		monto = monto + '|' + $('#i_aplicado_' + i).val();
		tmonto = tmonto + $('#i_aplicado_' + i).val()*1;
	}
	
	//alert(tmonto);
	
	if(tmonto==$('#i_monto').val())
	{
$('#result').load("pago_proveedor_crear.php?pid=" + $("#h6_id").val()
		+ "&monto=" + monto
		+ "&recibo=" + encodeURI($('#i_recibo').val())
		+ "&fecha=" + encodeURI($('#i_fecha').val())
		+ "&concepto=" + encodeURI($('#i_concepto').val())
		+ "&forma=" + encodeURI($('#i_forma').val())
		+ "&banco=" + encodeURI($('#i_banco').val())
		+ "&tipo=" + tipo
		+ "&cheque=" + encodeURI($('#i_cheque').val())
		+ "&arreglo=1"
		,
		function(){
		alert ('Pago Realizado');
		$('#modal6').hide('slow');
		$('#overlay6').hide();
		//limpiar();
			
		
		mostrar();
		
		}
		);		
	}
	else
	{
		alert('Monto no concuerda!');
	}	
}

function poner_valor()
{
	$('#i_aplicado').val($('#i_monto').val());
}

function borrar_pago(id)
{
var resp = confirm("Esta seguro que desea eliminar este pago?");
if(resp)
	{
	$('#result').load("cons_facturas/pago_proveedor_borrar.php?pid=" + id,
	function()
	{
	$("#detalle_guia").load("cons_facturas/ver_proveedores_pagos.php?pid=" + $('#h6_id').val());
	mostrar();	
	}
	);
	
	}
}
</script>
<table class=nicetable style="width:98%">
<tr>
<td>Proveedor</td>
<td>Referencia</td>
<td>Estatus</td>
<td>Monto</td>
<td>Saldo</td>
</tr>
<tr>
<td><?php echo $cliente?></td>
<td><?php echo $numero?></td>
<td><?php echo $estado?></td>
<td><?php echo $total?></td>
<td><?php echo $saldo?></td>
</tr>
</table>
<table>
		<tr>
		<td class=etiquetas>Monto:</td>
		<td class=etiquetas align=left style="text-align:left !important"><input type=text id=i_monto onchange="poner_valor()" autocomplete=off value="<?php echo $saldo?>"></td>
		</tr>
		<tr>
		<td class=etiquetas>Fecha:</td>
		<td class=etiquetas><input type=text id=i_fecha autocomplete=off></td>
		</tr>
		</table>
		<table>
		<tr>
		<td>
			<table id=tbl>
				<tbody>
				<tr id=tr_a_clonar>
				<?php echo catalogo('cons_forma_pago','Forma de Pago','fopa_nombre','i_tipo','fopa_id','fopa_nombre','0','0','80 ') ?>
				<td class=etiquetas>Monto Aplicado:</td>
				<td><input type=text id=i_aplicado style="width:50px" onclick="quiensoy(this)" autocomplete=off></td>
				</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</table>
		<table>
		<tr>
		<td colspan=2><a href="javascript:crear_abono()" class=botones>Abonar</a>
		<input type=button id="btn_modificar" value="Modificar" class="botones"></td>
		</tr>
		</table>