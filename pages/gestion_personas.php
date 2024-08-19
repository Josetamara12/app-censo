<?php
session_start();
include('../includes/db.php'); // Incluye db.php desde la carpeta includes

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar conexión a la base de datos
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para ejecutar una consulta SQL
// Función para ejecutar una consulta SQL
function executeQuery($conn, $sql, $params = [], $fetch = false) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    if ($params) {
        $types = str_repeat('s', count($params)); // Tipo 's' para strings, ajustar si usas otros tipos
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    if ($fetch) {
        $result = $stmt->get_result();
        if (!$result) {
            die("Error al obtener el resultado: " . $stmt->error);
        }
        return $result;
    }
    return $stmt->affected_rows;
}

// Insertar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])) {
    $sql = "INSERT INTO tbl_personas (DNI, NOMBRE, FECNAC, DIR, TFNO) VALUES (?, ?, ?, ?, ?)";
    $params = [$_POST['dni'], $_POST['nombre'], $_POST['fecnac'], $_POST['dir'], $_POST['tfno']];
    executeQuery($conn, $sql, $params);
    header("Location: gestion_personas.php");
    exit();
}

// Actualizar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $sql = "UPDATE tbl_personas SET NOMBRE=?, FECNAC=?, DIR=?, TFNO=? WHERE DNI=?";
    $params = [$_POST['nombre'], $_POST['fecnac'], $_POST['dir'], $_POST['tfno'], $_POST['dni']];
    executeQuery($conn, $sql, $params);
    header("Location: gestion_personas.php");
    exit();
}

// Eliminar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $sql = "DELETE FROM tbl_personas WHERE DNI=?";
    $params = [$_POST['dni']];
    executeQuery($conn, $sql, $params);
    header("Location: gestion_personas.php");
    exit();
}

// Obtener datos para mostrar
$sql = "SELECT DNI, NOMBRE, FECNAC, DIR, TFNO FROM tbl_personas";
$result = executeQuery($conn, $sql, [], true);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-dialog { max-width: 800px; }
    </style>
</head>


<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Gestión de Personas</h2>
                </div>
                <div class="card-body">
    <h4>Lista de Personas</h4>
<!-- Tabla de Datos -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Fecha de Nacimiento</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th class="text-center">Opciones</th> <!-- Alineación a la derecha -->
        </tr>
    </thead>
    <tbody id="personasTableBody">

     <!-- Botón para abrir el modal de agregar -->
     <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#insertModal">Agregar Persona</button>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr data-id="<?= $row['DNI'] ?>">
            <td><?= htmlspecialchars($row['DNI']) ?></td>
            <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
            <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['FECNAC']))) ?></td>
            <td><?= htmlspecialchars($row['DIR']) ?></td>
            <td><?= htmlspecialchars($row['TFNO']) ?></td>
            <td class="text-end">
                //botones
                <button type="button" class="btn btn-warning btn-sm me-2 btn-edit" data-id="<?= $row['DNI'] ?>">Editar</button>
                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['DNI'] ?>">Eliminar</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <!-- Botón para regresar al menú -->
    <a href="menu.php" class="btn btn-primary mb-3">Volver al Menú</a>

    
<!-- Modal para Insertar Datos -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">Agregar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="insert_dni" class="form-label">Cédula:</label>
                        <input type="number" class="form-control" id="insert_dni" name="dni" required>
                    </div>
                    <div class="mb-3">
                        <label for="insert_nombre" class="form-label">Nombre y Apellido:</label>
                        <input type="text" class="form-control" id="insert_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="insert_fecnac" class="form-label">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="insert_fecnac" name="fecnac" required>
                    </div>
                    <div class="mb-3">
                        <label for="insert_dir" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="insert_dir" name="dir" required>
                    </div>
                    <div class="mb-3">
                        <label for="insert_tfno" class="form-label">Teléfono:</label>
                        <input type="number" class="form-control" id="insert_tfno" name="tfno" required>
                    </div>
                    <button type="submit" name="insert" class="btn btn-success">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Actualizar Datos -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="post">
                    <div class="mb-3">
                        <label for="update_dni" class="form-label">Cédula (DNI):</label>
                        <input type="number" class="form-control" id="update_dni" name="cedula" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="update_nombre" class="form-label">Nombre y Apellido:</label>
                        <input type="text" class="form-control" id="update_nombre" name="nombre">
                    </div>
                    <div class="mb-3">
                        <label for="update_fecnac" class="form-label">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="update_fecnac" name="fecnac">
                    </div>
                    <div class="mb-3">
                        <label for="update_dir" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="update_dir" name="dir">
                    </div>
                    <div class="mb-3">
                        <label for="update_tfno" class="form-label">Teléfono:</label>
                        <input type="number" class="form-control" id="update_tfno" name="tfno">
                    </div>
                    <button type="submit" name="update" class="btn btn-warning">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Incluye el archivo de script externo -->

<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="../includes/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
