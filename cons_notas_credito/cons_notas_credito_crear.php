<?php
session_start();

include('../conexion.php');
include('../funciones.php');
$copr_id = $_POST['copr_id']; //ID Del proveedor
$proy_id = $_POST['proy_id'];
$h_codigo = $_POST['h_codigo'];
$i_ingr_fecha = $_POST['i_ingr_fecha'];
// $i_nocr_id=$_POST['i_nocr_id'];
$orco_id = $_POST["i_orco_id"];
$user_id = $_SESSION["login_user"];
$i_nocr_referencia = $_POST["i_nocr_referencia"];

$qsql = "";

$monto = obtener_valor("SELECT SUM(nocr_precio * nocr_cantidad) monto_total FROM cons_notas_credito_detalle WHERE nocr_temp_code = '$h_codigo'", "monto_total");

$qsql = "INSERT INTO cons_notas_credito 
(
   crpr_id,
   orco_id,
   usua_id,
   proy_id,
   nocr_fecha,
   nocr_fecha_registro,
   nocr_saldo,
   nocr_monto,
   nocr_temp_code,
   nocr_referencia
)
VALUES 
(
   '$copr_id', 
   '$orco_id',
   '$user_id',
   '$proy_id',
   '$i_ingr_fecha',
   NOW(),
   '$monto',
   '$monto',
   '$h_codigo',
   '$i_nocr_referencia'
)";
mysql_query($qsql);
//despues que la creo debo ponerle el código final a todos los detalles
//saco el código recien creado
$ingr_id = mysql_insert_id();
$qsql = "update cons_notas_credito_detalle set nocr_id=$ingr_id where nocr_temp_code=$h_codigo";
// echo nl2br($qsql);
mysql_query($qsql);


//Me retorna los pendientes a las ordenes de compra
$qsql = "UPDATE cons_orden_compra_detalles cd
    JOIN (
        SELECT
            c.orco_id AS orco_id,
            a.prod_id AS prod_id,
            a.nocr_cantidad AS nocr_cantidad,
            a.nocr_temp_code AS nocr_temp_code
        FROM cons_notas_credito_detalle a
                 INNER JOIN cons_notas_credito b ON b.nocr_id = a.nocr_id
                 INNER JOIN cons_facturas c ON b.orco_id = c.fact_numero
        WHERE a.nocr_temp_code = $h_codigo
    ) ncd
    ON cd.orco_id = ncd.orco_id AND cd.prod_id = ncd.prod_id
SET cd.orcd_recibido = cd.orcd_recibido - ncd.nocr_cantidad;d";
mysql_query($qsql);
