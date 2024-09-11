<?php include('../conexion.php');
$id=$_GET['id'];
$qsql ="select * from cons_notas_credito a, cons_proveedores b 
where nocr_id='$id'
AND a.crpr_id=b.copr_id";
$rs=mysql_query($qsql); 
$i=0;
echo mysql_result($rs,$i,'nocr_id') . '||';
echo mysql_result($rs,$i,'crpr_id') . '||';
echo mysql_result($rs,$i,'nocr_fecha') . '||';
echo mysql_result($rs,$i,'nocr_id') . '||';
echo mysql_result($rs,$i,'copr_nombre') . '||';
echo mysql_result($rs,$i,'proy_id') . '||';
?>
