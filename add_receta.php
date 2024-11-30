<?php
session_start();
include 'db.php';

// Verifica si el usuario está logueado, si no lo está redirige a login.php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Procesa el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario y sanitiza la entrada
    $titulo = trim($_POST['titulo']);
    $ingredientes = trim($_POST['ingredientes']);
    $preparacion = trim($_POST['preparacion']);
    $video_link = trim($_POST['video_link']);
    $usuario_id = $_SESSION['usuario_id'];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = basename($_FILES['imagen']['name']);
        $target_path = "assets/uploads/$imagen";

        // Mueve la imagen cargada al directorio 'uploads'
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $target_path)) {
            die("Error al cargar la imagen.");
        }
    } else {
        die("Error en la carga de la imagen.");
    }

    // Inserta la receta en la base de datos
    $stmt = $pdo->prepare("INSERT INTO recetas (titulo, imagen, ingredientes, preparacion, video_link, usuario_id) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titulo, $imagen, $ingredientes, $preparacion, $video_link, $usuario_id]);

    // Redirige a la página de recetas
    header("Location: recetas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Receta</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Agregar Nueva Receta</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="recetas.php">Ver Recetas</a></li>
                <li><a href="logout.php" class="btn-logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="add-recipe">
            <h2>Completa el formulario</h2>
            <form method="POST" enctype="multipart/form-data" class="form-add-recipe">
                <div class="form-group">
                    <label for="titulo">Título de la receta</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Título de la receta" required>
                </div>
                
                <div class="form-group">
                    <label for="ingredientes">Ingredientes</label>
                    <textarea name="ingredientes" id="ingredientes" placeholder="Ingredientes" required></textarea>
                </div>

                <div class="form-group">
                    <label for="preparacion">Modo de preparación</label>
                    <textarea name="preparacion" id="preparacion" placeholder="Modo de preparación" required></textarea>
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen de la receta</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="video_link">Enlace al video de preparación (opcional)</label>
                    <input type="url" name="video_link" id="video_link" placeholder="Enlace al video de preparación">
                </div>

                <button type="submit" class="btn-primary">Agregar Receta</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
    </footer>
</body>
</html>