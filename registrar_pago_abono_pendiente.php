<?php

include "./conexion.php";
include "./funciones.php";

$prov_id = $_GET["prov_id"];

$saldo = obtener_valor("SELECT COALESCE(SUM(copp_saldo), 0) AS saldo FROM cons_pre_pagos WHERE prov_id = $prov_id", "saldo");
?>

<div class="form-row">
   <label>
      <span>SALDO SIN UTILIZAR</span>
      <input type='text' autocomplete='off' readonly value="<?php echo $saldo?>">
   </label>
</div>