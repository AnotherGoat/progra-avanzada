<?php
include_once "class.Ambiente.php";

$amb = new Ambiente(1000, 800);
$amb->generaEntesAlAzar(45, "#33AA44"); // verde
$amb->generaEntesAlAzar(5, "#AA3344"); // rojo
echo $amb->VistaSVG();
?>