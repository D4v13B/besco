<script>

function crear() {

$('#result').load('ctlg_construccion_rubros_crear.php'

,

{

    'i_cosu_id':  $('#i_cosu_id').val(),

    'i_coru_nombre':  $('#i_coru_nombre').val(),

	'i_coru_herramienta':  $('#i_coru_herramienta').val()

    }

    ,

    function(){

        $('#modal').hide('slow');

        $('#overlay').hide();

        mostrar();

    }

  );

}

function modificar() {

$('#result').load('ctlg_construccion_rubros_modificar.php?id=' + $('#h2_id').val()

,

{

     'm_coru_id':  $('#m_coru_id').val(),

     'm_cosu_id':  $('#m_cosu_id').val(),

     'm_coru_nombre':  $('#m_coru_nombre').val(),

	 'm_coru_herramienta':  $('#m_coru_herramienta').val()

    }

    ,

    function(){

       $('#modal2').hide('slow');

       $('#overlay2').hide();

       mostrar();

    }

  );

}

function borrar(id)

{

var agree=confirm('¿Está seguro?');

if(agree) {

   $('#result').load('ctlg_construccion_rubros_borrar.php?id=' + id

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

$.get('ctlg_construccion_rubros_datos.php?id=' + id, function(data){

     var resp=data;

     r_array = resp.split('||');

     //alert(r_array[0]);

     $('#m_cosu_id').val(r_array[1]);

     $('#m_coru_nombre').val(r_array[2]);

	 $('#m_coru_herramienta').val(r_array[3]);

     });

}

function mostrar() {

  $('#datos_mostrar').load('ctlg_construccion_rubros_mostrar.php?' +
      "f_coru_herramienta=" + $("#f_coru_herramienta").val() + "&f_coru_id=" + $("#f_coru_id").val()
  );
  
}

</script>

<div id='separador'>

<table class=filtros>

<tr>

<td class='tabla_datos'><div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div></td>

<?php echo catalogo('sino', 'Herramienta', 'sino_nombre', 'f_coru_herramienta', 'sino_id', 'sino_nombre',0,0,150)?>

<?php echo catalogo('construccion_rubros', 'Rubro', 'coru_nombre', 'f_coru_id', 'coru_id', 'coru_nombre',0,1,150)?>

<td><div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div></td>

</tr>

</table>

</div>

<div id='columna6'>

<div id='datos_mostrar'></div>

</div>

<!--MODAL-->

<div id='overlay'></div>

<div id='modal'><div id='content'>

<table>

<tr>

<?php echo catalogo('sino', 'Herramienta', 'sino_nombre', 'i_coru_herramienta', 'sino_id', 'sino_nombre',0,0,150)?>

<?php echo catalogo('construccion_rubros', 'Rubro', 'coru_nombre', 'i_coru_herramienta', 'coru_id', 'coru_nombre',0,0,150)?>

</tr>

<tr>

<?php echo catalogo('vw_cate_subcate', 'Sub-categoria', 'casu', 'i_cosu_id', 'cosu_id', 'casu', '0', '2', '150');?>

</tr>

<tr>

<td class='etiquetas'>Inventario:</td>

<td><input type='' id=i_coru_nombre size=40 class='entradas'></td>

</tr>

<tr>

<td colspan=2><a href='javascript:crear()' class='botones'>Crear</a></td>

</tr>

</table>

</div>

<a href='#' id='close'>close</a>

</div>



<div id='overlay2'></div>

<div id='modal2'><div id='content2'>

<input type=hidden id=h2_id>

<table>

<tr>

<?php echo catalogo('sino', 'Herramienta', 'sino_nombre', 'm_coru_herramienta', 'sino_id', 'sino_nombre',0,0,150)?>

</tr>

<tr>

<?php echo catalogo('vw_cate_subcate', 'Sub-categoria', 'casu', 'm_cosu_id', 'cosu_id', 'casu', '0', '2', '150');?>

</tr>

<tr>

<td class='etiquetas'>Inventario:</td>

<td><input type='text' id=m_coru_nombre size=40 class='entradas'></td>

</tr>

<tr>

<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>

</tr>

</table>

</div>

<a href='javascript:void(0);' id='close2'>close</a>

</div>



<div id=result></div>



