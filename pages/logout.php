<?php

// script en php sencillo  que finaliza la sesion actual del usuario
session_start(); // funcion que inicia la sesion 
session_destroy(); // funcion que destruye la sesion actual
header("Location: login.php"); // esta linea envia una cabecera http al navegador
exit(); // funcion que detiene la ejecucion. 
?>
