<?php
session_start();
include('../includes/db.php'); // Incluye db.php desde la carpeta incluye

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
function executeQuery($conn, $sql, $params = [], $fetch = false) {
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params)); // Tipo 's' para strings, ajustar si usas otros tipos
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    if ($fetch) {
        return $stmt->get_result();
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
                <div class="card-header text-center">
                    <h2>Gestión de Personas</h2>
                </div>
                <div class="card-body">
                    
                    <!-- Mostrar datos -->
                    <?php if ($result->num_rows > 0): ?>
                        <h4>Lista de Personas</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['DNI']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NOMBRE']); ?></td>
                                        <td><?php echo htmlspecialchars((new DateTime($row['FECNAC']))->format('d-m-Y')); ?></td>
                                        <td><?php echo htmlspecialchars($row['DIR']); ?></td>
                                        <td><?php echo htmlspecialchars($row['TFNO']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center">No hay datos disponibles.</p>
                    <?php endif; ?>
                    <!-- Botón para regresar al menú -->
                    <a href="menu.php" class="btn btn-primary mb-3">Volver al Menú</a>

                    <!-- Botones para abrir modales -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#insertModal">Agregar Persona</button>
                        <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateModal">Actualizar Persona</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Eliminar Persona</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" id="insert_dni" name="dni" required>
                    </div>
                    <div class="mb-3">
                        <label for="insert_nombre" class="form-label">Nombre:</label>
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
                        <input type="text" class="form-control" id="insert_tfno" name="tfno" required>
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
                        <label for="update_dni" class="form-label">Digita Numero de Cedula:</label>
                        <input type="text" class="form-control" id="update_dni" name="upd_dni" required>
                        <button type="button" id="fetchDataBtn" class="btn btn-info mt-2">Buscar Datos</button>
                    </div>
                    <div class="mb-3">
                        <label for="update_nombre" class="form-label">Nombre:</label>
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
                        <input type="text" class="form-control" id="update_tfno" name="tfno">
                    </div>
                    <button type="submit" name="update" class="btn btn-warning">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Datos -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="delete_dni" class="form-label">Cédula para Eliminar:</label>
                        <input type="text" class="form-control" id="delete_dni" name="dni" required>
                    </div>
                    <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Incluye el archivo de script externo -->
<script src="../includes/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
