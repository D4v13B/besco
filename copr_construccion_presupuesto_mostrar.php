<?php include('conexion.php'); ?> 



<script src='jquery/sorter/tablesort.min.js'></script>

        <script src='jquery/sorter/sorts/tablesort.number.min.js'></script>

        <script src='jquery/sorter/sorts/tablesort.date.min.js'></script>

        <script>$(function() {

          new Tablesort(document.getElementById('resultado'));

        });

        </script><div class='table-responsive table-striped table-bordered table-hover table-sm' style='text-align: center; align-items:center'>

<table id='resultado' class="table align-middle nicetable_th" style="width:99%">

<thead class='thead-dark'>

<tr>

<th class=tabla_datos_titulo>Proyecto</th>

<th class=tabla_datos_titulo>Fecha</th>

<th class=tabla_datos_titulo>Categoria</th>

<th class=tabla_datos_titulo>Sub-Categoria</th>

<th class=tabla_datos_titulo>Rubro</th>

<th class=tabla_datos_titulo>Herramienta</th>

<th class=tabla_datos_titulo>Cantidad</th>

<th class=tabla_datos_titulo>Monto</th>

<th class=tabla_datos_titulo>Total</th>

<th class=tabla_datos_titulo>Pendientes</th>

<th class=tabla_datos_titulo>Solicitado</th>

<th class=tabla_datos_titulo>Recibido en Obra</th>

<th class=tabla_datos_titulo>Entregado</th>

<th class=tabla_datos_titulo>Instalados</th>

<th class=tabla_datos_titulo>Nota</th>

<th class=tabla_datos_titulo_icono></th>

</tr>

</thead>

<tbody>

<?php

$f_proy_id=$_GET['f_proy_id'];

$f_copr_fecha=$_GET['f_copr_fecha'];

$f_cosu_id=$_GET['f_cosu_id'];

$f_coru_id=$_GET['f_coru_id'];

$f_copr_cantidad=$_GET['f_copr_cantidad'];

$f_copr_monto=$_GET['f_copr_monto'];

$where='';

if($f_proy_id!='' && $f_proy_id!='null') $where .="AND a.proy_id IN ($f_proy_id)";

if($f_copr_fecha!='' && $f_copr_fecha!='null') $where .="AND a.copr_fecha LIKE '%$f_copr_fecha%'";

if($f_cosu_id!='' && $f_cosu_id!='null') $where .="AND a.cosu_id IN ($f_cosu_id)";

if(isset($_GET["f_coru_id"]) && $_GET["f_coru_id"] != "undefined") $where .="AND a.coru_id IN ($f_coru_id)";

if($f_copr_cantidad!='' && $f_copr_cantidad!='null') $where .="AND a.copr_cantidad LIKE '%$f_copr_cantidad%'";

if($f_copr_monto!='' && $f_copr_monto!='null') $where .="AND a.copr_monto LIKE '%$f_copr_monto%'";



$qsql ="select proy_nombre, a.copr_fecha, a.coca_nombre, a.cosu_nombre, a.coru_nombre, a.copr_cantidad, a.copr_monto,

a.copr_pendientes, a.copr_comprados, a.copr_inventario, a.copr_utilizados, a.copr_nota, a.copr_id, a.copr_instalados,

if(coru_herramienta=1, 'SI','NO') herramienta

from construccion_presupuesto a, proyectos b, construccion_subcategorias c, construccion_rubros d, construccion_categorias e

WHERE 1=1 

AND a.proy_id=b.proy_id

AND a.cosu_id=c.cosu_id

AND a.coru_id=d.coru_id

AND c.coca_id=e.coca_id

$where

";



$rs = mysql_query($qsql);

$num = mysql_num_rows($rs);

$i=0;

while ($i<$num)

{

?>

<tr class='tabla_datos_tr'>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'proy_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'copr_fecha'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'coca_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'cosu_nombre'); ?></td>

<td class=tabla_datos><?php echo mysql_result($rs, $i, 'coru_nombre'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'herramienta'); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_cantidad'),2); ?></td>

<td class=tabla_datos style="text-align:right">$<?php echo number_format(mysql_result($rs, $i, 'copr_monto'),2); ?></td>

<td class=tabla_datos style="text-align:right">$<?php echo number_format(mysql_result($rs, $i, 'copr_monto')*mysql_result($rs, $i, 'copr_cantidad'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_pendientes'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_comprados'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_inventario'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_utilizados'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo number_format(mysql_result($rs, $i, 'copr_instalados'),2); ?></td>

<td class=tabla_datos style="text-align:center"><?php echo mysql_result($rs, $i, 'copr_nota'); ?></td>

            <td class=tabla_datos_iconos>

            <div Class='btn-group btn-group-sm'>

                     

					 <a Class='btn' href='javascript:editar(<?php echo mysql_result($rs, $i, 'copr_id'); ?>)' ;>

                        <svg style = 'width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>

                           <path fill = '#FFD43B' d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z' />

                        </svg>

                     </a>

					 

                     <a Class='btn' href='javascript:borrar(<?php echo mysql_result($rs, $i, 'copr_id'); ?>)' ;>

                        <svg style = 'width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>

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



