<?php
// Verificamos que la solicitud sea de tipo POST antes de procesar los datos.
// aseguramos que solo maneje solicitudes legítimas que deben modificar el estado del servidor.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Incluimos el archivo de conexión a la base de datos.
    require '../includes/db.php'; 

    // Obtenemos el valor de 'dni' enviado a través de la solicitud POST.
    $dni = $_POST['dni'];

    // Verificamos que el campo 'dni' no esté vacío antes de intentar eliminar el registro.
    if (!empty($dni)) {
        
        // Preparamos una consulta SQL para eliminar un registro en la tabla 'tbl_personas' donde el DNI coincida.
        $stmt = $conn->prepare('DELETE FROM tbl_personas WHERE DNI = ?');
        
        // Asignamos el valor del DNI al parámetro de la consulta preparada.
        $stmt->bind_param('s', $dni);
        
        // Ejecutamos la consulta y verifica si fue exitosa.
        // Si es exitosa, se devuelve una respuesta JSON indicando éxito.
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // Si la ejecución falla, se devuelve un mensaje de error en formato JSON.
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el registro.']);
        }
        
        // Cierra la sentencia para liberar los recursos asociados.
        $stmt->close();
    } else {
        // Si el DNI está vacío, se devuelve un error indicando que el DNI es inválido.
        echo json_encode(['success' => false, 'error' => 'DNI inválido.']);
    }

    // Cierra la conexión a la base de datos después de completar la operación.
    $conn->close();
} else {
    // Si la solicitud no es de tipo POST, se devuelve un error indicando que el método de solicitud no es válido.
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido.']);
}
?>
