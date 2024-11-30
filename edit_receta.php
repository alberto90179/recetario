<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar que la receta pertenece al usuario logueado
    $stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $usuario_id]);
    $receta = $stmt->fetch();

    if (!$receta) {
        die("Receta no encontrada o no tienes permisos para editarla.");
    }
} else {
    die("ID de receta no proporcionado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $ingredientes = $_POST['ingredientes'];
    $preparacion = $_POST['preparacion'];
    $video = $_POST['video']; // Capturar el enlace del video

    // Actualizar receta en la base de datos
    $stmt = $pdo->prepare("UPDATE recetas SET titulo = ?, ingredientes = ?, preparacion = ?, video = ? WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$titulo, $ingredientes, $preparacion, $video, $id, $usuario_id]);

    header("Location: recetas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receta</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Editar Receta</h1>
    </header>
    <main>
        <form action="" method="POST">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($receta['titulo']); ?>" required>
            </div>
            <div>
                <label for="ingredientes">Ingredientes:</label>
                <textarea id="ingredientes" name="ingredientes" required><?php echo htmlspecialchars($receta['ingredientes']); ?></textarea>
            </div>
            <div>
                <label for="preparacion">Modo de preparación:</label>
                <textarea id="preparacion" name="preparacion" required><?php echo htmlspecialchars($receta['preparacion']); ?></textarea>
            </div>
            <div>
                <label for="video">Enlace al video (opcional):</label>
                <input type="url" id="video" name="video" value="<?php echo htmlspecialchars($receta['video']); ?>" placeholder="https://www.youtube.com/watch?v=..." pattern="https?://.+">
            </div>
            <button type="submit">Guardar Cambios</button>
            <a href="recetas.php">Cancelar</a>
        </form>
    </main>
</body>
</html>
