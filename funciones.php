<?php

function bitacora_propiedades($usuario, $aid) 

{

$qsql ="insert into proyectos_propiedades_bitacora (prpb_fecha, modificado_por, prpr_id, prpr_fecha_vendido, ";

$qsql = $qsql . "proy_id, prpr_piso, prpr_letra, prpr_area, prpr_recamaras, prpr_balcon, prpr_den, prpr_banios,";

$qsql = $qsql . "prpr_banio_empleada, prpr_precio, prpr_cuarto_empleada, stat_id, prpr_deposito, prpr_estacionamiento,";

$qsql = $qsql . "clie_id, usua_id, prpr_fecha_separacion, prpr_edificio, prpr_precio_letras, prpr_inicio, prpr_entrega) ";

$qsql = $qsql . "(select now(), $usuario, prpr_id, prpr_fecha_vendido, ";

$qsql = $qsql . "proy_id, prpr_piso, prpr_letra, prpr_area, prpr_recamaras, prpr_balcon, prpr_den, prpr_banios,";

$qsql = $qsql . "prpr_banio_empleada, prpr_precio, prpr_cuarto_empleada, stat_id, prpr_deposito, prpr_estacionamiento,";

$qsql = $qsql . "clie_id, usua_id, prpr_fecha_separacion, prpr_edificio, prpr_precio_letras, prpr_inicio, prpr_entrega";

$qsql = $qsql . " from proyectos_propiedades where prpr_id=$aid )";



mysql_query($qsql);

}



function guardar_email($cliente, $para, $de, $mensaje)

{

$qsql ="insert into clientes_correos (clie_id, clco_fecha, clco_para, clco_de, clco_mensaje) values (";

$qsql = $qsql . "'$cliente',";

$qsql = $qsql . "now(),";

$qsql = $qsql . "'$para',";

$qsql = $qsql . "'$de',";

$qsql = $qsql . "'$mensaje')";



//echo $qsql;



mysql_query($qsql);



}



function obtener_fecha_letras($fecha)

{

$anio = substr($fecha,0,4);

$mes = obtener_mes(substr($fecha, 4,2));

$dia = substr($fecha, 6,2);



$armada = $dia . " de " . $mes . " de " .$anio;



return $armada;

}



function obtener_ubicacion($p)

{

//echo obtener_valor("select ubicacion from ubicaciones where url='$p'", "ubicacion");

$result = mysql_query("select ubicacion from ubicaciones where url='$p'");

$num = mysql_num_rows($result);

if($num>0)

	{

	echo mysql_result($result,$i, 'ubicacion') . "&nbsp;&nbsp;&nbsp;";

	}

}





function obtener_rol($id)

{

$qsql ="select usti_id from usuarios a where usua_id=$id";

$result = mysql_query($qsql);

$i=0;

if($id!='')

	{

	return mysql_result($result,$i, 'usti_id');

	}

	else

	{

	return '';

	}



}



function obtener_valor($qsql, $campo)

{

//echo $qsql;

$result = mysql_query($qsql);

$rnum = mysql_num_rows($result);

$i=0;

if($rnum>0)

	{

		return mysql_result($result,$i, $campo);

	}

	else

	{

		return 'x';

	}

}



function bitacora($id, $desde, $hasta)

{

$qsql ="select date_format(clbi_fecha, '%d/%m/%Y') fecha, clbi_detalle from clientes_bitacora where clie_id=$id";

$qsql = $qsql . " and date_format(clbi_fecha, '%Y%m%d')>='$desde'";

$qsql = $qsql . " and date_format(clbi_fecha, '%Y%m%d')<='$hasta'";

$qsql = $qsql . " order by clbi_fecha desc";

$result = mysql_query($qsql);

$num_proy = mysql_num_rows($result);

$i=0;

$bita="";

while ($i<$num_proy)

	{

	$bita = $bita . mysql_result($result, $i, 'fecha') . ' - ' . mysql_result($result, $i, 'clbi_detalle') . '<br>';

	$i++;

	}

if($bita=='')

{$bita='No hay bit&aacute;cora para este cliente';}

return $bita;

}



function armar_fecha($fecha)

{

$anio = substr($fecha,0,4);

$mes = substr($fecha, 4,2);

$dia = substr($fecha, 6,2);



$armada = $anio . "-" . $mes . "-" .$dia;



return $armada;



}



function armar_fecha_palabras($fecha)

{

$anio = substr($fecha,0,4);

$mes = substr($fecha, 4,2);

$dia = substr($fecha, 6,2);



if($mes=='01') {$mesl = 'Enero';} 

if($mes=='02') {$mesl = 'Febrero';} 

if($mes=='03') {$mesl = 'Marzo';} 

if($mes=='04') {$mesl = 'Abril';} 

if($mes=='05') {$mesl = 'Mayo';} 

if($mes=='06') {$mesl = 'Junio';} 

if($mes=='07') {$mesl = 'Julio';} 

if($mes=='08') {$mesl = 'Agosto';} 

if($mes=='09') {$mesl = 'Septiembre';} 

if($mes=='10') {$mesl = 'Octubre';} 

if($mes=='11') {$mesl = 'Noviembre';} 

if($mes=='12') {$mesl = 'Diciembre';} 



$armada = $dia . " de " . $mesl . " de " .$anio;



return $armada;



}



function armar_fecha_palabras_anio_mes($fecha)

{

$anio = substr($fecha,0,4);

$mes = substr($fecha, 4,2);



if($mes=='01') {$mesl = 'Enero';} 

if($mes=='02') {$mesl = 'Febrero';} 

if($mes=='03') {$mesl = 'Marzo';} 

if($mes=='04') {$mesl = 'Abril';} 

if($mes=='05') {$mesl = 'Mayo';} 

if($mes=='06') {$mesl = 'Junio';} 

if($mes=='07') {$mesl = 'Julio';} 

if($mes=='08') {$mesl = 'Agosto';} 

if($mes=='09') {$mesl = 'Septiembre';} 

if($mes=='10') {$mesl = 'Octubre';} 

if($mes=='11') {$mesl = 'Noviembre';} 

if($mes=='12') {$mesl = 'Diciembre';} 



$armada = $mesl . "<br>" .$anio;



return $armada;



}



function armar_fecha_palabras_contrato($fecha)

{

$anio = substr($fecha,0,4);

$mes = substr($fecha, 4,2);

$dia = substr($fecha, 6,2);



if($mes=='01') {$mesl = 'Enero';} 

if($mes=='02') {$mesl = 'Febrero';} 

if($mes=='03') {$mesl = 'Marzo';} 

if($mes=='04') {$mesl = 'Abril';} 

if($mes=='05') {$mesl = 'Mayo';} 

if($mes=='06') {$mesl = 'Junio';} 

if($mes=='07') {$mesl = 'Julio';} 

if($mes=='08') {$mesl = 'Agosto';} 

if($mes=='09') {$mesl = 'Septiembre';} 

if($mes=='10') {$mesl = 'Octubre';} 

if($mes=='11') {$mesl = 'Noviembre';} 

if($mes=='12') {$mesl = 'Diciembre';} 



$armada = $dia . " d&iacute;as del mes de " . $mesl . " de " .$anio;



return $armada;



}



function cliente_propiedad($id)

{

$qsql = "select proy_nombre, concat(prpr_piso, prpr_letra) activo from proyectos a, proyectos_propiedades b";

$qsql = $qsql . " where a.proy_id=b.proy_id and b.clie_id=$id";



$rs = mysql_query($qsql);

$num_rs = mysql_num_rows($rs);

$i=0;

$activo="";

while ($i<$num_rs)

	{

	$activo = "<b>" . mysql_result($rs, $i, 'proy_nombre') . "</b>" . ": " . mysql_result($rs, $i, 'activo');

	$i++;

	}



return $activo;

}



function cliente_propiedad_id($id)

{

$qsql = "select prpr_id from proyectos_propiedades b";

$qsql = $qsql . " where b.clie_id=$id";



$rs = mysql_query($qsql);

$num_rs = mysql_num_rows($rs);

$i=0;

$activo="";

while ($i<$num_rs)

	{

	$activo = mysql_result($rs, $i, 'prpr_id');

	$i++;

	}



return $activo;

}



function estatus_activo($id)

{

$qsql ="select stat_id from proyectos_propiedades where prpr_id=$id";

$rs = mysql_query($qsql);

$num = mysql_num_rows($rs);

$i=0;



$estado = mysql_result($rs, $i, 'stat_id');



return $estado;

}



function obtener_mes($mes)

{

if($mes=='01') {return 'Ene';}

if($mes=='02') {return 'Feb';}

if($mes=='03') {return 'Mar';}

if($mes=='04') {return 'Abr';}

if($mes=='05') {return 'May';}

if($mes=='06') {return 'Jun';}

if($mes=='07') {return 'Jul';}

if($mes=='08') {return 'Ago';}

if($mes=='09') {return 'Sep';}

if($mes=='10') {return 'Oct';}

if($mes=='11') {return 'Nov';}

if($mes=='12') {return 'Dic';}

}



function obtener_mes_simple($mes)

{

if($mes=='1') {return 'Ene';}

if($mes=='2') {return 'Feb';}

if($mes=='3') {return 'Mar';}

if($mes=='4') {return 'Abr';}

if($mes=='5') {return 'May';}

if($mes=='6') {return 'Jun';}

if($mes=='7') {return 'Jul';}

if($mes=='8') {return 'Ago';}

if($mes=='9') {return 'Sep';}

if($mes=='10') {return 'Oct';}

if($mes=='11') {return 'Nov';}

if($mes=='12') {return 'Dic';}

}



function enviar_correo($to, $subject, $body)

{

$empresa = obtener_parametro(13);

//error_reporting(E_ALL);

error_reporting(E_STRICT);



date_default_timezone_set('America/Toronto');



require_once('mailer/class.phpmailer.php');



$mail                = new PHPMailer();



$mail->IsSMTP(); // telling the class to use SMTP

$mail->Host          = "smtp.gmail.com";

//$mail->SMTPDebug     = 2;

$mail->SMTPAuth      = true;                  // enable SMTP authentication

$mail->SMTPSecure    = "ssl";    

//$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent

$mail->Host          = "smtp.gmail.com"; // sets the SMTP server

$mail->Port          = 465;                    // set the SMTP port for the GMAIL server

$mail->Username      = "contabilidad.besco@gmail.com"; // SMTP account username

$mail->Password      = "Besco_2016";        // SMTP account password

$mail->SetFrom('contabilidad.besco@gmail.com', $empresa);

$mail->AddReplyTo('contabilidad.besco@gmail.com', $empresa);





$mail->Subject       = $subject;



$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress($to);

$mail->Send();

  // Clear all addresses and attachments for next loop

$mail->ClearAddresses();

$mail->ClearAttachments();

}



function encodeURI($url) {

    // https://php.net/manual/en/function.rawurlencode.php

    // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI

    $unescaped = array(

        '%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',

        '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'

    );

    $reserved = array(

        '%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',

        '%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'

    );

    $score = array(

        '%23'=>'#'

    );

    return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));



}



function quitar_las_tildes($cadena) {

$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");

$permitidas   = array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U" ,"a" ,"e" ,"i" ,"o" ,"u" ,"c","C","a" ,"e","i" ,"o" ,"u" ,"A" ,"E" ,"I" ,"O" ,"U" ,"u","o" ,"O" ,"i" ,"a" ,"e","U","I","A" ,"E");

$texto = str_replace($no_permitidas, $permitidas ,$cadena);

$texto = limpiar_caracteres_especiales($texto);

return $texto;

}



function limpiar_caracteres_especiales($s) {

	$s = preg_replace("/[áàâãª]/","a",$s);

	$s = preg_replace("/[ÁÀÂÃ]/","A",$s);

	$s = preg_replace("/[ÍÌÎ]/","I",$s);

	$s = preg_replace("/[íìî]/","i",$s);

	$s = preg_replace("/[éèê]/","e",$s);

	$s = preg_replace("/[ÉÈÊ]/","E",$s);

	$s = preg_replace("/[óòôõº]/","o",$s);

	$s = preg_replace("/[ÓÒÔÕ]/","O",$s);

	$s = preg_replace("/[úùû]/","u",$s);

	$s = preg_replace("/[ÚÙÛ]/","U",$s);

	$s = str_replace("ç","c",$s);

	$s = str_replace("Ç","C",$s);

	$s = str_replace("ñ","n",$s);

	$s = str_replace("Ñ","N",$s);

	$s = str_replace(" ","-",$s);

	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:

	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);

	return $s;

}



function sin_caracteres_especiales($string)

{

	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-\.]/', '', $string); // Removes special chars.

}



function obtener_email_datos_usuario($tipo, $user_check)

{

//me conecto a la base de datos remota

$username="dunderio_admin";

$password="Deidad_2229";

$database="dunderio_imap_pedros";

$mysqli = new mysqli("192.185.52.247", $username, $password, $database);



//saco el id de imcu para buscar el valor que necesito

$id = obtener_valor("select imcu_id from usuarios where usua_id=$user_check","imcu_id");



$query = "SELECT imcu_$tipo FROM imap_cuentas WHERE imcu_id=$id";

$rs = $mysqli->query($query);



$num = $rs->num_rows;



if($num>0)

	{

	$retorno = mysqli_result($rs, 0, "imcu_$tipo"); 

	}

	else

	{

	$retorno = "error";

	}



mysqli_close($mysqli);

return $retorno;

}



function mysqli_result($rs, $row, $field)

{

$rs->data_seek($row);

$data = $rs->fetch_array();

return $data[$field];

}



function cleanText($str){



$str = str_replace("Ñ" ,"&#209;", $str);

$str = str_replace("ñ" ,"&#241;", $str);

$str = str_replace("ñ" ,"&#241;", $str);

$str = str_replace("Á","&#193;", $str);

$str = str_replace("á","&#225;", $str);

$str = str_replace("É","&#201;", $str);

$str = str_replace("é","&#233;", $str);

$str = str_replace("ú","&#250;", $str);

$str = str_replace("ù","&#249;", $str);

$str = str_replace("Í","&#205;", $str);

$str = str_replace("í","&#237;", $str);

$str = str_replace("Ó","&#211;", $str);

$str = str_replace("ó","&#243;", $str);

$str = str_replace("“","&#8220;", $str);

$str = str_replace("”","&#8221;", $str);



$str = str_replace("‘","&#8216;", $str);

$str = str_replace("’","&#8217;", $str);

$str = str_replace("—","&#8212;", $str);



$str = str_replace("–","&#8211;", $str);

$str = str_replace("™","&trade;", $str);

$str = str_replace("ü","&#252;", $str);

$str = str_replace("Ü","&#220;", $str);

$str = str_replace("Ê","&#202;", $str);

$str = str_replace("ê","&#238;", $str);

$str = str_replace("Ç","&#199;", $str);

$str = str_replace("ç","&#231;", $str);

$str = str_replace("È","&#200;", $str);

$str = str_replace("è","&#232;", $str);

$str = str_replace("•","&#149;" , $str);



$str = str_replace("¼","&#188;" , $str);

$str = str_replace("½","&#189;" , $str);

$str = str_replace("¾","&#190;" , $str);

$str = str_replace("½","&#189;" , $str);



return $str;



}



function latino_html($cadena)

{

$cadena = str_replace("á","&aacute;",$cadena);

$cadena = str_replace("é","&eacute;",$cadena);

$cadena = str_replace("í","&iacute;",$cadena);

$cadena = str_replace("ó","&oacute;",$cadena);

$cadena = str_replace("ú","&uacute;",$cadena);

$cadena = str_replace("ñ","&ntilde;",$cadena);



$cadena = str_replace("Á","&Aacute;",$cadena);

$cadena = str_replace("É","&Eacute;",$cadena);

$cadena = str_replace("Í","&Iacute;",$cadena);

$cadena = str_replace("Ó","&Oacute;",$cadena);

$cadena = str_replace("Ú","&Uacute;",$cadena);

$cadena = str_replace("Ñ","&Ntilde;",$cadena);



return $cadena;



}



function obtener_email_datos($tipo)

{

$retorno = obtener_valor("select para_valor from parametros where para_nombre='email_$tipo'","para_valor");



return $retorno;

}



function obtener_parametro($id)

{

return obtener_valor("select para_valor from parametros where para_id=$id", "para_valor");

}



function obtener_parametro_x_nombre($id)

{

return obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='$id'", "para_valor");

}



function es_super($usuario)

{

	$qsql = "select usua_super from usuarios where usua_id=$usuario";

	$retorno = obtener_valor($qsql, 'usua_super');

	

	return $retorno;

	

}



function catalogo($tabla, $etiqueta, $order, $id, $tid, $tnombre,$todo,$multiple, $ancho, 

					$where='', $onclick='', $concatenado='', $nconcatenado='', 

					$sololectura='', $selected='', $desabilitado='', $div='')

{

	$eti_label="td";

	$eti_input="td";

	

	//primero leo la tabla

	$qsql ="select $tid, $tnombre $concatenado from $tabla $where order by $order";

	//echo $qsql;

	if($concatenado!='') $tnombre=$nconcatenado;

	$frs = mysql_query($qsql);

	$fnum = mysql_num_rows($frs); 

	$fi=0;

	$mult='';

	$resultado='';

	if($multiple==1) 

	{

		$mult = " multiple='multiple' "; 

		$lclase="class='etiquetas'";

		$iclase="class='entradas_multiples'";

		$resultado="<script>$(function () { $('#$id').multipleSelect({filter: true}); });</script>";

		} 

	elseif($multiple==2)

	{

		$mult = " multiple='multiple' "; 

		$lclase="class='etiquetas'";

		$iclase="class='entradas_multiples'";

		$resultado="<script>$(function () { $('#$id').multipleSelect({filter: true,single: true}); });</script>";

	}	

	else {

		$lclase="class='etiquetas'";

		$iclase="class='entradas'";

		}	

	if($div==2)

		{

			$eti_label="span";

			$eti_input="noex";

			$lclase="";

			$iclase="";

		}

	if($ancho!="") $ancho = " style='width: $ancho" . "px !important'";



	if($sololectura!="") $sololectura = " disabled ";



	$resultado .= "<$eti_label $lclase>$etiqueta:</$eti_label>

					<$eti_input><select id=$id name=$id $iclase $mult $ancho $onclick $sololectura>";

	if($todo==1) $resultado .= "<option value=''>TODOS</option>";

	if($todo==2) $resultado .= "<option value=''></option>";



	while($fi<$fnum)

	{

	$option_valor = mysql_result($frs, $fi, $tid);

	$option_nombre = mysql_result($frs, $fi, $tnombre);



	//si $selected es diferente a 0 debo marcar cual es la seleccionada

	$esseleccion='';

	//echo $selected;

	if($selected!='')

	{

		if($selected==$option_valor)

		{

			$esseleccion = ' selected ';

		}

		else

		{

			$esseleccion = '';

		}

	}



	$resultado .= "<option value='$option_valor' $esseleccion>$option_nombre</option>";

	$fi++;

	}

	$resultado .= "</select></$eti_input>";



	return $resultado;

}



function entrada($tipo, $etiqueta, $id, $tamano='', $valor='', $readonly='', $onchange='', $no_etiqueta='', $stilo='')

{

	//SI ES TIPO INPUT

	if($tipo=='input')

	{

	if($no_etiqueta=='') $resultado ="<td class='etiquetas' $stilo>$etiqueta:</td>";

	if($valor!='') $valor = "value='$valor'";

	$resultado .= "<td class='entrada'><input $readonly type='text' id='$id' name='$id' style='width:" . $tamano ."px !important'  $valor $onchange></td>	";

	}

	

	if($tipo=='fecha')

	{

	if($no_etiqueta=='') $resultado ="<td class='etiquetas' $stilo>$etiqueta:</td>";

	$resultado .= "<td class='entrada' $stilo><input type='text' id='$id' name='$id' style='width:" . $tamano ."px !important'  

		autocomplete='off' $onchange value='$valor' $readonly></td>	";

	$resultado .= "<script>$('#$id').datepicker({ dateFormat: 'yymmdd' });</script>";

	}

	

	return $resultado;

}



function pantalla_roles($pantalla, $usuario)

{

	//busco todos los roles que tenga el usuario en esa pantalla

	$qsql = "select paro_item_id, paro_item_tipo

	from pantalla_roles a, usuarios_roles b

	where a.paro_id=b.paro_id

	and b.usua_id='$usuario'

	and paro_pantalla = '$pantalla'";

	

	//echo "alert('$qsql');";

	//echo "alert('" . str_replace("'", "", $qsql) . "');";

	//echo "alert('$pantalla');";

	//echo "alert('$usuario');";

	//echo $qsql;

	

	$rs_pr = mysql_query($qsql);

	$num_pr = mysql_num_rows($rs_pr);

	$pr=0;

	while($pr<$num_pr)

	{

		$crtl_nombre = mysql_result($rs_pr, $pr, 'paro_item_id');

		$crtl_tipo = mysql_result($rs_pr, $pr, 'paro_item_tipo');

		

		echo "$('.$crtl_nombre $crtl_tipo').prop('disabled', false);";

		echo "$('.$crtl_nombre').show();";

		//echo "alert('$crtl_nombre');";

		//echo "alert('$pantalla');";

		

		//SI ES TIPO F LE PONGO EL DATE PICK SOLO SI SE LE DA PERMISO

		if ($crtl_tipo=='f') echo "$('#$crtl_nombre').datepicker({ dateFormat: 'yymmdd' });";

		

		

		$pr++;

	}

}





function get_tiny_url($url) {

    $api_url = 'https://tinyurl.com/api-create.php?url=' . $url;



    $curl = curl_init();

    $timeout = 10;



    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_URL, $api_url);



    $new_url = curl_exec($curl);

    curl_close($curl);

	

	if(str_contains($new_url,'https://tinyurl')==false) $new_url='';

	

    return $new_url;

}



if (!function_exists('str_contains')) {

    function str_contains($haystack, $needle) {

        return $needle !== '' && mb_strpos($haystack, $needle) !== false;

    }

}





function enviar_email($from, $from_name, $subject, $mensaje, $email, $adjunto='')

{

$mail = new PHPMailer;



$mail_usuario = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='mail_usuario'","para_valor");

$mail_clave = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='mail_clave'","para_valor");

$mail_smtp = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='mail_smtp'","para_valor");

$mail_port = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='mail_port'","para_valor");

$mail_secure = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='mail_secure'","para_valor");

$from_name = obtener_valor("SELECT para_valor FROM parametros WHERE para_nombre='empresa'","para_valor");



//if($mail_secure=='') $mail_secure='tls';



$mail->IsSMTP();

$mail->Host = $mail_smtp;

$mail->SMTPDebug  = 1;  

$mail->SMTPAuth = true;

if($mail_secure!='') $mail->SMTPSecure = $mail_secure;  

$mail->Port = $mail_port;



/*

define('GUSER', 'info@logisticaxpress.com'); // GMail username

define('GPWD', 'XLogistic@.2020'); // GMail password

*/



$mail->Username = $mail_usuario;

$mail->Password = $mail_clave;



$mail->WordWrap = 50;

$mail->IsHTML(true);



if($mail_usuario!='apikey') $mail->From = $mail_usuario;

if($mail_usuario=='apikey') $mail->From = $from_name;

$mail->FromName = $from_name;

$mail->Subject = $subject;



//multiple correos

	$em = 0;

	if (strpos($email,';') !== false) 

		{

			$ccs = explode(';',$email);

			foreach($ccs as $key) 

			{

				if($em==0)

				{

				$mail->AddAddress($key);

				}

				else

				{

				//$mail->AddAddress($key);

				$mail->AddCC($key, $key);

				}

				$em++;

			}

		}

		else

		{

		$mail->AddAddress($email);

		}



if($adjunto!='')

{

	$mail->addAttachment($adjunto);

}	

		

$mail->Body = $mensaje;

$mail->Send();

}

?>