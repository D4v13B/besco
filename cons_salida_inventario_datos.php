<?php

include('conexion.php');
include('funciones.php');
$numero = $_GET["id"];

$sql = "SELECT a.coru_id, cosd_cantidad, coru_nombre, cosd_id, b.coru_id FROM cons_salidas_detalles a, construccion_rubros b WHERE cosa_numero='$numero' AND a.coru_id = b.coru_id";

$rs = mysql_query($sql);

// echo $sql;

?>
<table id='resultado' class="nicetable_th table align-middle" style="width:98%">
   <thead class="thead-dark">
      <th class="tabla_datos_titulo">Rubro</th>
      <th class="tabla_datos_titulo">Cantidad disponible</th>
      <th class="tabla_datos_titulo">Instalados</th>
      <th class="tabla_datos_titulo">Retornados</th>
   </thead>
   <tbody>
      <?php
      while ($fila = mysql_fetch_assoc($rs)) {
      ?>
         <tr class="tabla_datos_tr">
            <td class="tabla_datos"><?php echo $fila["coru_nombre"] ?></td>
            <td class="tabla_datos"><?php echo $fila["cosd_cantidad"] ?></td>
            <td class="tabla_datos">
               <input type="number" placeholder="Usados" data-coruid="<?php echo $fila["coru_id"] ?>" data-cantidad="<?php echo $fila["cosd_cantidad"] ?>" class="cantidad" data-id="<?php echo $fila["cosd_id"] ?>" value="<?php echo $fila["cosd_cantidad"] ?>" min=0>
            </td>
            <td class="tabla_datos">
               <input type="number" placeholder="Retornados" class="retornado" readonly value="0">
            </td>
         </tr>


      <?php } ?>
      <tr>
         <td colpan="4">
            <span class="botones" id="btnGuardarReporte">GUARDAR REPORTE DE USO</span>
         </td>
      </tr>
   </tbody>
</table>

<script>
   $(document).ready(function() {
      limpiarLS()

      $(".cantidad").trigger("input")
   })

   $("#btnGuardarReporte").on("click", function() {
      let storedData = getLocalStorage()

      $.ajax({
         url: "cons_salidas_emitir.php",
         method: "POST",
         data: {
            cosa_id: $("#h3_id").val(),
            storedData
         }, // Asegúrate que storedData es un objeto o una cadena
         success: function(res) {
            console.log(res);
         },
         error: function(xhr, status, error) {
            console.error("Error:", status, error);
         }
      })
   })


   function guardarValores(inputElement) {
      let tr = $(inputElement).parent().parent();
      let cantidad = parseFloat($(inputElement).data("cantidad"));
      let valor = parseFloat($(inputElement).val());
      let cosd_id = $(inputElement).data("id");
      let inpRetornados = tr.find(".retornado");
      let salidasDetalles = getLocalStorage();
      let coru_id = $(inputElement).data("coruid");

      console.log(coru_id);

      if (valor <= -1 || isNaN(valor)) {
         $(inputElement).val(0);
         valor = 0;
      }

      if ($(inputElement).val().startsWith('0') && $(inputElement).val().length > 1) {
         $(inputElement).val($(inputElement).val().replace(/^0+/, ''));
      }

      if (valor > cantidad) {
         valor = cantidad;
         $(inputElement).val(valor);
      }

      let tmpData = {
         cosd_id,
         instalados: valor,
         retornados: cantidad - valor,
         coru_id
      };

      salidasDetalles = salidasDetalles.filter(item => item.cosd_id !== tmpData.cosd_id);
      salidasDetalles.push(tmpData);
      setLocalStorage(salidasDetalles);
      inpRetornados.val(cantidad - valor);
   }

   // Ejecuta la función para cada input al cargar la página
   $(".cantidad").each(function() {
      guardarValores(this);
   });

   // Vincula la función al evento de input
   $(".cantidad").on("input", function() {
      guardarValores(this);
   });

   function getLocalStorage() {
      return JSON.parse(localStorage.getItem("retornados")) ?? []
   }

   function setLocalStorage(data) {
      return localStorage.setItem("retornados", JSON.stringify(data))
   }

   function limpiarLS() {
      localStorage.removeItem("retornados")
   }
</script>