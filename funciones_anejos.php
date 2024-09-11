<?php
function estacionamiento_desasociar($esta_id, $prpr_id)
{
	//clie_id no lo puedo traer de la desasociacion lo debo sacar del clie_id del deposito
	$clie_id=obtener_valor("select clie_id from estacionamientos where esta_id=$esta_id","clie_id");

	//primero tengo que marcar el estacionamiento como disponible
	$qsql ="update estacionamientos set esst_id=1, prpr_id=null, esta_en_contrato=0, clie_id=null, esta_por_derecho=0 where esta_id=$esta_id";
	mysql_query($qsql);

	//debo poner como inactivo la comision
	$qsql ="update estacionamientos_comisiones set esco_activo=0 where clie_id=$clie_id and esta_id=$esta_id";
	mysql_query($qsql);

	//sumo todos los incrementos para despues eliminarlos
	$monto = obtener_valor("select COALESCE(SUM(ppli_monto),0) monto from proyectos_propiedades_letras_incrementos where esta_id=$esta_id and ppli_en_contrato=1", "monto");
	$monto_pagare = obtener_valor("select COALESCE(SUM(ppli_monto),0) monto from proyectos_propiedades_letras_incrementos where esta_id=$esta_id and ppli_en_contrato=0", "monto");
		
	$precio_anterior = obtener_valor("select prpr_precio from proyectos_propiedades where prpr_id=$prpr_id", "prpr_precio");
	//ahora eliminto todos los incrementos
	$qsql = "delete from proyectos_propiedades_letras_incrementos where esta_id=$esta_id";
	mysql_query($qsql);
	
	//reduzco el precio si monto es mayor a 0
	if($monto>0)
	{
		//echo "monto es mayor a 0 $monto <br>";
		$precio_nuevo=$precio_anterior-$monto;
		//debo contabilizar cuantos estacionamientos tengo para ese activo y actualizarlo
		$mtotal = obtener_valor("select COALESCE(sum(esta_precio),0) monto from estacionamientos where prpr_id=$prpr_id", "monto");

		$qsql ="update proyectos_propiedades set prpr_precio=$precio_nuevo, prpr_pestacionamiento=$mtotal where prpr_id=$prpr_id";
		//echo $qsql;
		mysql_query($qsql);	
		
		$qsql ="update proyectos_propiedades_letras set prpl_precio=$precio_nuevo, prpl_pestacionamiento=$mtotal where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1";
		//echo $qsql;
		mysql_query($qsql);
	}
	//si monto_pagare>0 entonces debo recalcular el pagare
	if($monto_pagare>0)
	{
		$pagare_actual = obtener_valor("select prpl_pagare from proyectos_propiedades_letras 
					where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1", "prpl_pagare");
		$pagare_nuevo = $pagare_actual - $monto_pagare;
		$qsql ="update proyectos_propiedades_letras set prpl_pagare=$pagare_nuevo where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1";
		mysql_query($qsql);
	}
}

function desasociar_deposito($depo_id, $prpr_id)
{
	//clie_id no lo puedo traer de la desasociacion lo debo sacar del clie_id del deposito
	$clie_id=obtener_valor("select clie_id from depositos where depo_id=$depo_id","clie_id");

	$qsql ="update depositos set dest_id=1, prpr_id=null, depo_en_contrato=0, clie_id=null where depo_id=$depo_id";
	mysql_query($qsql);

	//debo poner como inactivo la comision
	$qsql ="update depositos_comisiones set deco_activo=0 where clie_id=$clie_id and depo_id=$depo_id";
	mysql_query($qsql);

	//sumo todos los incrementos para despues eliminarlos
	$monto = obtener_valor("select COALESCE(SUM(ppli_monto),0) monto from proyectos_propiedades_letras_incrementos where depo_id=$depo_id and ppli_en_contrato=1", "monto");
	$monto_pagare = obtener_valor("select COALESCE(SUM(ppli_monto),0) monto from proyectos_propiedades_letras_incrementos where depo_id=$depo_id and ppli_en_contrato=0", "monto");
	
	$precio_anterior = obtener_valor("select prpr_precio from proyectos_propiedades where prpr_id=$prpr_id", "prpr_precio");
	//ahora eliminto todos los incrementos
	$qsql = "delete from proyectos_propiedades_letras_incrementos where depo_id=$depo_id";
	mysql_query($qsql);
	//reduzco el precio

	if($monto>0)
	{
	$precio_nuevo=$precio_anterior-$monto;
	//debo contabilizar cuantos depositos tengo para ese activo y actualizarlo
	$mtotal = obtener_valor("select COALESCE(sum(depo_precio),0) monto from depositos where prpr_id=$prpr_id", "monto");

	$qsql ="update proyectos_propiedades set prpr_precio=$precio_nuevo, prpr_pdeposito=$mtotal where prpr_id=$prpr_id";
	//echo $qsql;
	mysql_query($qsql);

	$qsql ="update proyectos_propiedades_letras set prpl_precio=$precio_nuevo, prpl_pdeposito=$mtotal where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1";
	//echo $qsql;
	mysql_query($qsql);
	}
	//si monto_pagare>0 entonces debo recalcular el pagare
	if($monto_pagare>0)
	{
		$pagare_actual = obtener_valor("select prpl_pagare from proyectos_propiedades_letras 
					where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1", "prpl_pagare");
		$pagare_nuevo = $pagare_actual - $monto_pagare;
		$qsql ="update proyectos_propiedades_letras set prpl_pagare=$pagare_nuevo where prpr_id=$prpr_id and clie_id=$clie_id and prpl_retirado=0 and prpl_activa=1";
		mysql_query($qsql);
	}	
}
?>