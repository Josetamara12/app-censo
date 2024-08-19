<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
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
    <!-- Enlace al archivo CSS de Bootstrap desde un CDN para estilizar la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a tu archivo CSS personalizado para estilos adicionales -->
    <link href="styles.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Contenedor principal con margen superior -->
    <div class="container mt-5">
        <!-- Fila para centrar el contenido horizontalmente -->
        <div class="row justify-content-center">
            <!-- Columna con un ancho definido en dispositivos medianos y grandes -->
            <div class="col-md-8 col-lg-6">
                <!-- Tarjeta de Bootstrap para el menú principal -->
                <div class="card shadow-sm">
                    <!-- Encabezado de la tarjeta con estilo centrado y fondo primario -->
                    <div class="card-header text-center bg-primary text-white">
                        <!-- Saludo personalizado con el nombre del usuario -->
                        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
                    </div>
                    <!-- Cuerpo de la tarjeta con opciones del menú -->
                    <div class="card-body">
                        <!-- Mensaje introductorio centrado con margen inferior -->
                        <p class="text-center mb-4">Elige una opción:</p>
                        <!-- Lista de opciones del menú usando la clase list-group -->
                        <div class="list-group">
                            <!-- Enlace a la página de gestión de personas con estilo de item de lista -->
                            <a href="gestion_personas.php" class="list-group-item list-group-item-action">Gestión de Personas</a>
                            <!-- Enlace para mostrar los horarios de censo -->
                            <a href="obtener_horarios.php" id="horariosCenso" class="list-group-item list-group-item-action">Mostrar Horarios de Censo</a>
                            <!-- Enlace para exportar datos a CSV -->
                            <a href="exportar.php" class="list-group-item list-group-item-action">Exportar Datos a Excel</a>
                            <!-- Enlace para cerrar sesión con texto en rojo para indicar acción importante -->
                            <a href="logout.php" class="list-group-item list-group-item-action text-danger">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS desde el CDN para funcionalidades interactivas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Enlace a tu archivo JavaScript personalizado para scripts adicionales -->
    <script src="includes/script.js"></script>
</body>

</html>
