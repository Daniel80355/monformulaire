<?php
// Configuration connexion base de données avec PDO
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=basededonnes;charset=utf8mb4";
    $conn = new PDO($dsn, "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Connexion échouée: ' . $e->getMessage()]));
}
?>
