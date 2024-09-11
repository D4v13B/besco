<?php 
function data_grid($rs, $tipos, $tot='', $subt='')
{
	//resibe el rs del query y genera un grid con sus valores
	//recibe tipos por cada columna y le dice que tipo de valor voy a colocar en cada columna
	//ejmp. V representa varchar y se coloca a la izquierda
	//ejmp. D representa decimal y se coloca formateado a la derecha
	
	$arr_tipos = explode(",", $tipos);
	$arr_totales = explode(",", $tipos); //creo arrays donde guardo los totales
	$arr_subtotales = explode(",", $tipos); //creo arrays donde guardo los subtotales
	//echo $pieces[0]; // piece1
	
	
	$lgrid = "";
	$primer_campo_fin = "";
	$scant=0;
	$num = mysql_num_rows($rs); //cantidad de registros
	$i=0; //contador inicial
	$j=-1; //cantidad de registros
	$nrows = mysql_num_fields($rs);
	while($i<$num)
	{
		//debo saber si estoy en el primer registro
		$j++;
		if($i>0)
			{
				$primer_campo_inicio=mysql_result($rs, $i, 0);
				//aqui comparo si el fin es diferente al inicio o estoy en el último registro
				if($primer_campo_inicio!=$primer_campo_fin)
				{
					//armo el subtotal si lo pidieron
					if($subt==1)
					{
						$lgrid .='<tr>';
					for($x=0;$x<$nrows;$x++)
						{
							if($arr_tipos[$x]=='D') 
								{
								$valor = $arr_subtotales[$x];
								$valor = number_format($valor,2);
								$stilo = "style='text-align:right !important;background-color:#DAEEF5'";
								}
							elseif($arr_tipos[$x]=='VC')
								{
								$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
								$valor = $scant;
								}
							elseif($arr_tipos[$x]=='VS')
								{
								$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
								$valor = $j;
								}
							elseif($x=='0')
							{
							$stilo = "style='text-align:left !important;background-color:#DAEEF5'";
							$valor = "SUB-TOTAL";
							}
							else
								{
								$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
								$valor = "";
								}
												
							$lgrid .= "<td class=tabla_datos $stilo>" . $valor . "</td>";
							$arr_subtotales[$x]=0; //limpio los subtotales
						}
						$lgrid .='</tr>';
						$scant=0;
						$j=0;
					}
				}
			}
		//realizo un loop por cada una de las columnas para ir armando el grid
		$lgrid .="<tr>";
		for($x=0;$x<$nrows;$x++)
		{
			$valor = mysql_result($rs, $i, $x);
							
			if($arr_tipos[$x]=='V') $stilo = "style='text-align:left !important'";
			if($arr_tipos[$x]=='VS') $stilo = "style='text-align:center !important'";
			if($arr_tipos[$x]=='VC') 
				{
					$stilo = "style='text-align:center !important'";
					$scant++;
				}
			if($arr_tipos[$x]=='D') 
				{
				$stilo = "style='text-align:right !important'";
				$arr_totales[$x] += $valor;
				$arr_subtotales[$x] += $valor;
				$valor = number_format($valor,2);
				}
			if($arr_tipos[$x]=='DU') 
				{
				//si es el primer registro lo muestro en los demas no!
				if($primer_campo_inicio!=$primer_campo_fin || $i==0)
					{
					$stilo = "style='text-align:right !important'";
					$valor = number_format($valor,2);	
					}
					else
					{
					$valor = "";	
					}
				}
			if($arr_tipos[$x]=='VU') 
				{
				//si es el primer registro lo muestro en los demas no!
				if($primer_campo_inicio!=$primer_campo_fin || $i==0)
					{
					$stilo = "style='text-align:center !important'";
					}
					else
					{
					$valor = "";	
					}
				}
			if($arr_tipos[$x]=='F') $stilo = "style='text-align:center !important'";
						
			$lgrid .= "<td class=tabla_datos $stilo>" . $valor . "</td>";
		}
		$lgrid .="</tr>";
		
		
		$primer_campo_fin=mysql_result($rs, $i, 0);
		
		$i++;
	}
	//escribo el último subtotal si lo piden
	if($i==$num)
	{
		//armo el subtotal si lo pidieron
		if($subt==1)
		{
			$lgrid .='<tr>';
		for($x=0;$x<$nrows;$x++)
			{
				if($arr_tipos[$x]=='D') 
					{
					$valor = $arr_subtotales[$x];
					try {$valor = number_format($valor,2);} catch(Exception $e) {$valor=0;}
					$stilo = "style='text-align:right !important;background-color:#DAEEF5'";
					}
				elseif($arr_tipos[$x]=='VC')
					{
					$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
					$valor = $scant;
					}
				elseif($arr_tipos[$x]=='VS')
					{
					$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
					$valor = $j;
					}
				elseif($x=='0')
				{
				$stilo = "style='text-align:left !important;background-color:#DAEEF5'";
				$valor = "SUB-TOTAL";
				}
				else
					{
					$stilo = "style='text-align:center !important;background-color:#DAEEF5'";
					$valor = "";
					}
									
				$lgrid .= "<td class=tabla_datos $stilo>" . $valor . "</td>";
				$arr_subtotales[$x]=0; //limpio los subtotales
			}
			$lgrid .='</tr>';
			$scant=0;
		}
	}
	
	//si me dicen $tot=1 entonces genero los totales
	if($tot==1)
	{
		$lgrid .='<tr>';
	for($x=0;$x<$nrows;$x++)
		{
			if($arr_tipos[$x]=='D') 
				{
				$valor = $arr_totales[$x];
				try {$valor = number_format($valor,2);} catch(Exception $e) {$valor=0;}
				$stilo = "style='text-align:right !important;background-color:#969696'";
				}
			elseif($arr_tipos[$x]=='VC')
				{
				$stilo = "style='text-align:center !important;background-color:#969696'";
				$valor = $num;
				}
			elseif($x=='0')
				{
				$stilo = "style='text-align:left !important;background-color:#969696'";
				$valor = "TOTAL";
				}
			else
				{
				$stilo = "style='text-align:right !important;background-color:#969696'";
				$valor = "";
				}
								
			$lgrid .= "<td class=tabla_datos $stilo>" . $valor . "</td>";
		}
		$lgrid .='</tr>';
	}
	
//retorno el grid
return $lgrid;
}
?>