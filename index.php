<?php
session_start();
include 'db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}   

// Obtiene el nombre del usuario de la base de datos
$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch();
$nombre_usuario = $usuario ? htmlspecialchars($usuario['nombre']) : ''; // Escapa el nombre para evitar XSS

// Consulta todas las recetas
$stmt = $pdo->query("SELECT * FROM recetas ORDER BY id DESC");
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Asegúrate de obtener un array asociativo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>
    <link rel="stylesheet" href="assets/css/styles.css"> 
</head>
<body>
    <header class="header">
        <h1>🍴 Recetas Disponibles</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="add_receta.php">Agregar Receta</a></li>
                <li><a href="logout.php" class="btn-logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
        <?php if ($nombre_usuario): ?>
            <p>Bienvenido, <?php echo $nombre_usuario; ?>!</p>
        <?php endif; ?>
    </header>
    <main>
        <section class="recipes-list">
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