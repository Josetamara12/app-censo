<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metadatos del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlace al archivo CSS de Bootstrap desde un CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a tu archivo CSS personalizado -->
    <link href="styles.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
</head>

<body>
    <div class="container">
        <!-- Fila que centra el contenido vertical y horizontalmente -->
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <!-- Tarjeta de Bootstrap para el formulario de inicio de sesión -->
                <div class="card shadow-lg">
                    <div class="card-body">
                        <!-- Título del formulario -->
                        <h3 class="text-center mb-4">Iniciar Sesión</h3>
                        <!-- Formulario que envía los datos a procesar_login.php mediante el método POST -->
                        <form action="procesar_login.php" method="POST">
                            <!-- Campo de entrada para el nombre de usuario -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <!-- Campo de entrada para la contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Botón para enviar el formulario -->
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a tu archivo JavaScript personalizado -->
    <script src="scripts.js"></script>
    <!-- Bootstrap JS desde el CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
