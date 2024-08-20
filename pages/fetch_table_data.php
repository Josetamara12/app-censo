<?php
include('../includes/db.php'); // incluimos el archivo de conexion a la bd

//configuracion del encabezado http para json
header('Content-Type: application/json');


//verificamos la conexion a la bd
if ($conn->connect_error) {// verificamos si ocurrio algun error al intentar conectar la bd
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);// si hay error en la cone, envia mensaje en form json
    exit; // termina la ejecucion. 
}

// consulta sql para obtener datos de la tabla tbl_personas
$sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas"; // se define la consults en la bd y almacena el resultado
$result = $conn->query($sql);


// procesamiento de la consulta
$data = []; // se inicia un array vacio
if ($result->num_rows > 0) {// verificamos si la consulta devuelve alguna fila 
    while ($row = $result->fetch_assoc()) { // recorremos cada fila del resultado de la consulta
        $data[] = $row; // agregamos cada fila al array. 
    }
}

// enviamos los datos como json 
echo json_encode($data);//convierte el array $data en una cadena json. 

//cerramos la conexion a la bd
$conn->close();
?>
