<?php 
session_start();
$user_check=$_SESSION['login_user'];

if($user_check!='')
	{
	include('conexion.php');
	include('funciones.php');

	$id = $_GET['id'];
	//actualizo la salida como procesada
	$qsql = "UPDATE cons_salidas SET cose_id=2, cosa_fecha_entrega=now() WHERE cosa_id ='$id'";
	mysql_query($qsql);

	$proy_id = obtener_valor("SELECT proy_id FROM cons_salidas WHERE cosa_id ='$id'", "proy_id");
	$numero = obtener_valor("select cosa_numero from cons_salidas where cosa_id='$id'","cosa_numero");
	//ahora debo actualizar el presupuesto
	$qsql = "SELECT coru_id, cosd_cantidad FROM cons_salidas_detalles WHERE cosa_numero='$numero'";
	$rs = mysql_query($qsql);
	$num = mysql_num_rows($rs);
	$i=0;
	while($i<$num)
		{
			$prod_id=mysql_result($rs, $i, 'coru_id');
			$orcd_cantidad=mysql_result($rs, $i, 'cosd_cantidad');
			//saco cuanto se lleva salidas para el item que voy a actualizar 
			$qsql = "SELECT copr_utilizados FROM construccion_presupuesto WHERE proy_id='$proy_id' AND coru_id='$prod_id'";
			$utilizados = obtener_valor($qsql, "copr_utilizados");
			//a los ya comprados le sumo lo nuevo 
			$utilizados_total = $utilizados + $orcd_cantidad;
			//actualizo presupuesto
			$qsql = "update construccion_presupuesto set copr_inventario = copr_inventario - $orcd_cantidad,
			copr_utilizados = $utilizados_total
			where proy_id='$proy_id' 
			and coru_id='$prod_id'";
			
			//echo $qsql . "<br>";
			mysql_query($qsql);
			
			$i++;
		}
	}
?>