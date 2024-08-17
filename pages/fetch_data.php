<?php
include('../includes/db.php'); // Incluye db.php desde la carpeta includes

// Configurar el encabezado para JSON
header('Content-Type: application/json');

// Obtener cédula de la solicitud
$dni = $_GET['dni'] ?? '';

if ($dni) {
    // Consulta para obtener los datos
    $sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas WHERE DNI = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'No se encontraron datos para esta cédula.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta.']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó una cédula.']);
}

$conn->close();
?>
