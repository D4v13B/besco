<script>
function crear() {
$('#result').load('cons_cons_niveles_crear.php'
,
{
    'i_proy_id':  $('#i_proy_id').val(),
    'i_nive_nivel':  $('#i_nive_nivel').val()
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
$('#result').load('cons_cons_niveles_modificar.php?id=' + $('#h2_id').val()
,
{
     'm_nive_id':  $('#m_nive_id').val(),
     'm_proy_id':  $('#m_proy_id').val(),
     'm_nive_nivel':  $('#m_nive_nivel').val()
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
   $('#result').load('cons_cons_niveles_borrar.php?id=' + id
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
$.get('cons_cons_niveles_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(r_array[0]);
     $('#m_proy_id').val(r_array[1]);
     $('#m_nive_nivel').val(r_array[2]);
     });
}
function mostrar() {
$('#datos_mostrar').load('cons_cons_niveles_mostrar.php?nochk=jjjlae222'
		+"&f_proy_id=" +  $('#f_proy_id').val()
		+"&f_nive_nivel=" +  $('#f_nive_nivel').val()
);}
</script>
<div id='separador'>
<table width='' class=filtros>
<tr><tr>
<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'f_proy_id', 'proy_id', 'proy_nombre', '0', '1', '150');?>
<?php echo entrada('input', 'Nivel','f_nive_nivel','150')?>
<td class='tabla_datos'><div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div></td>
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
<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'i_proy_id', 'proy_id', 'proy_nombre', '0', '0', '150');?>
</tr>
<tr>
<?php echo entrada('input', 'Nivel', 'i_nive_nivel', '150');?>
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
<input type=hidden id=h2_id><table>
<tr>
<?php echo catalogo('proyectos', 'Proyecto', 'proy_nombre', 'm_proy_id', 'proy_id', 'proy_nombre', '0', '0', '150');?>
</tr>
<tr>
<?php echo entrada('input', 'Nivel', 'm_nive_nivel', '150');?>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>

