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
<th class=tabla_datos_titulo>Número de Salida</th>
<th class=tabla_datos_titulo>Fecha</th>
<th class=tabla_datos_titulo>Fecha Entrega</th>
<th class=tabla_datos_titulo>Fecha Instalado</th>
<th class=tabla_datos_titulo>Fecha Retorno</th>
<th class=tabla_datos_titulo>Usuario</th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
<th class=tabla_datos_titulo_iconos style="width:20px"></th>
</tr>
</thead>
<tbody>
<?php
$f_cose_id=$_GET['f_cose_id'];
$f_coso_numero=$_GET['f_coso_numero'];
$where='';
if($f_cose_id!='' && $f_cose_id!='null') $where .="AND a.cose_id IN ($f_cose_id)";
if($f_coso_numero!='' && $f_coso_numero!='null') $where .="AND a.coso_numero LIKE '%$f_coso_numero%'";

$qsql ="SELECT cosa_id, cose_nombre, cosa_numero, cosa_fecha, proy_nombre, a.cose_id, cosa_fecha_entrega, cosa_fecha_instalado, cosa_fecha_retorno,
(SELECT usua_nombre FROM usuarios WHERE usua_id=a.usua_id) usuario 
FROM cons_salidas a, cons_salidas_estados b, proyectos c
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
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosa_numero'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosa_fecha'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosa_fecha_entrega'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosa_fecha_instalado'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'cosa_fecha_retorno'); ?></td>
<td class=tabla_datos><?php echo mysql_result($rs, $i, 'usuario'); ?></td>

            <td class=tabla_datos_iconos>
			
				<div Class='btn-group btn-group-sm'>
					<a Class='btn' href='javascript:ver(<?php echo mysql_result($rs, $i, 'cosa_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
					<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
					</svg>
					</a>
				</div>
			
			</td>
			<td>
			<?php 
			//solo se procesa si está pendiente 
			if($cose_id==1) {?>
				<div>
					<a Class='btn' title="Procesar" href='javascript:procesar(<?php echo mysql_result($rs, $i, 'cosa_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zm-204.7-98.1l184-184c6.2-6.2 6.2-16.4 0-22.6l-22.6-22.6c-6.2-6.2-16.4-6.2-22.6 0L184 302.7l-70.1-70.1c-6.2-6.2-16.4-6.2-22.6 0l-22.6 22.6c-6.2 6.2-6.2 16.4 0 22.6l104 104c6.2 6.3 16.4 6.3 22.6 0z"/></svg>
					</a>
				</div>
			<?php }?>
			</td>
			
			<td>
			<?php 
			//solo se instala si esta en cose_id 2
			if($cose_id==2) {?>
				<div>
					<a Class='btn' title="Instalar" href='javascript:instalar(<?php echo mysql_result($rs, $i, 'cosa_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M413.1 222.5l22.2 22.2c9.4 9.4 9.4 24.6 0 33.9L241 473c-9.4 9.4-24.6 9.4-33.9 0L12.7 278.6c-9.4-9.4-9.4-24.6 0-33.9l22.2-22.2c9.5-9.5 25-9.3 34.3 .4L184 343.4V56c0-13.3 10.7-24 24-24h32c13.3 0 24 10.7 24 24v287.4l114.8-120.5c9.3-9.8 24.8-10 34.3-.4z"/></svg>
					</a>
				</div>
			<?php }?>
			</td>
			
			<td>
			<?php 
			//solo se instala si esta en cose_id 2
			if($cose_id==2) {?>
				<div>
					<a Class='btn' title="Retornar" href='javascript:retornar(<?php echo mysql_result($rs, $i, 'cosa_id'); ?>)' ;>
					<svg style = 'width: 22px;' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M212.3 224.3H12c-6.6 0-12-5.4-12-12V12C0 5.4 5.4 0 12 0h48c6.6 0 12 5.4 12 12v78.1C117.8 39.3 184.3 7.5 258.2 8c136.9 1 246.4 111.6 246.2 248.5C504 393.3 393.1 504 256.3 504c-64.1 0-122.5-24.3-166.5-64.2-5.1-4.6-5.3-12.6-.5-17.4l34-34c4.5-4.5 11.7-4.7 16.4-.5C170.8 415.3 211.6 432 256.3 432c97.3 0 176-78.7 176-176 0-97.3-78.7-176-176-176-58.5 0-110.3 28.5-142.3 72.3h98.3c6.6 0 12 5.4 12 12v48c0 6.6-5.4 12-12 12z"/></svg>
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

