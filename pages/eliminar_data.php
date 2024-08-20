<?php
// Verifica que la solicitud sea de tipo POST antes de procesar los datos.
// Esto asegura que el script solo maneje solicitudes legítimas que deben modificar el estado del servidor.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Incluir el archivo de conexión a la base de datos.
    // Es una buena práctica separar la lógica de conexión en un archivo aparte.
    require '../includes/db.php'; 

    // Obtiene el valor de 'dni' enviado a través de la solicitud POST.
    // No hay validación adicional en este punto, pero podrías considerar validarlo para asegurarte de que sea un formato válido.
    $dni = $_POST['dni'];

    // Verifica que el campo 'dni' no esté vacío antes de intentar eliminar el registro.
    // Esto previene intentos de eliminación con un DNI vacío, lo cual no tendría sentido.
    if (!empty($dni)) {
        
        // Prepara una consulta SQL para eliminar un registro en la tabla 'tbl_personas' donde el DNI coincida.
        // Usar sentencias preparadas (prepared statements) ayuda a prevenir inyecciones SQL.
        $stmt = $conn->prepare('DELETE FROM tbl_personas WHERE DNI = ?');
        
        // Asigna el valor del DNI al parámetro de la consulta preparada.
        // Aquí se usa 's' para indicar que el parámetro es de tipo string.
        $stmt->bind_param('s', $dni);
        
        // Ejecuta la consulta y verifica si fue exitosa.
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
    // Siempre es importante cerrar la conexión para evitar sobrecargar el servidor.
    $conn->close();
} else {
    // Si la solicitud no es de tipo POST, se devuelve un error indicando que el método de solicitud no es válido.
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido.']);
}
?>
