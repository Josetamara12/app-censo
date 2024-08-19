<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../includes/db.php'; // Incluir la conexión a la base de datos

    $dni = $_POST['dni'];

    if (!empty($dni)) {
        $stmt = $conn->prepare('DELETE FROM tbl_personas WHERE DNI = ?');
        $stmt->bind_param('s', $dni);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el registro.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'DNI inválido.']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido.']);
}
?>
