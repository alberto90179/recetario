<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = ?");
    $stmt->execute([$id]);
    $receta = $stmt->fetch();

    if (!$receta) {
        die("Receta no encontrada");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receta['titulo']); ?> | Recetario Culinario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Recetario Culinario</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="recetas.php">Recetas</a></li>
                <li><a href="logout.php" class="btn-logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="receta-detalle">
            <h2><?php echo htmlspecialchars($receta['titulo']); ?></h2>
            <img src="assets/uploads/<?php echo $receta['imagen']; ?>" alt="<?php echo htmlspecialchars($receta['titulo']); ?>" class="receta-img">
            <div class="detalles">
                <h3>Ingredientes</h3>
                <p><?php echo nl2br(htmlspecialchars($receta['ingredientes'])); ?></p>
                
                <h3>Modo de Preparación</h3>
                <p><?php echo nl2br(htmlspecialchars($receta['preparacion'])); ?></p>
                
                <?php if (!empty($receta['video'])): ?>
                    <h3>Video de Preparación</h3>
                    <video controls>
                        <source src="assets/videos/<?php echo $receta['video']; ?>" type="video/mp4">
                        Tu navegador no soporta el elemento de video.
                    </video>
                <?php endif; ?>
            </div>
            <a href="recetas.php" class="btn-primary">Volver a Recetas</a>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
    </footer>
</body>
</html>
