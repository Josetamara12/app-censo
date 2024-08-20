<?php

//Este código PHP maneja una solicitud para obtener información sobre una persona específica desde
// la base de datos, basada en su número de cédula (DNI). El resultado se devuelve en formato JSON

include('../includes/db.php'); // incluimos la ruta donde esta la configuracion de la bd

// Configurar el encabezado http para JSON
header('Content-Type: application/json'); //indicamos que el contenido que se devolverá es de tipo JSON

// Obtenemos el numero de cédula de la solicitud
$dni = $_GET['dni'] ?? '';// Este comando obtiene el valor del parámetro dni que viene en la URL como parte de la solicitud GET

// Verificación de la cédula y consulta a la base de datos
if ($dni) {
    // consulta para obtener los datos
    $sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas WHERE DNI = ?";
    $stmt = $conn->prepare($sql);

    //vinculamos los parámetros y ejecución de la consulta
    if ($stmt) {
        $stmt->bind_param('s', $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //manejamos los resultados
        //Verificamos si la consulta encontró algún registro
        if ($result->num_rows > 0) {// Obtenemos la fila de resultados como un array asociativo
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            //Si no se encontraron registros, se devuelve un mensaje JSON
            echo json_encode(['message' => 'No se encontraron datos para esta cédula.']);
        }
        $stmt->close();
    } else {
        // si la preparacion de la onsulta falla por algun motivo, se devuelve un error en formato json
        echo json_encode(['error' => 'Error al preparar la consulta.']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó una cédula.']);
}

//cierre de la conexion
$conn->close();
?>
