<?php
include 'db.php';
session_start();

// Verifica si el usuario está logueado, si no lo está redirige a login.php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos del formulario
    $titulo = $_POST['titulo'];
    $ingredientes = $_POST['ingredientes'];
    $preparacion = $_POST['preparacion'];
    $video_link = $_POST['video_link'];
    $imagen = $_FILES['imagen']['name'];
    $usuario_id = $_SESSION['usuario_id'];

    // Mueve la imagen cargada al directorio 'uploads'
    move_uploaded_file($_FILES['imagen']['tmp_name'], "assets/uploads/$imagen");

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
            <!-- El formulario envía los datos a esta misma página para procesarlos -->
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
                    <input type="text" name="video_link" id="video_link" placeholder="Enlace al video de preparación">
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
