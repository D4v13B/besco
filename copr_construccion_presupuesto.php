<?php include('funciones_ui.php') ?>

<script>
  function crear()

  {

    $('#result').load('copr_construccion_presupuesto_crear.php'

      ,

      {

        'i_proy_id': $('#i_proy_id').val(),

        'i_copr_fecha': $('#i_copr_fecha').val(),

        'i_cosu_id': $('#i_cosu_id').val(),

        'i_coru_id': $('#i_coru_id').val(),

        'i_copr_cantidad': $('#i_copr_cantidad').val(),

        'i_copr_monto': $('#i_copr_monto').val(),

        'i_copr_nota': $('#i_copr_nota').val()

      }

      ,

      function() {

        $('#modal').hide('slow');

        $('#overlay').hide();

        mostrar();

      }

    );

  }

  function modificar() {

    $('#result').load('copr_construccion_presupuesto_modificar.php?id=' + $('#h2_id').val()

      ,

      {

        'm_copr_id': $('#m_copr_id').val(),

        'm_proy_id': $('#m_proy_id').val(),

        'm_copr_fecha': $('#m_copr_fecha').val(),

        'm_cosu_id': $('#m_cosu_id').val(),

        'm_coru_id': $('#m_coru_id').val(),

        'm_copr_cantidad': $('#m_copr_cantidad').val(),

        'm_copr_monto': $('#m_copr_monto').val(),

        'm_copr_nota': $('#m_copr_nota').val()

      }

      ,

      function() {

        $('#modal2').hide('slow');

        $('#overlay2').hide();

        mostrar();

      }

    );

  }

  function borrar(id)

  {

    var agree = confirm('¿Está seguro?');

    if (agree) {

      $('#result').load('copr_construccion_presupuesto_borrar.php?id=' + id

        ,

        function()

        {

          mostrar();

        }

      );

    }

  }

  function editar(id)

  {

    $('#modal2').show();

    $('#overlay2').show();

    $('#modal2').center();

    $('#h2_id').val(id);

    $.get('copr_construccion_presupuesto_datos.php?id=' + id, function(data) {

      var resp = data;

      r_array = resp.split('||');

      //alert(r_array[0]);

      $('#m_proy_id').val(r_array[1]);

      $('#m_copr_fecha').val(r_array[2]);

      $('#m_cosu_id').val(r_array[3]);

      $('#m_coru_id').val(r_array[4]);

      $('#m_copr_cantidad').val(r_array[5]);

      $('#m_copr_monto').val(r_array[6]);

      $('#m_copr_nota').val(r_array[7]);

    });

  }

  function mostrar() {

    $('#datos_mostrar').load('copr_construccion_presupuesto_mostrar.php?nochk=jjjlae222'

      +
      "&f_proy_id=" + $('#f_proy_id').val()

      +
      "&f_copr_fecha=" + $('#f_copr_fecha').val()

      +
      "&f_cosu_id=" + $('#f_cosu_id').val()

      +
      "&f_coru_id=" + $('#f_coru_id').val()

      +
      "&f_copr_cantidad=" + $('#f_copr_cantidad').val()

      +
      "&f_copr_monto=" + $('#f_copr_monto').val()

    );
  }

  function exportar() {
    $("#datos_mostrar").table2excel({

      exclude: ".noExl",

      name: "Reporte de Clientes",

      filename: "Reporte de presupuesto",

      exclude_img: true,

      exclude_links: true,

      exclude_inputs: true

    });
  }
</script>

<?php echo autocompletar_filtro('inventario', 'construccion_obtener_inventario.php', 'inventario', 2, 'h_coru_id', ',cosu_id:', '$("#i_cosu_id").val()') ?>

<input type='hidden' id='h_coru_id'>

<div id='separador'>

  <table width='' class=filtros>

    <tr>
    <tr>

      <?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'f_proy_id', 'proy_id', 'proy_nombre', '0', '1', '150'); ?>

      <?php echo entrada('fecha', 'Fecha', 'f_copr_fecha', '150') ?>

      <?php echo catalogo('construccion_subcategorias', 'Sub-Categoria', 'cosu_nombre', 'f_cosu_id', 'cosu_id', 'cosu_nombre', '0', '1', '150'); ?>

    </tr>

    <tr>

      <?php echo catalogo('construccion_rubros', 'Rubro', 'coru_nombre', 'f_coru_id', 'coru_id', 'coru_nombre', '0', '1', '150'); ?>

      <?php echo entrada('input', 'Cantidad', 'f_copr_cantidad', '150') ?>

      <?php echo entrada('input', 'Monto', 'f_copr_monto', '150') ?>

    </tr>

    <tr>

      <td class='tabla_datos'>
        <div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
      </td>

      <td>
        <div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div>
      </td>

      <td>
        <div><a href='javascript:exportar()' class=botones>EXPORTAR A EXCEL</a></div>
      </td>

    </tr>

  </table>

</div>

<div id='columna6'>

  <div id='datos_mostrar'></div>

</div>

<!--MODAL-->

<div id='overlay'></div>

<div id='modal'>
  <div id='content'>

    <table>

      <tr>

        <?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'i_proy_id', 'proy_id', 'proy_nombre', '0', '0', '150', ' where proy_cons=1'); ?>

      </tr>

      <tr>

        <?php echo entrada('fecha', 'Fecha', 'i_copr_fecha', '150', date('Ymd')); ?>

      </tr>

      <!--

<tr>

<?php echo catalogo('vw_cate_subcate', 'Categoria', 'casu', 'i_cosu_id', 'cosu_id', 'casu', '0', '2', '150'); ?>

</tr>

-->

      <tr>

        <!-- <?php echo entrada('input', 'Producto Inventario', 'inventario', '350'); ?> -->

        <?php echo catalogo('construccion_rubros', 'Rubro', 'coru_nombre', 'i_coru_id', 'coru_id', 'coru_nombre', '0', '0', '150'); ?>

      </tr>

      <tr>

        <?php echo entrada('input', 'Cantidad', 'i_copr_cantidad', '150'); ?>

      </tr>

      <tr>

        <?php echo entrada('input', 'Monto', 'i_copr_monto', '150'); ?>

      </tr>

      <tr>

        <?php echo entrada('input', 'Nota', 'i_copr_nota', '350'); ?>

      </tr>

      <tr>

        <td colspan=2><a href='javascript:crear()' class='botones'>Crear</a></td>

      </tr>

    </table>

  </div>

  <a href='#' id='close'>close</a>

</div>



<div id='overlay2'></div>

<div id='modal2'>
  <div id='content2'>

    <input type=hidden id=h2_id>
    <table>

      <!--

<tr>

<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'm_proy_id', 'proy_id', 'proy_nombre', '0', '0', '150'); ?>

</tr>

<tr>

<?php echo entrada('fecha', 'Fecha', 'm_copr_fecha', '150'); ?>

</tr>

<tr>

<?php echo catalogo('vw_cate_subcate', 'Categoria', 'casu', 'm_cosu_id', 'cosu_id', 'casu', '0', '2', '150'); ?>

</tr>

<tr>

<?php echo catalogo('construccion_rubros', 'Rubro', 'coru_nombre', 'm_coru_id', 'coru_id', 'coru_nombre', '0', '0', '150'); ?>

</tr>

<tr>

<?php echo entrada('input', 'Cantidad', 'm_copr_cantidad', '150'); ?>

</tr>

<tr>

<?php echo entrada('input', 'Monto', 'm_copr_monto', '150'); ?>

</tr>

-->

      <tr>

        <?php echo entrada('input', 'Nota', 'm_copr_nota', '350'); ?>

      </tr>

      <tr>

        <td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>

      </tr>

    </table>

  </div>

  <a href='javascript:void(0);' id='close2'>close</a>

</div>



<div id=result></div>