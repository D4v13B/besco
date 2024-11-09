<?php 

include "../funciones.php";
include "../conexion.php";

/**
 * factura_devolver.php
 * 
 * Este archivo es para anular la factura y retornar a restantes y quitar de inventario
 */

$fact_id = $_GET["id"];

//Aqui vamos a cambiar el estado a anulada
$sql = "UPDATE cons_facturas SET faes_id = 4 WHERE fact_id = $fact_id";
mysql_query($sql);

//Luego vamos a quitar de los recibidos de la tabla compra_detalles
$sql = "UPDATE cons_orden_compra_detalles a
    JOIN cons_facturas_detalles b
    ON a.prod_id = b.prod_id
    JOIN cons_facturas c
    ON b.fact_id = c.fact_id AND a.orco_id = c.orco_id
SET a.orcd_recibido = a.orcd_recibido - b.fade_cantidad
WHERE c.fact_id = $fact_id";

mysql_query($sql);

$sql = "UPDATE construccion_presupuesto p
    JOIN cons_facturas c
        ON p.coru_id = c.orco_id
    JOIN cons_facturas_detalles cf
        ON cf.fact_id = c.fact_id
SET p.copr_inventario = p.copr_inventario - cf.fade_cantidad,
    p.copr_pendientes = p.copr_pendientes + cf.fade_cantidad
WHERE c.fact_id = $fact_id";

mysql_query($sql);

?>