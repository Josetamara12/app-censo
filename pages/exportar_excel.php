<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Incluir las clases de PhpSpreadsheet manualmente
require '../phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require '../phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "censa_db"; 

// Crear conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener todos los registros de la tabla
$sql = "SELECT * FROM tbl_personas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear nuevo archivo de Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Escribir los encabezados en la primera fila
    $sheet->setCellValue('A1', 'DNI');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Fecha de Nacimiento');
    $sheet->setCellValue('D1', 'Dirección');
    $sheet->setCellValue('E1', 'Teléfono');

    // Escribir los datos
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['DNI']);
        $sheet->setCellValue('B' . $row, $data['NOMBRE']);
        $sheet->setCellValue('C' . $row, $data['FECNAC']);
        $sheet->setCellValue('D' . $row, $data['DIR']);
        $sheet->setCellValue('E' . $row, $data['TFNO']);
        $row++;
    }

    // Establecer el nombre del archivo y exportar
    $filename = "ListadoPersonas_" . date('Ymd_His') . ".xlsx";
    $writer = new Xlsx($spreadsheet);
    
    // Redirigir la salida del navegador al archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit();
} else {
    echo "No se encontraron registros.";
}

$conn->close();
?>
