<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Bienvenido, Ingeniero <?php echo $_SESSION["username"]; ?></h2>
                </div>
                <div class="card-body">
                    <p class="text-center">Elige una opción:</p>
                    <div class="list-group">
                        <a href="gestion_personas.php" class="list-group-item list-group-item-action">Gestión de Personas</a>
                        <a href="ver_horarios.php" class="list-group-item list-group-item-action">Ver Horarios de Censo</a>
                        <a href="exportar_excel.php" class="list-group-item list-group-item-action">Exportar Datos a Excel</a>
                        <a href="logout.php" class="list-group-item list-group-item-action text-danger">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
