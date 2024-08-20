
<?php

//Este código PHP se encarga de actualizar los datos de una persona
//en la base de datos tbl_personas
// utilizando los valores enviados desde un formulario a través de una solicitud POST.

include('../includes/db.php'); // Incluye db.php que contiene la configuracion para conectarse a la bd

//establezco un tipo de contenido, indica que la respuesta del server sera un JSON
header('Content-Type: application/json');

//verificamos la conexion a la base de datos
if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);//Se verifica si la conexión a la base de datos falló.
    exit;// si es asi devuelve nun mensaje de error en formato json
}

// Obtenemos los datos del formulario
$dni = $_POST['upd_dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$fecnac = $_POST['fecnac'] ?? '';
$dir = $_POST['dir'] ?? '';
$tfno = $_POST['tfno'] ?? '';

// validamos que todos los datos esten presentes 
if ($dni && $nombre && $fecnac && $dir && $tfno) {
    //preparamos y ejecutamos la consulta SQL
    $sql = "UPDATE tbl_personas SET NOMBRE = ?, FECNAC = ?, DIR = ?, TFNO = ? WHERE DNI = ?"; // esta consulta utiliza
    //parametros ? para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);

    // se prepara la consulta y se enlazan los parametros, con los valores correspondientes
    if ($stmt) {
        $stmt->bind_param('sssss', $nombre, $fecnac, $dir, $tfno, $dni);
        //luego se ejecuta la consulta
        $stmt->execute();
        
        //verificamos el resultado de la actualizacion
        if ($stmt->affected_rows > 0) {
            // si se realizaron obtenemos un json con success' => true
            echo json_encode(['success' => true]);
        } else { 
            // si no se realizaron los cambios, se devuelve un error en format json
            echo json_encode(['error' => 'No se realizaron cambios.']);
        }
        // se cierra la declaracion 
        $stmt->close();
    // manejo de errores
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta.']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos.']);
}

// cierro la conexion a la db
$conn->close();
?>
