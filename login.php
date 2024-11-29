<?php
session_start();
include 'db.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Procesar el inicio de sesión
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: recetas.php");
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Inicia Sesión en el Recetario</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="register.php" class="btn-register">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login">
            <h2>Inicia Sesión</h2>
            <?php if ($error): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            <form action="" method="POST" class="form-login">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" class="btn-primary">Ingresar</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
    </footer>
</body>
</html>