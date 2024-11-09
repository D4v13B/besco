<script>
  function crear() {
    $('#result').load('cons_orden_compra/cocd_cons_orden_compra_detalles_crear.php', {
        'i_orco_id': $('#i_orco_id').val(),
        'i_orcd_cantidad': $('#i_orcd_cantidad').val(),
        'i_orcd_precio': $('#i_orcd_precio').val(),
        'i_orcd_detalle': $('#i_orcd_detalle').val(),
        'i_orcd_itbms': $('#i_orcd_itbms').val()
      },
      function() {
        $('#modal').hide('slow');
        $('#overlay').hide();
        mostrar();
      }
    );
  }

  function modificar() {
    $('#result').load('cons_orden_compra/cocd_cons_orden_compra_detalles_modificar.php?id=' + $('#h2_id').val(), {
        'm_orcd_id': $('#m_orcd_id').val(),
        'm_orco_id': $('#m_orco_id').val(),
        'm_orcd_cantidad': $('#m_orcd_cantidad').val(),
        'm_orcd_precio': $('#m_orcd_precio').val(),
        'm_orcd_detalle': $('#m_orcd_detalle').val(),
        'm_orcd_itbms': $('#m_orcd_itbms').val()
      },
      function() {
        $('#modal2').hide('slow');
        $('#overlay2').hide();
        mostrar();
      }
    );
  }

  function borrar(id) {
    var agree = confirm('¿Está seguro?');
    if (agree) {
      $('#result').load('cons_orden_compra/cocd_cons_orden_compra_detalles_borrar.php?id=' + id,
        function() {
          mostrar();
        }
      );
    }
  }

  function editar(id) {
    $('#modal2').show();
    $('#overlay2').show();
    $('#modal2').center();
    $('#h2_id').val(id);
    $.get('cons_orden_compra/cocd_cons_orden_compra_detalles_datos.php?id=' + id, function(data) {
      var resp = data;
      r_array = resp.split('||');
      //alert(r_array[0]);
      $('#m_orco_id').val(r_array[1]);
      $('#m_orcd_cantidad').val(r_array[2]);
      $('#m_orcd_precio').val(r_array[3]);
      $('#m_orcd_detalle').val(r_array[4]);
      $('#m_orcd_itbms').val(r_array[5]);
    });
  }

  function mostrar() {
    $('#datos_mostrar').load('cons_orden_compra/cocd_cons_orden_compra_detalles_mostrar.php?nochk=jjjlae222' +
      "&f_orco_id=" + $('#f_orco_id').val() +
      "&f_orcd_detalle=" + $('#f_orcd_detalle').val() +
      "&f_orcd_itbms=" + $('#f_orcd_itbms').val() +
      "&f_orcd_recibido=" + $('#f_orcd_recibido').val()
    );
  }
</script>
<div id='separador'>
  <table width='' class=filtros>
    <tr>
    <tr>
      <?php echo catalogo('cons_orden_compra', 'Compra #', 'orco_numero', 'f_orco_id', 'orco_id', 'orco_numero', '0', '1', '150'); ?>
      <?php echo catalogo('sino', 'Pendientes', 'sino_id', 'f_orcd_recibido', 'sino_id', 'sino_nombre', '0', '1', '150'); ?>
      <!-- <?php echo entrada('input', 'Cantidad', 'f_orcd_cantidad', '150') ?> -->
      <!-- <?php echo entrada('input', 'Precio', 'f_orcd_precio', '150') ?></tr> -->
    <tr>
      <?php echo entrada('input', 'Descripción/Rubro', 'f_orcd_detalle', '150') ?>
      <?php echo entrada('input', 'ITBMS', 'f_orcd_itbms', '150') ?>
      <td class='tabla_datos'>
        <div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
      </td>
      <!-- <td><div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div></td> -->
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
        <?php echo catalogo('cons_orden_compra', 'Compra #', 'orco_numero', 'i_orco_id', 'orco_id', 'orco_numero', '0', '0', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Cantidad', 'i_orcd_cantidad', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Precio', 'i_orcd_precio', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Descripción/Rubro', 'i_orcd_detalle', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'ITBMS', 'i_orcd_itbms', '150'); ?>
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
      <tr>
        <?php echo catalogo('cons_orden_compra', 'Compra #', 'orco_numero', 'm_orco_id', 'orco_id', 'orco_numero', '0', '0', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Cantidad', 'm_orcd_cantidad', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Precio', 'm_orcd_precio', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Descripción/Rubro', 'm_orcd_detalle', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'ITBMS', 'm_orcd_itbms', '150'); ?>
      </tr>
      <tr>
        <td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
      </tr>
    </table>
  </div>
  <a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>