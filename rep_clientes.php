<?php

$sql ="select cles_nombre, cles_id from clientes_estados order by cles_nombre";

$rs_prti = mysql_query($sql);

$num_prti = mysql_num_rows($rs_prti);

$i=0;



$sql ="select usua_id, usua_nombre from usuarios order by usua_nombre";

$rs_ases = mysql_query($sql);

$num_ases = mysql_num_rows($rs_ases);

$i=0;

?>

<script>

$(function () {

        $("#desde").datepicker({ dateFormat: 'yymmdd' });

    });

	

$(function () {

        $("#hasta").datepicker({ dateFormat: 'yymmdd' });

    });



$(function () {

$('#mostrar').click(

		function(){

		if(chk_interesados.checked)

		{interesado=1;}

		else

		{interesado=0;}

        $("#clientes").load("rep_clientes_mostrar.php?estatus=" + $("#estatus").val()

		+ "&desde=" + $("#desde").val()

		+ "&hasta=" + $("#hasta").val()

		+ "&nombre=" + $("#b_nombre").val()

		+ "&apellido=" + $("#b_apellido").val()

		+ "&asesor=" + $('#b_asesor').val()

		+ "&interesados=" + interesado

		);

		});

    });



function exportar()

{

$("#clientes").table2excel({

					exclude: ".noExl",

					name: "Reporte de Clientes",

					filename: "Reporte de Clientes",

					exclude_img: true,

					exclude_links: true,

					exclude_inputs: true

				});

}

</script>

<div id="separador">

	<table class=filtros>

	<tr>

	<td class="tabla_datos_titulo">Nombre:</td>

	<td class="tabla_datos"><input type=text id=b_nombre></td>

	<td class="tabla_datos_titulo">Apellido:</td>

	<td class="tabla_datos"><input type=text id=b_apellido></td>

	<td class="tabla_datos_libre">Desde:</td><td class="tabla_datos_libre"><input type="text" id="desde" class="input_chico"></td>

	<td class="tabla_datos_libre">Hasta:</td><td class="tabla_datos_libre"><input type="text" id="hasta" class="input_chico"></td>

	<td  class="tabla_datos_libre">Usuario:<select id=b_asesor>

		<option value=0>TODOS</option>

			<?php

			$i=0;

			while($i<$num_ases)

			{?>

			<option value="<?php echo mysql_result($rs_ases, $i, 'usua_id');?>"><?php echo mysql_result($rs_ases, $i, 'usua_nombre');?></option>

			<?php

			$i++;

			}

			?>

		</select>

	</td>

	</tr>

	<tr>

	<td class="tabla_datos_libre">Estatus:</td><td>

	<select id=estatus>

	<option value="0">TODOS</option>

	<?php

	$i=0;

	while ($i<$num_prti)

	{

	?>

	<option value="<?php echo mysql_result($rs_prti,$i,'cles_id');?>"><?php echo mysql_result($rs_prti,$i,'cles_nombre');?></option>

	<?php

	$i++;

	}

	?>

	</select>

	</td>

	<td class="tabla_datos_libre"><input type=checkbox id=chk_interesados></td>

	<td class="tabla_datos_libre">Mostrar no interesados</td>

	<td colspan=2 class="tabla_datos_libre"><div id="mostrar" class="botones"><a href="#">Mostrar</a></div></td>

	<td><a href="javascript:exportar();"><img src="imagenes/excel.png" border=0></a></td>

	</tr>

	</table>

</div>

<div id="columna6">

	<div id="clientes"></div>

</div>

<div id=result></div>