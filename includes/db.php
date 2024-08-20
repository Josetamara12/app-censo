<?php
// Parámetros de conexión a la base de datos
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "censo_db";      

// Crear una nueva conexión a la base de datos usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    // Si hay un error de conexión, detener la ejecución y mostrar el error
    die("Conexión fallida: " . $conn->connect_error);
}

// Puedes añadir más código aquí para trabajar con la base de datos

?>
