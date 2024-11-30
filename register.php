<?php
session_start();
include 'db.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Procesar el registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $email, $password]);

    // Redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Regístrate en el Recetario</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="register">
            <h2>Crear una cuenta</h2>
            <form action="" method="POST" class="form-register">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" class="btn-primary">Registrarse</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
        <div class="social-links">
            <a href="https://www.youtube.com/user/canalcocina" target="_blank">YouTube</a>
            <a href="https://vimeo.com/channels/661677" target="_blank">Vimeo</a>
            <a href="https://open.spotify.com/show/2SiHtlkhVKeG85wYMZtfK1" target="_blank">Spotify</a>
        </div>
    </footer>
</body>
</html>