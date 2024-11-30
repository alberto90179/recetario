<?php
session_start();
include 'db.php'; // Conexión a la base de datos
$loggedIn = isset($_SESSION['usuario_id']);

// Consulta para obtener las 3 recetas más recientes
$stmt = $pdo->query("SELECT * FROM recetas ORDER BY id DESC LIMIT 3");
$recetasDestacadas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario Culinario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="header">
        <h1>🍴 Bienvenido al Recetario Culinario 🍴</h1>
        <nav>
            <ul class="nav">
                <li><a href="index.php">Inicio</a></li>
                <?php if ($loggedIn): ?>
                    <li><a href="recetas.php">Ver Recetas</a></li>
                    <li><a href="add_receta.php">Agregar Receta</a></li>
                    <li><a href="logout.php" class="btn-logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
                    <li><a href="register.php" class="btn-register">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="intro">
            <h2>🌟 ¿Qué encontrarás aquí? 🌟</h2>
            <p>Descubre recetas deliciosas, comparte tus creaciones culinarias y guarda tus favoritos. ¡Comienza tu aventura en la cocina hoy mismo!</p>
        </section>
        <section class="featured">
            <h2>Recetas Destacadas</h2>
            <div class="recetas">   
                <?php foreach ($recetasDestacadas as $receta): ?>
                    <article class="receta-card">
                        <img src="assets/uploads/<?php echo $receta['imagen']; ?>" alt="<?php echo htmlspecialchars($receta['titulo']); ?>">
                        <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                        <a href="receta.php?id=<?php echo $receta['id']; ?>" class="btn-primary">Ver receta</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Recetario Culinario. 🍽️ Todos los derechos reservados.</p>
    </footer>
</body>
</html>
