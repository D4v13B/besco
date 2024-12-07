<?php

include('conexion.php');

include_once('funciones.php');

$contenido = $_POST['contenido'];


$archivo = $_POST['archivo'];

ob_start();

include($contenido);

$output0 = ob_get_clean();

ob_start();

// include($contenido);
?>



<page>

<style>

table

{

border-width: 1px 1px 1px 1px;

border-spacing: 0;

border-collapse: collapse;

border-style: solid;

margin-left: auto;

margin-right: auto;

width: 100%;

}



td

{

margin: 0;

padding: 4px;

border-width: 0px 0px 0px 0px;

border-style: solid;

font-family: Arial, Helvetica, sans-serif;

font-size: 8pt;

}



.etiquetas

{

    font-family: calibri;

    font-size: 8pt;

    color: #333333;

}



.etiquetas_center

{

    font-family: calibri;

    font-size: 8pt;

    color: #333333;

	text-align:center;

}



.etiquetas_right

{

    font-family: calibri;

    font-size: 8pt;

    color: #333333;

	text-align:right;

}

</style>

<?php

echo "<style>";

include('tablas.css');

include('interface.css');

include('style.css');

echo "</style>";

?>

<?php include($_POST["contenido"]) ?>

</page>

<?php

$content = ob_get_clean();

include("mpdf/mpdf.php");

$mpdf=new mPDF('', 'Letter'); 

$mpdf->WriteHTML($content);

$mpdf->Output("documentos_temporales/$archivo.pdf",'F');

$mpdf->Output();

exit;

?>