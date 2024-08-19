<?php
// Define el tipo de contenido y el nombre del archivo para la descarga
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ListadoPersonas.xls");

// Incluye el archivo de conexión a la base de datos
// Asegúrate de que la ruta sea correcta según la estructura de tu proyecto
include("../includes/db.php");

// Verifica si la conexión a la base de datos fue exitosa
if (!$conn) {
    // Muestra un mensaje de error y termina el script si la conexión falla
    die("Connection failed: " . mysqli_connect_error());
}
// Define la consulta SQL para obtener los datos
$sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas";
// Ejecuta la consulta en la base de datos
$result = mysqli_query($conn, $sql);

// Verifica si la consulta se ejecutó correctamente
if (!$result) {
    // Muestra un mensaje de error y termina el script si la consulta falla
    die("Query failed: " . mysqli_error($conn));
}


// Empieza a construir la tabla HTML para el archivo Excel
echo '<table border="1">';  // Agrega un borde a la tabla para mejor visualización en Excel
echo '<tr>';
echo '<th>DNI</th>';
echo '<th>NOMBRE</th>';
echo '<th>FECNAC</th>';
echo '<th>DIR</th>';
echo '<th>TFNO</th>';
echo '</tr>';

// Recorre los resultados de la consulta y los agrega a la tabla HTML
while ($fila = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($fila['DNI']) . '</td>'; // Protege contra ataques XSS con htmlspecialchars
    echo '<td>' . htmlspecialchars($fila['NOMBRE']) . '</td>';
    echo '<td>' . htmlspecialchars($fila['FECNAC']) . '</td>';
    echo '<td>' . htmlspecialchars($fila['DIR']) . '</td>';
    echo '<td>' . htmlspecialchars($fila['TFNO']) . '</td>';
    echo '</tr>';
}

// Cierra la tabla HTML
echo '</table>';

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
