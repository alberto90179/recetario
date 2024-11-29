<?php 
session_start();
include 'db.php';

// Verifica si el usuario está logueado
$loggedIn = isset($_SESSION['usuario_id']);
$nombre_usuario = '';

if ($loggedIn) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    $nombre_usuario = $usuario ? htmlspecialchars($usuario['nombre']) : '';
}

// Consulta todas las recetas
$stmt = $pdo->query("SELECT * FROM recetas ORDER BY id DESC");
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener recetas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Recetario Culinario</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <?php if ($loggedIn): ?>
                    <li><a href="recetas.php">Ver Recetas</a></li>
                    <li><a href="add_receta.php">Agregar Receta</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if ($loggedIn): ?>
            <p class="welcome">Bienvenido, <?php echo $nombre_usuario; ?>!</p>
        <?php endif; ?>
    </header>

    <main>
        <section>
            <h2>Explora nuestras recetas</h2>
            <div class="recetas">
                <?php if (count($recetas) > 0): ?>
                    <?php foreach ($recetas as $receta): ?>
                        <article class="receta-card">
                            <img src="assets/uploads/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="<?php echo htmlspecialchars($receta['titulo']); ?>">
                            <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                            <a href="receta.php?id=<?php echo htmlspecialchars($receta['id']); ?>" class="btn-primary">Ver receta</a>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay recetas disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
    </footer>
</body>
</html>
