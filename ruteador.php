<?php
include_once("controladores/controlador".$controlador.".php");
$objcontrolador="controlador".ucfirst($controlador);

$controlador=new $objcontrolador();

$controlador->$accion();

?>

