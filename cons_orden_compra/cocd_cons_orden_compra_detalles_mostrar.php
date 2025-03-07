<?php include('../conexion.php'); ?>

<script src='../jquery/sorter/tablesort.min.js'></script>
<script src='../jquery/sorter/sorts/tablesort.number.min.js'></script>
<script src='../jquery/sorter/sorts/tablesort.date.min.js'></script>
<script>
   $(function() {
      new Tablesort(document.getElementById('resultado'));
   });
</script>
<table id='resultado' class="table nicetable">
   <tr>
      <th class=tabla_datos_titulo>Compra #</th>
      <th class=tabla_datos_titulo>Proveedor</th>
      <th class=tabla_datos_titulo>Cantidad</th>
      <th class=tabla_datos_titulo>Pendientes</th>
      <th class=tabla_datos_titulo>Precio</th>
      <th class=tabla_datos_titulo>Descripción/Rubro</th>
      <th class=tabla_datos_titulo>ITBMS</th>
      <!-- <th class=tabla_datos_titulo_icono></th> -->
   </tr>
   <?php
   $f_orco_id = $_GET['f_orco_id'];
   $f_orcd_cantidad = $_GET['f_orcd_cantidad'];
   $f_orcd_precio = $_GET['f_orcd_precio'];
   $f_orcd_detalle = $_GET['f_orcd_detalle'];
   $f_orcd_itbms = $_GET['f_orcd_itbms'];
   $f_orcd_pendiente = $_GET["f_orcd_recibido"];
   $f_crpr_id = $_GET["f_crpr_id"];
   $where = '';
   if ($f_orco_id != '' && $f_orco_id != 'null') $where .= "AND a.orco_id IN ($f_orco_id)";
   if ($f_orcd_cantidad != '' && $f_orcd_cantidad != 'null') $where .= "AND a.orcd_cantidad LIKE '%$f_orcd_cantidad%'";
   if ($f_orcd_precio != '' && $f_orcd_precio != 'null') $where .= "AND a.orcd_precio LIKE '%$f_orcd_precio%'";
   if ($f_orcd_detalle != '' && $f_orcd_detalle != 'null') $where .= "AND a.orcd_detalle LIKE '%$f_orcd_detalle%'";
   if ($f_orcd_itbms != '' && $f_orcd_itbms != 'null') $where .= "AND a.orcd_itbms LIKE '%$f_orcd_itbms%'";
   if($f_orcd_pendiente != '' && $f_orcd_pendiente != 'null' && $f_orcd_pendiente == 1) $where .= " AND orcd_recibido = 0"; //Esto es para extraer los pendientes 
   if($f_crpr_id != '' && $f_crpr_id != 'null') $where .= " AND b.crpr_id = $f_crpr_id"; //Esto es para extraer los pendientes 

   $qsql = "select *, (orcd_cantidad - orcd_recibido) pendientes, c.copr_nombre from cons_orden_compra_detalles a,cons_orden_compra b, cons_proveedores c
         WHERE 1=1
      AND a.orco_id=b.orco_id AND b.crpr_id = c.copr_id
         $where
         ";

   $rs = mysql_query($qsql);
   $num = mysql_num_rows($rs);
   $i = 0;
   while ($i < $num) {
   ?>
      <tr class='tabla_datos_tr'>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'orco_numero'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'copr_nombre'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'orcd_cantidad'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'pendientes'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'orcd_precio'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'orcd_detalle'); ?></td>
         <td class=tabla_datos><?php echo mysql_result($rs, $i, 'orcd_itbms'); ?></td>

         <!-- <td class=tabla_datos_iconos>
            <div Class='btn-group btn-group-sm'>
               <a Class='btn' href='javascript:editar(<?php echo mysql_result($rs, $i, 'orcd_id'); ?>)' ;>
                  <svg style='width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
                     <path fill='#FFD43B' d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z' />
                  </svg>
               </a>
               <a Class='btn' href='javascript:borrar(<?php echo mysql_result($rs, $i, 'orcd_id'); ?>)' ;>
                  <svg style='width: 22px;' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
                     <path fill='#ad0000' d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z' />
                  </svg>
               </a>
            </div>
         </td> -->
      </tr>
   <?php
      $i++;
   }
   ?>
</table>