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
            <img src="assets/uploads/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="<?php echo htmlspecialchars($receta['titulo']); ?>" class="receta-img">
            <div class="detalles">
                <h3>Ingredientes</h3>
                <p><?php echo nl2br(htmlspecialchars($receta['ingredientes'])); ?></p>
                
                <h3>Modo de Preparación</h3>
                <p><?php echo nl2br(htmlspecialchars($receta['preparacion'])); ?></p>
                
                <?php if (!empty($receta['video_link'])): ?>
                    <h3>Video de Preparación</h3>
                    <?php
                    // Detecta si es un enlace de YouTube para insertar un iframe
                    if (strpos($receta['video_link'], 'youtube.com') !== false || strpos($receta['video_link'], 'youtu.be') !== false): 
                        // Convierte el enlace en un enlace embebido
                        $url_parts = parse_url($receta['video_link']);
                        $video_id = '';
                        if (strpos($url_parts['host'], 'youtube.com') !== false && isset($url_parts['query'])) {
                            parse_str($url_parts['query'], $query_params);
                            $video_id = $query_params['v'] ?? '';
                        } elseif (strpos($url_parts['host'], 'youtu.be') !== false) {
                            $video_id = trim($url_parts['path'], '/');
                        }
                    ?>
                        <iframe width="560" height="315" 
                                src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video_id); ?>" 
                                title="Video de preparación"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    <?php else: ?>
                        <p>
                            Mira el video en el siguiente enlace: 
                            <a href="<?php echo htmlspecialchars($receta['video_link']); ?>" target="_blank">
                                Ver Video
                            </a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <a href="recetas.php" class="btn-primary">Volver a Recetas</a>
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
