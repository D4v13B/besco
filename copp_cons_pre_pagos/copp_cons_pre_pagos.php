<script>
  function crear() {
    $('#result').load('copp_cons_pre_pagos_crear.php', {
        'i_prov_id': $('#i_prov_id').val(),
        'i_copp_monto': $('#i_copp_monto').val(),
        'i_copp_fecha': $('#i_copp_fecha').val()
      },
      function() {
        $('#modal').hide('slow');
        $('#overlay').hide();
        mostrar();
      }
    );
  }

  function modificar() {
    $('#result').load('copp_cons_pre_pagos_modificar.php?id=' + $('#h2_id').val(), {
        'm_copp_id': $('#m_copp_id').val(),
        'm_prov_id': $('#m_prov_id').val(),
        'm_copp_monto': $('#m_copp_monto').val(),
        'm_copp_fecha': $('#m_copp_fecha').val()
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
      $('#result').load('copp_cons_pre_pagos_borrar.php?id=' + id,
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
    $.get('copp_cons_pre_pagos_datos.php?id=' + id, function(data) {
      var resp = data;
      r_array = resp.split('||');
      //alert(r_array[0]);
      $('#m_prov_id').val(r_array[1]);
      $('#m_copp_monto').val(r_array[2]);
      $('#m_copp_fecha').val(r_array[3]);
    });
  }

  function mostrar() {
    $('#datos_mostrar').load('copp_cons_pre_pagos_mostrar.php?nochk=jjjlae222' +
      "&f_prov_id=" + $('#f_prov_id').val() +
      "&f_copp_monto=" + $('#f_copp_monto').val() +
      "&f_copp_fecha=" + $('#f_copp_fecha').val()
    );
  }
</script>
<div id='separador'>
  <table width='' class=filtros>
    <tr>
    <tr>
      <?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'f_prov_id', 'copr_id', 'copr_nombre', '0', '1', '150'); ?>
      <?php echo entrada('input', 'Monto', 'f_copp_monto', '150') ?>
      <?php echo entrada('fecha', 'Fecha', 'f_copp_fecha', '150') ?></tr>
    <tr>
      <td class='tabla_datos'>
        <div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
      </td>
      <td>
        <div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div>
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
        <?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'i_prov_id', 'copr_id', 'copr_nombre', '0', '0', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Monto', 'i_copp_monto', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('fecha', 'Fecha', 'i_copp_fecha', '150'); ?>
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
        <?php echo catalogo('cons_proveedores', 'Proveedor', 'copr_nombre', 'm_prov_id', 'copr_id', 'copr_nombre', '0', '0', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('input', 'Monto', 'm_copp_monto', '150'); ?>
      </tr>
      <tr>
        <?php echo entrada('fecha', 'Fecha', 'm_copp_fecha', '150'); ?>
      </tr>
      <tr>
        <td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
      </tr>
    </table>
  </div>
  <a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>