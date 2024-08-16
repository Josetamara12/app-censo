<?php
session_start();
include('../includes/db.php'); // Asegúrate de que esta ruta es correcta

// Verifica si la conexión se realizó correctamente
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta para verificar si el usuario existe
$sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Usuario encontrado, iniciar sesión
    $_SESSION['username'] = $username;
    header("Location: menu.php"); // Redirigir al menú principal
} else {
    // Usuario no encontrado, mostrar error
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href = 'login.php';</script>";
}

$stmt->close();
$conn->close();
?>
