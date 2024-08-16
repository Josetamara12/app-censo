/* Pagina principal donde se gestionara el censo */

<?php
// census.php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar inserciones, actualizaciones o eliminaciones
}

$stmt = $pdo->query('SELECT * FROM tbl_personas');
$personas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Censo de Personas</title>
    <link rel="stylesheet" href="../assets/libs/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Censo de Personas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Fecha Nacimiento</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personas as $persona): ?>
                    <tr>
                        <td><?php echo $persona['DNI']; ?></td>
                        <td><?php echo $persona['NOMBRE']; ?></td>
                        <td><?php echo $persona['FECNAC']; ?></td>
                        <td><?php echo $persona['DIR']; ?></td>
                        <td><?php echo $persona['TFNO']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Formulario para añadir/editar personas -->
    </div>
</body>
</html>
