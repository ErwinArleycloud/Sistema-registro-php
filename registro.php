<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensaje = "";

// Conexión
$conexion = new mysqli("localhost", "root", "", "plataforma documentos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre   = $_POST["nombre"] ?? "";
    $correo   = $_POST["correo"] ?? "";
    $password = $_POST["password"] ?? "";

    if (strlen($password) < 6) {
        $mensaje = "<p id='error'>La contraseña debe tener al menos 6 caracteres</p>";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, correo, password)
                VALUES ('$nombre', '$correo', '$passwordHash')";

        if ($conexion->query($sql)) {
            $mensaje = "<p id='exito'>Usuario registrado correctamente</p>";
        } else {
            $mensaje = "<p id='error'>Error al registrar</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet"
    href="estilos.css">
<meta charset="UTF-8">
<title>Registro</title>
</head>
<body>
<?= $mensaje ?>

<form id="formRegistro"
class="form-registro" method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Registrarse</button>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("formRegistro");
    const passwordInput = document.getElementById("password");

    form.addEventListener("submit", function (e) {
        if (passwordInput.value.length < 6) {
            e.preventDefault();
            alert("⚠️ La contraseña debe tener al menos 6 caracteres");
        }
    });

    if (document.getElementById("exito")) {
        form.reset();
    }
});
</script>

</body>
</html>
