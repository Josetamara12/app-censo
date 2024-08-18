<?php
include('../includes/db.php'); // Incluye db.php desde la carpeta incluye

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
