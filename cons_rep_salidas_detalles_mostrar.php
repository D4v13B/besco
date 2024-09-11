<?php include('conexion.php'); ?> 

<script src='jquery/sorter/tablesort.min.js'></script>
        <script src='jquery/sorter/sorts/tablesort.number.min.js'></script>
        <script src='jquery/sorter/sorts/tablesort.date.min.js'></script>
        <script>$(function() {
          new Tablesort(document.getElementById('resultado'));
        });
        </script><div class='table-responsive table-striped table-bordered table-hover table-sm' style='text-align: center; align-items:center'>
<table id='resultado' class="nicetable_th table align-middle" style="width:98%">
<thead class='thead-dark'>
<tr>
<th class=tabla_datos_titulo>PRODUCTO</th>
<th class=tabla_datos_titulo>CANTIDAD</th>
<th class=tabla_datos_titulo>DISPONIBLES<BR>(BODEGA)</th>
<th class=tabla_datos_titulo>ENTREGADOS</th>
<th class=tabla_datos_titulo>INSTALADOS</th>
<th class=tabla_datos_titulo_icono></th>
</tr>
</thead>
<tbody>
<?php
$cosa_id=$_GET['cosa_id'];

$qsql ="SELECT  coru_nombre, cosd_cantidad, cosd_id, 
(SELECT COALESCE(SUM(copr_inventario),0) FROM construccion_presupuesto WHERE coru_id=a.coru_id AND proy_id=c.proy_id) disponible,
(SELECT COALESCE(SUM(copr_utilizados),0) FROM construccion_presupuesto WHERE coru_id=a.coru_id AND proy_id=c.proy_id) utilizados,
(SELECT COALESCE(SUM(copr_instalados),0) FROM construccion_presupuesto WHERE coru_id=a.coru_id AND proy_id=c.proy_id) instalados
FROM cons_salidas_detalles a, construccion_rubros b, cons_salidas c, proyectos d
WHERE a.coru_id=b.coru_id
AND c.proy_id=d.proy_id
AND cosa_id='$cosa_id'
AND a.cosa_numero=c.cosa_numero";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
{
	$cantidad = mysql_result($rs, $i, 'cosd_cantidad');
	$disponible = mysql_result($rs, $i, 'disponible');
	if($disponible<$cantidad)
	{
		$fondo = "background-color:#ff0000;color:#ffffff";
	}
	else
	{
		$fondo = "background-color:#ffffff;color:#000000";
	}
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coru_nombre'); ?></td>
<td class=tabla_datos style="text-align:center;<?php echo $fondo?>"><?php echo mysql_result($rs, $i, 'cosd_cantidad'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'disponible'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'utilizados'); ?></td>
<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'instalados'); ?></td>

            <td class=tabla_datos_iconos>
            <div Class='btn-group btn-group-sm'>
                     <a Class='btn' href='javascript:borrar(<?php echo mysql_result($rs, $i, 'cosd_id'); ?>)' ;>
                        <svg style = 'width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                           <path fill = '#ad0000' d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z' />
                        </svg>
                     </a>
                  </div></td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
</div>

