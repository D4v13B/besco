<?php include('conexion.php'); ?> 

<script src='jquery/sorter/tablesort.min.js'></script>
        <script src='jquery/sorter/sorts/tablesort.number.min.js'></script>
        <script src='jquery/sorter/sorts/tablesort.date.min.js'></script>
        <script>$(function() {
          new Tablesort(document.getElementById('resultado'));
        });
        </script><div class='table-responsive table-striped table-bordered table-hover table-sm' style='text-align: center; align-items:center'>
<table id='resultado' class="nicetable_th" style="width:99%">
<thead class='thead-dark'>
<tr>
<th class=tabla_datos_titulo>Estado</th>
<th class=tabla_datos_titulo>Proyecto</th>
<th class=tabla_datos_titulo>Número de Solicitud</th>
<th class=tabla_datos_titulo>Fecha</th>
<th class=tabla_datos_titulo>Usuario</th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
</tr>
</thead>
<tbody>
<?php
$f_cose_id=$_GET['f_cose_id'];
$f_coso_numero=$_GET['f_coso_numero'];
$f_coso_fecha=$_GET['f_coso_fecha'];
$f_usua_id=$_GET['f_usua_id'];
$where='';
if($f_cose_id!='' && $f_cose_id!='null') $where .="AND a.cose_id IN ($f_cose_id)";
if($f_coso_numero!='' && $f_coso_numero!='null') $where .="AND a.coso_numero LIKE '%$f_coso_numero%'";

$qsql ="select coso_id, cose_nombre, coso_numero, coso_fecha, proy_nombre, a.cose_id,
(select usua_nombre from usuarios where usua_id=a.usua_id) usuario 
from cons_solicitudes a, cons_solicitudes_estados b, proyectos c
WHERE a.proy_id=c.proy_id
AND a.cose_id=b.cose_id
$where
";

$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
while ($i<$num)
{
	$cose_id = mysql_result($rs, $i, 'cose_id');
?>
<tr class='tabla_datos_tr'>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cose_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'proy_nombre'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coso_numero'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coso_fecha'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usuario'); ?></td>

            <td class=tabla_datos_iconos>
			<?php if($cose_id<=2) {?>
				<div Class='btn-group btn-group-sm'>
					<a Class='btn' href='javascript:ver(<?php echo mysql_result($rs, $i, 'coso_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
					<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
					</svg>
					</a>
				</div>
			<?php }?>
			</td>
			<td>
			<?php if($cose_id<=2) {?>
				<div>
					<a Class='btn' href='javascript:eliminar(<?php echo mysql_result($rs, $i, 'coso_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
					<path fill = '#ad0000' d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z' />
					</svg>
					</a>
				</div>
			<?php }?>
			</td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
</div>

