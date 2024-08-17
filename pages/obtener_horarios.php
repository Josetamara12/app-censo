<?php
include('../includes/db.php'); // Incluye el archivo de conexión a la base de datos

// Configurar el encabezado para JSON
header('Content-Type: application/json');

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Consulta para obtener los horarios
$sql = "SELECT dia, horario FROM tbl_horarios";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['dia']] = $row['horario'];
    }
} else {
    $data = ['mensaje' => 'No se encontraron horarios.'];
}

echo json_encode($data);

$conn->close();
?>
