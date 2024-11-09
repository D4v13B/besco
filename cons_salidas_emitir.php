<?php 
session_start();
$user_check=$_SESSION['login_user'];
$id = $_POST["cosa_id"];
$detalles = $_POST["storedData"];

if($user_check!='')
	{
	include('conexion.php');
	include('funciones.php');

	//actualizo la salida como procesada
	$qsql = "UPDATE cons_salidas SET cose_id=3, cosa_fecha_instalado=now() WHERE cosa_numero ='$id'";
	mysql_query($qsql);

	$proy_id = obtener_valor("SELECT proy_id FROM cons_salidas WHERE cosa_numero ='$id'", "proy_id");

	//ahora debo actualizar el presupuesto
      foreach($detalles as $dt){
         $cosd_id = $dt["cosd_id"];
         $instalados = $dt["instalados"];
         $retornados = $dt["retornados"];
         $coru_id = $dt["coru_id"];

         $sql = "UPDATE cons_salidas_detalles SET 
         cosd_instalado = $instalados, 
         cosd_retornado = $retornados 
         WHERE cosd_id = $cosd_id";
         mysql_query($sql);

         //actualizo el presupuesto
         $sql = "UPDATE construccion_presupuesto SET 
         copr_instalados = copr_instalados + $instalados,
         copr_utilizados = copr_utilizados - $instalados,p
         copr_inventario = copr_inventario + $retornados
         WHERE proy_id = $prod_id AND coru_id = $coru_id";
         mysql_query($sql);
      }
	}
?>