<?php

//Este código PHP establece una conexión a una base de datos MySQL utilizando la extensión MySQLi.

// Parámetros de conexión a la base de datos
$servername = "localhost"; // defino el nombre del server
$username = "root"; 
$password = "";            
$dbname = "censo_db";      

// Crear una nueva conexión a la base de datos usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);
//Aquí se crea un nuevo objeto mysqli que establece la conexión a la base de datos.

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    // connect_error es una propiedad del objeto mysqli que contiene el mensaje de error si la conexión falla.
    die("Conexión fallida: " . $conn->connect_error);
//Aqui verifico si hubo un error al intentar establecer la conexión.
//si lo hay die() detiene la ejecucion del script y muestra error.

}


?>
