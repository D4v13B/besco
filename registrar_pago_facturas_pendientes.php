<?php

require "conexion.php";

$copr_id = $_GET["id"];

$stmt = "SELECT * FROM cons_facturas
WHERE copr_id = $copr_id
HAVING fact_saldo > 0";

$res = mysql_query($stmt);
?>

<table class="nicetable_th w-100">
   <thead class="thead-dark">
      <th class="tabla_datos_titulo">Fecha</th>
      <th class="tabla_datos_titulo">Numero</th>
      <th class="tabla_datos_titulo">Total</th>
      <th class="tabla_datos_titulo">Saldo</th>
      <th class="tabla_datos_titulo">Monto pendiente</th>
      <th class="tabla_datos_titulo"></th>
   </thead>
   <?php
   while ($fila = mysql_fetch_assoc($res)) {
   ?>
      <tr class="tabla_datos_tr">
         <td class="tabla_datos"><?php echo $fila["fact_fecha"] ?></td>
         <td class="tabla_datos fact_numero"><?php echo $fila["fact_numero"] ?></td>
         <td class="tabla_datos"><?php echo $fila["fact_total"] ?></td>
         <td class="tabla_datos saldo"><?php echo $fila["fact_saldo"] ?></td>
         <td>
            <input type="number" value="0" data-factura="<?php echo $fila["fact_id"] ?>" class="monto_factura" readonly data-tope="<?php echo $fila["fact_saldo"] ?>" data-factnumero="<?php echo $fila["fact_numero"] ?>">
         </td>
         <td>
            <input type="checkbox" value="0" data-factura="<?php echo $fila["fact_id"] ?>" class="chk_factura">
         </td>
      </tr>
   <?php
   }
   ?>
</table>

<script>
   $(document).ready(function(){
      clearLocalStorage()
   })

   $(".chk_factura").on("change", function() {
      let tr = $(this).parent().parent();

      if ($(this).is(":checked")) {
         let inputMonto = tr.find(".monto_factura"),
         montoSaldo = (tr.find(".saldo").text())
         
         inputMonto.removeAttr("readonly")
         inputMonto.val(montoSaldo)
         inputMonto.trigger("input")
      } else { //Si lo deselecciono
         tr.find(".monto_factura").attr("readonly", "readonly")
         
         // Eliminar del arreglo
         let pagosFacturas = getLocalStorage();
         
         // Asegúrate de que `pagosFacturas` no sea null
         if (pagosFacturas) {
            pagosFacturas = pagosFacturas.filter(item => item.factId != $(this).data("factura"));
            setItemLocalStorage(pagosFacturas);
         }
         tr.find(".monto_factura").val(0)
         const montoTotal = calcularMontoTotal()
      $("#i_monto").val(montoTotal)
      }
   });

   $(".monto_factura").on("input", function() {
      let facturasPagos = getLocalStorage() || []; // Inicializa como array vacío si no existe

      let monto = $(this).val();
      let factId = $(this).data("factura"); // ID de la factura
      let factNumero = $(this).data("factnumero")

      // Verificar si ya existe un pago para esa factura, y actualizarlo
      let index = facturasPagos.findIndex(item => item.factId == factId);

      if (index !== -1) {
         // Actualiza el monto si la factura ya existe
         facturasPagos[index].monto = monto;
      } else {
         // Si no existe, agregar un nuevo pago
         let tmpPago = {
            monto,
            factId,
            factNumero
         };
         facturasPagos.push(tmpPago);
      }

      // Guardamos en LocalStorage
      setItemLocalStorage(facturasPagos);

      //Calcular monto
      const montoTotal = calcularMontoTotal()
      $("#i_monto").val(montoTotal)
   });

   function getLocalStorage() {
      return JSON.parse(localStorage.getItem("facturasPagos")) || []; // Si es null, retorna un array vacío
   }

   function setItemLocalStorage(data) {
      localStorage.setItem("facturasPagos", JSON.stringify(data));
   }

   function calcularMontoTotal() {
      let facturasPagos = getLocalStorage()

      let totalMonto = facturasPagos.reduce((total, item) => {
         return total + parseFloat(item.monto); // Sumar los montos, asegurándote de que sean numéricos
      }, 0); // 0 es el valor inicial de la suma

      if (totalMonto) {
         return totalMonto
      }

      return 0
   }

   function emitirPagos() {
      let pagos_facturas = getLocalStorage();

      // Obtener el valor de #i_monto
      let metodoPago = $("#i_tipa_id").val();
      let copr_id = $("#i_copr_id").val()
      let i_prfp_numero = $("#i_prfp_numero").val()
      let i_fecha = $("#i_fecha").val()
      let i_prfp_referencia_ach = $("#i_prfp_referencia_ach").val()


      let data = {
         metodoPago, // Asignar el valor de metodo_pago
         pagos_facturas, // Enviar el array de pagos_facturas
         copr_id,
         i_prfp_numero,
         i_fecha,
         i_prfp_referencia_ach
      };

      $.ajax({
         url: "emitir_pagos.php",
         method: "POST", // Establece el tipo de contenido como JSON
         data: data, // Convierte el objeto data en una cadena JSON
         success: function(response) {
            buscar_facturas()
            clearLocalStorage()

            let montoTotal = calcularMontoTotal()
            $("#i_monto").val(montoTotal)
            $("#frm_registro").trigger("reset")
         },
         error: function(xhr, status, error) {
            console.error("Error en la petición:", error);
         }
      });
   }

   function clearLocalStorage(){
      localStorage.removeItem("facturasPagos")

   }
</script>