<?php 
include('conexion.php');
include('funciones.php');

$id=$_GET['id'];

$estado = obtener_valor("select cose_id from cons_solicitudes where coso_id='$id'","cose_id");
echo $estado;
?>