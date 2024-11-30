<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar que la receta pertenece al usuario logueado antes de eliminar
    $stmt = $pdo->prepare("DELETE FROM recetas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $usuario_id]);

    header("Location: recetas.php");
    exit;
}
?>
