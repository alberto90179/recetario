<?php
$host = 'boiq9fysbo7esdtgzqy2-mysql.services.clever-cloud.com';
$dbname = 'boiq9fysbo7esdtgzqy2';
$username = 'ulcbjjt0e5xfc0l1';
$password = 'dRyRTvQtDQ9bRfDR560Y';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
