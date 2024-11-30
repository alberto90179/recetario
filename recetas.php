<?php 
session_start();
include 'db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtiene el nombre del usuario
$stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch();
$nombre_usuario = $usuario ? htmlspecialchars($usuario['nombre']) : '';

// Consulta todas las recetas del usuario
$stmt = $pdo->prepare("SELECT * FROM recetas WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$usuario_id]);
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Recetas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Mis Recetas</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="add_receta.php">Agregar Receta</a></li>
                <li><a href="logout.php" class="btn-logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
        <p class="welcome">Bienvenido, <?php echo $nombre_usuario; ?>!</p>
    </header>

    <main>
        <section class="recipes-list">
            <h2>Gestión de Recetas</h2>
            <div class="recetas">
                <?php if ($recetas): ?>
                    <?php foreach ($recetas as $receta): ?>
                        <article class="receta-card">
                            <img src="assets/uploads/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="<?php echo htmlspecialchars($receta['titulo']); ?>" class="receta-img">
                            <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                            <div class="receta-actions">
                                <a href="receta.php?id=<?php echo htmlspecialchars($receta['id']); ?>" class="btn-primary">Ver</a>
                                <a href="edit_receta.php?id=<?php echo htmlspecialchars($receta['id']); ?>" class="btn-secondary">Editar</a>
                                <form action="delete_receta.php" method="POST" class="form-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($receta['id']); ?>">
                                    <button type="submit" class="btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes recetas guardadas.</p>
                <?php endif; ?>
            </div>
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