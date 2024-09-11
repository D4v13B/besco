<?php
function debug_error($qsql)
{
	$qsql = str_replace("'", "´", $qsql);
	$query = "insert into debug_errors (deer_fecha, deer_query) values (now(), '$qsql')";
	mysql_query($query);
}

function crear_cpp($cid, $doc, $activo, $fecha, $banco, $comentario, $vencimiento, $monto, $user_check)
{
	
	$qsql = "insert into clientes_cartas_promesas (clie_id, cldo_id, prpr_id, clcp_fecha, banc_id, clcp_comentario, clcp_fecha_vencimiento, clcp_monto, usua_id) values (
	'$cid',
	'$doc',
	'$activo',
	'$fecha',
	'$banco',
	'$comentario',
	'$vencimiento',
	'$monto',
	'$user_check')";
	//echo $qsql;
	mysql_query($qsql);
}

function crear_historial_cliente($cid, $historial, $user_check)
{
	$qsql = "insert into clientes_bitacora (clie_id, clbi_fecha, clbi_detalle, usua_id) values (
	'$cid',
	now(),
	'$historial',
	'$user_check')";
	mysql_query($qsql);
}

function crear_contrato($fecha, $activo)
{
	//actualiza la fecha de venta de la unidad inmobiliaria
	if($fecha!='')
	{
	$qsql = "update proyectos_propiedades set stat_id=2, prpr_fecha_vendido='$fecha' where prpr_id=$activo";
	mysql_query($qsql);	
	}
}

function separar_activo($m_fseparacion, $m_cliente, $usuario, $m_separacion, $m_promocion, $m_promocion_2, $m_precio, $m_firma, $m_abono, $id)
{
	$qsql = "update proyectos_propiedades set
	prpr_fecha_separacion='$m_fseparacion',
	prpr_precio='$m_precio',
	clie_id='$m_cliente',
	usua_id='$usuario',
	prpr_separacion='$m_separacion',
	prpr_promocion='$m_promocion',
	prpr_promocion_inf='$m_promocion_2',
	prpr_recamaras_final=prpr_recamaras,
	prpr_precio_lista_actual=prpr_precio_lista,
	stat_id='3'
	WHERE prpr_id='$id'";

	mysql_query($qsql);
	
	$inflado=0;
	if($m_promocion_2>0) $inflado=1;
	//debo crear el plan de pago limpio sin letras
	//adicionalmente debo calcular la CPP necesaria en este punto en base a separacion, firma y promociones
	$cpp = $m_precio - $m_separacion - $m_firma - $m_promocion - $m_promocion_2 - $m_abono;

	$qsql ="insert into proyectos_propiedades_letras (prpr_id, clie_id, prpl_precio, prpl_abono, prpl_letras, prpl_fecha, usua_id,
	prpl_separacion, prpl_abono_firma, prpl_promocion, prpl_promocion_inf, prpl_pdeposito, prpl_pestacionamiento, prpl_carta_promesa, prpl_inflado) values (
	'$id', 
	'$m_cliente', 
	'$m_precio', 
	'$m_abono', 
	'0', 
	'', 
	'$usuario',
	'$m_separacion',
	'$m_firma',
	'$m_promocion',
	'$m_promocion_2',
	'0',
	'0',
	'$cpp',
	'$inflado')";

	//echo $qsql;
	mysql_query($qsql);

	//si el sistema marca que le debo asignar un estacionamiento lo asigno
	$con_estacionamiento = obtener_valor("select proy_con_estacionamiento 
							from proyectos_propiedades a, proyectos b 
							where a.proy_id=b.proy_id and prpr_id=$id","proy_con_estacionamiento");
							
	if($con_estacionamiento==1)
		{
		//busco el estacionamiento de ese proyecto que tenga precio 0
		//saco el proyecto madre
		$prma_id = obtener_valor("select prma_id from proyectos a, proyectos_propiedades b where a.proy_id=b.proy_id and prpr_id=$id","prma_id");
		$qsql = "select esta_id from estacionamientos where esti_id=1 
			and proy_id in (select proy_id from proyectos where prma_id='$prma_id')
			and prpr_id is null";
		$rs=mysql_query($qsql);
		$num=mysql_num_rows($rs);
		$i=0;
		if($num>0)
			{
				//si hay alguno lo asocio
				$esta_id = mysql_result($rs,$i,'esta_id');
				
				$qsql ="update estacionamientos set 
				esst_id=2, 
				prpr_id=$id, 
				esta_en_contrato=1, 
				clie_id=$m_cliente,
				esta_en_hipoteca=1,
				usua_id=0,
				esta_precio=0,
				esta_por_derecho=1
				where esta_id=$esta_id";
				mysql_query($qsql);
			}
		}
}

function ajustar_precio($id, $precio, $prpl_id, $usuario, $motivo)
{
	$precio_anteror = obtener_valor("select prpr_precio from proyectos_propiedades where prpr_id=$id", "prpr_precio");
	
	$qsql = "update proyectos_propiedades set
	prpr_precio='$precio'
	WHERE prpr_id='$id'";
	mysql_query($qsql);	
	
	$qsql ="update proyectos_propiedades_letras 
	set prpl_precio='$precio',
	prpl_inflado=0
	where prpl_id=$prpl_id";
	mysql_query($qsql);
	
	$qsql ="insert into proyectos_propiedades_ajustes (prpr_id, usua_id, prpa_fecha, prpa_precio_anterior, prpa_motivo, prpl_id) values (
	'$id',
	'$usuario',
	now(),
	'$precio_anteror',
	'$motivo',
	'$prpl_id')";
	mysql_query($qsql);
}

function separar_activo_guardar($m_separacion, $m_promocion, $m_promocion_2, $m_firma, $m_pagare, $m_precio_pagare, $id, $prpl_id, $entrega='', $en_finiquito='', $f_desembolso='')
{
$qsql = "update proyectos_propiedades set
prpr_separacion='$m_separacion',
prpr_promocion='$m_promocion',
prpr_promocion_inf='$m_promocion_2',
prpr_fecha_entrega='$entrega'
WHERE prpr_id='$id'";

mysql_query($qsql);

	$inflado=0;
	if($m_promocion_2>0) $inflado=1;

$qsql_finiquito="";
if($en_finiquito!='') $qsql_finiquito = "prpl_en_finiquito='$en_finiquito',";
if($f_desembolso!='') $qsql_fdesembolso = "prpl_fecha_desembolso='$f_desembolso',";
	
$qsql ="update proyectos_propiedades_letras 
set prpl_separacion='$m_separacion', 
prpl_abono_firma='$m_firma', 
prpl_promocion='$m_promocion', 
prpl_promocion_inf='$m_promocion_2', 
prpl_pagare='$m_pagare',
prpl_precio_pagare='$m_precio_pagare',
$qsql_finiquito
$qsql_fdesembolso
prpl_inflado='$inflado'
where 
prpl_id=$prpl_id
";
//echo $qsql;
mysql_query($qsql);

$cpp = obtener_valor("select prpl_precio-prpl_abono-prpl_separacion-prpl_abono_firma-prpl_promocion-prpl_promocion_inf-prpl_pagare cpp 
					from proyectos_propiedades_letras where prpl_id=$prpl_id", "cpp");

$qsql ="update proyectos_propiedades_letras 
set prpl_carta_promesa='$cpp'
where 
prpl_id=$prpl_id
";
//echo $qsql;
mysql_query($qsql);					
}

function crear_pago($pid, $usuario, $fecha, $monto, $prerecibo, $recibo, $concepto, $forma, $banco, $cheque, $tipo)
{
$qsql = "insert into proyectos_abonos_pagos (prpl_id, usua_id, prap_fecha, prap_monto, prap_recibo, prap_fecha_captura, prap_concepto, ";
$qsql = $qsql . "prap_forma, prap_banco, prap_cheque, prap_tipo) values (";
$qsql = $qsql . "'$pid',";
$qsql = $qsql . "'$usuario',";
$qsql = $qsql . "'$fecha',";
$qsql = $qsql . "'$monto',";
$qsql = $qsql . "'$prerecibo" . "-" . "$recibo',";
$qsql = $qsql . "now(),";
$qsql = $qsql . "'$concepto',";
$qsql = $qsql . "'$forma',";
$qsql = $qsql . "'$banco',";
$qsql = $qsql . "'$cheque',";
$qsql = $qsql . "'$tipo')";
//echo $qsql;

mysql_query($qsql);
}

function crear_pago_alquiler($id, $usuario, $fecha, $monto, $prerecibo, $recibo, $concepto, $forma, $banco, $cheque)
{
$qsql = "insert into alquileres_pagos (alqu_id, usua_id, alpa_fecha, alpa_monto, alpa_recibo, alpa_fecha_captura, alpa_concepto, ";
$qsql = $qsql . "fopa_id, alpa_banco, alpa_cheque) values (";
$qsql = $qsql . "'$id',";
$qsql = $qsql . "'$usuario',";
$qsql = $qsql . "'$fecha',";
$qsql = $qsql . "'$monto',";
$qsql = $qsql . "'$recibo',";
$qsql = $qsql . "now(),";
$qsql = $qsql . "'$concepto',";
$qsql = $qsql . "'$forma',";
$qsql = $qsql . "'$banco',";
$qsql = $qsql . "'$cheque')";
//echo $qsql;

mysql_query($qsql);
}

function alquilar_activo($prpr_id, $clie_id, $usua_id, $canon, $contrato, $inicio, $fin, $opcion, $opcion_p, $d_recargo, $altr_id, $recargo_monto, $user_check)
{
	$qsql = "insert into alquileres (prpr_id, clie_id, usua_id, alqu_canon, alqu_fecha_contrato, alqu_fecha_inicio, alqu_fecha_fin, alqu_opcion_compra,
	alqu_porcentaje_opcion, alqu_dia_recargo, altr_id, alqu_recargo_monto, alqu_creador, alqu_creado_fecha, alqu_activo) values (
	'$prpr_id',
	'$clie_id',
	'$usua_id',
	'$canon',
	'$contrato',
	'$inicio',
	'$fin',
	'$opcion',
	'$opcion_p',
	'$d_recargo',
	'$altr_id',
	'$recargo_monto',
	'$user_check',
	now(),
	'1')
	";
	
	//debug_error($qsql);
	
	mysql_query($qsql);
	
	//debo marcar como alquilada la unidad
	
	$qsql = "update proyectos_propiedades set stat_id=8, clie_id=$clie_id where prpr_id='$prpr_id'";
	mysql_query($qsql);
	
	//saco el id del alquiler para generar las posibles letras
	$alqu_id = obtener_valor("select max(alqu_id) alqu from alquileres where prpr_id='$prpr_id' and clie_id='$clie_id'", "alqu");
	//tomo el inicio del pago y saco los días que faltan para que termine el mes en que se encuentra
	$dia_inicio = obtener_valor("SELECT DAY('$inicio') dia", "dia");
	$dia_fin = obtener_valor("SELECT DAY(LAST_DAY('$inicio')) dia", "dia");
	$fecha_completa_fin = substr($inicio, 0,6) . $dia_fin;
	//saco la diferencia y le agrego uno por si fuera 31 31
	$diferencia = $dia_fin-$dia_inicio;
	if($diferencia==0) $diferencia=1;
	
	//una vez tengo la diferencia crea la primera letra prorateada con fecha de inicio del contrato.
	$prorateo = ($canon/$dia_fin)*$diferencia;
	
	$qsql = "insert into alquileres_letras (alqu_id, alle_fecha, alle_monto) values (
	'$alqu_id', 
	'$inicio',
	'$prorateo')";
	mysql_query($qsql);
	
	//calculo los meses que hay desde que se inica a hoy
	$hoy_mes = date('Ym');
	$inicio_mes = substr($inicio, 0, 6);
	$meses_a_hoy = obtener_valor("SELECT PERIOD_DIFF($hoy_mes, $inicio_mes) meses", "meses");
	
	$i=0;
	while($i<$meses_a_hoy)
	{
		
		$fecha_letra = obtener_valor("select adddate('$fecha_completa_fin', 1) primero", "primero");
		
		$qsql = "insert into alquileres_letras (alqu_id, alle_fecha, alle_monto) values (
		'$alqu_id', 
		'$fecha_letra',
		'$canon')";
		mysql_query($qsql);
		
		//saco el ultimo dia otra vez
		$fecha_completa_fin = obtener_valor("select LAST_DAY('$fecha_letra') ultimo", "ultimo");
		$i++;
	}
}

function alquilar_activo_actualizar($alqu_id, $canon, $contrato, $inicio, $fin, $opcion, $opcion_p, $d_recargo, $altr_id, $recargo_monto, $user_check)
{
	//guardo los cambios
	$qsql = "insert into alquileres_bitacora (alqu_id, prpr_id, clie_id, usua_id, alqu_canon, alqu_fecha_contrato, alqu_fecha_inicio, alqu_fecha_fin, alqu_opcion_compra,
	alqu_porcentaje_opcion, alqu_dia_recargo, altr_id, alqu_recargo_monto, alqu_creador) (select alqu_id, prpr_id, clie_id, usua_id, alqu_canon, alqu_fecha_contrato, alqu_fecha_inicio, alqu_fecha_fin, alqu_opcion_compra,
	alqu_porcentaje_opcion, alqu_dia_recargo, altr_id, alqu_recargo_monto, '$user_check' from alquileres where alqu_id=$alqu_id)
	";
	mysql_query($qsql);
	
	$qsql = "update alquileres set
	alqu_canon='$canon', 
	alqu_fecha_contrato='$contrato', 
	alqu_fecha_inicio='$inicio', 
	alqu_fecha_fin='$fin', 
	alqu_opcion_compra='$opcion',
	alqu_porcentaje_opcion='$opcion_p', 
	alqu_dia_recargo='$d_recargo', 
	altr_id='$altr_id', 
	alqu_recargo_monto='$recargo_monto', 
	alqu_modificador='$user_check', 
	alqu_modificado_fecha=now()
	where alqu_id = $alqu_id
	";
	
	//debug_error($qsql);
	
	mysql_query($qsql);
	
	//debo marcar como alquilada la unidad
}

function asignar_estacionamiento($id, $m_cliente)
{
	$prma_id = obtener_valor("select prma_id from proyectos a, proyectos_propiedades b where a.proy_id=b.proy_id and prpr_id=$id","prma_id");
		$qsql = "select esta_id from estacionamientos where esti_id=1 
			and proy_id in (select proy_id from proyectos where prma_id='$prma_id')
			and prpr_id is null";
		$rs=mysql_query($qsql);
		$num=mysql_num_rows($rs);
		$i=0;
		if($num>0)
			{
				//si hay alguno lo asocio
				$esta_id = mysql_result($rs,$i,'esta_id');
				
				$qsql ="update estacionamientos set 
				esst_id=2, 
				prpr_id=$id, 
				esta_en_contrato=1, 
				clie_id=$m_cliente,
				esta_en_hipoteca=1,
				usua_id=0,
				esta_precio=0,
				esta_por_derecho=1
				where esta_id=$esta_id";
				mysql_query($qsql);
			}
}


function crear_proveedor_pago($pid, $usuario, $fecha, $monto, $prerecibo, $recibo, $concepto, $forma, $banco, $cheque, $tipo)
{
	$qsql = "insert into cons_facturas_pagos (fact_id, usua_id, prfp_fecha, prfp_monto, prfp_fecha_creacion, fopa_id) values (";
	$qsql = $qsql . "'$pid',";
	$qsql = $qsql . "'$usuario',";
	$qsql = $qsql . "'$fecha',";
	$qsql = $qsql . "'$monto',";
	$qsql = $qsql . "now(),";
	$qsql = $qsql . "'$forma')";

	//echo $qsql;

	mysql_query($qsql);

	//actualizo el saldo

	$qsql = "UPDATE cons_facturas a SET fact_saldo=fact_total-(SELECT COALESCE(SUM(prfp_monto),0) FROM cons_facturas_pagos WHERE fact_id=a.fact_id)
	 WHERE fact_id='$pid'";
	mysql_query($qsql);

	$qsql = "select fact_saldo, fact_total from cons_facturas where fact_id='$pid'";
	$rs = mysql_query($qsql);
	$i=0;
	$saldo = mysql_result($rs, $i, 'fact_saldo');
	$monto = mysql_result($rs, $i, 'fact_total');

	if($monto==$saldo)
	{
		$qsql = "UPDATE cons_facturas a SET faes_id=1 where fact_id='$pid'";
		mysql_query($qsql);
	}

	if($monto>$saldo)
	{
		$qsql = "UPDATE cons_facturas a SET faes_id=2 where fact_id='$pid'";
		mysql_query($qsql);
	}
	if($saldo<=0)
	{
		$qsql = "UPDATE cons_facturas a SET faes_id=3 where fact_id	='$pid'";
		mysql_query($qsql);
	}

}
?>