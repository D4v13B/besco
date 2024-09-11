<?php 
session_start();

include('../conexion.php');
include('../funciones.php');
$copr_id=$_POST['copr_id']; //ID Del proveedor
$proy_id=$_POST['proy_id'];
$h_codigo=$_POST['h_codigo'];
$i_ingr_fecha=$_POST['i_ingr_fecha'];
// $i_nocr_id=$_POST['i_nocr_id'];
$orco_id=$_POST["i_orco_id"];
$user_id = $_SESSION["login_user"];

$qsql = "INSERT INTO cons_notas_credito 
(
   crpr_id,
   orco_id,
   usua_id,
   proy_id,
   nocr_fecha,
   nocr_fecha_registro
)
VALUES (
   '$copr_id', 
   '$orco_id',
   '$user_id',
   '$proy_id',
   '$i_ingr_fecha',
   NOW()
)";
mysql_query($qsql);
//despues que la creo debo ponerle el código final a todos los detalles
//saco el código recien creado
$ingr_id = mysql_insert_id();
$qsql ="update cons_notas_credito_detalle set nocr_id=$ingr_id where nocr_temp_code=$h_codigo";
// echo nl2br($qsql);
mysql_query($qsql);
?>
