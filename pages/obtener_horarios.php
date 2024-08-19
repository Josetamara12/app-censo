<?php
// Aquí puedes definir los horarios directamente en el archivo PHP
$horarios = [
    ["dia" => "Lunes", "horario" => "8:00 AM - 5:00 PM"],
    ["dia" => "Martes", "horario" => "8:00 AM - 5:00 PM"],
    ["dia" => "Miércoles", "horario" => "8:00 AM - 5:00 PM"],
    ["dia" => "Jueves", "horario" => "8:00 AM - 5:00 PM"],
    ["dia" => "Viernes", "horario" => "8:00 AM - 5:00 PM"],
    ["dia" => "Sábado", "horario" => "8:00 AM - 2:00 PM"]
];
?>

<!DOCTYPE html>
<html lang="es">

<<head>
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
                    <h2>Horarios para realizar los censos</h2>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Día</th>
                                <th class="text-center">Horario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($horarios as $horario): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars($horario['dia']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($horario['horario']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS desde el CDN para funcionalidades interactivas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
