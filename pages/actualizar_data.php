<?php
include('../includes/db.php'); // Incluye db.php desde la carpeta incluye

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Obtener datos del formulario
$dni = $_POST['upd_dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$fecnac = $_POST['fecnac'] ?? '';
$dir = $_POST['dir'] ?? '';
$tfno = $_POST['tfno'] ?? '';

if ($dni && $nombre && $fecnac && $dir && $tfno) {
    $sql = "UPDATE tbl_personas SET NOMBRE = ?, FECNAC = ?, DIR = ?, TFNO = ? WHERE DNI = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('sssss', $nombre, $fecnac, $dir, $tfno, $dni);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se realizaron cambios.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta.']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos.']);
}

$conn->close();
?>
