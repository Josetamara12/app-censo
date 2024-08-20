<?php
// iniciamos sesion y verificamos la autent.
session_start();

// Verificar si el usuario ha iniciado o reaunuda la sesion
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
//Se incluyen los archivos de la librería PhpSpreadsheet, las clases de PhpSpreadsheet manualmente
require '../phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require '../phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';

//Se importan las clases Spreadsheet y Xlsx del espacio de nombres PhpOffice\PhpSpreadsheet 
//para crear y escribir archivos Excel.
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Configurar conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "censa_db"; 

// Crear conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

//Se verifica si hubo un error al conectar a la base de datos.// 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener todos los registros de la tabla
$sql = "SELECT * FROM tbl_personas";
$result = $conn->query($sql);

//Crear y llenar el archivo de Excel
//verificamos si la consulta ha devuelto algún registro
if ($result->num_rows > 0) {
    // Crear nuevo archivo de Excel
    $spreadsheet = new Spreadsheet();// Se crea una nueva instancia de Spreadsheet y se obtiene la hoja activa
    $sheet = $spreadsheet->getActiveSheet();

    // Escribimos los encabezados en la primera fila
    $sheet->setCellValue('A1', 'DNI');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Fecha de Nacimiento');
    $sheet->setCellValue('D1', 'Dirección');
    $sheet->setCellValue('E1', 'Teléfono');


    //Se configuran los encabezados de las columnas en la primera fila del archivo de Excel.
    // Escribir los datos
    $row = 2; //escribimos la información de cada registro en las filas correspondientes del archivo de Excel.
    while ($data = $result->fetch_assoc()) {// se inicia desde la segunda fila 
        $sheet->setCellValue('A' . $row, $data['DNI']);
        $sheet->setCellValue('B' . $row, $data['NOMBRE']);
        $sheet->setCellValue('C' . $row, $data['FECNAC']);
        $sheet->setCellValue('D' . $row, $data['DIR']);
        $sheet->setCellValue('E' . $row, $data['TFNO']);
        $row++;
    }

    // se establece el nombre del archivo basado en la fecha y la hora y exportar
    $filename = "ListadoPersonas_" . date('Ymd_His') . ".xlsx";
    $writer = new Xlsx($spreadsheet);
    
    // Redirigimos la salida del navegador al archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit();
} else {
    echo "No se encontraron registros.";
}

//Se cierra la conexión a la base de datos para liberar recursos.
$conn->close();
?>
