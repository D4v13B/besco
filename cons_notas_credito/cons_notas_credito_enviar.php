<?php 
session_start();
$user_check=$_SESSION['login_user'];

include_once('../conexion.php'); 
include('../funciones.php'); 
include_once("../PHPMailer_v5.1/class.phpmailer.php"); 

$id = $_GET['id'];


//saco el template
$qsql = "SELECT cote_detalle FROM correos_templates WHERE cote_nombre='Notificacion Orden de Compra'";
$machote = obtener_valor($qsql, "cote_detalle");

//Debo reemplazar el nombre del cliente y el monto a pagar
$qsql ="SELECT copr_nombre, copr_correo, DATE_FORMAT(orco_fecha, '%m') mes
FROM cons_notas_credito a, cons_proveedores b 
WHERE a.crpr_id=b.copr_id
AND orco_id='$id'
";
$rs = mysql_query($qsql);
$num = mysql_num_rows($rs);
$i=0;
$mes_numero = mysql_result($rs, $i, 'mes');
$cliente = mysql_result($rs, $i, 'copr_nombre');
$clie_mail = mysql_result($rs, $i, 'copr_correo');
$clie_mail .= ';luis@e-integracion.com';
$mes = obtener_mes($mes_numero);

$machote = str_replace('[CLIENTE]',$cliente, $machote);
$machote = str_replace('[PROMOTOR]',$cliente, $machote);
$machote = str_replace('[MES]',$mes, $machote);

$adjunto = '../orden_compra/orden_compra_' . $id . '.pdf';
enviar_email('', 'PROMOTORA ORION', 'ORDEN DE COMPRA', $machote, $clie_mail, $adjunto);

//echo $adjunto;
//mysql_query("UPDATE ingresos SET ingr_notificada=1 WHERE ingr_id='$id'");
?>