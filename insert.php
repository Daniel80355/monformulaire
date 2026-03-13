<?php
// Force JSON response
header('Content-Type: application/json; charset=utf-8');

// Debug logging
error_log("DEBUG - REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);
error_log("DEBUG - POST data: " . print_r($_POST, true));

include 'conn_BD.php';

// Check if form data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['Nom'], $_POST['postnom'], $_POST['promotion'], $_POST['email'])) {
    die(json_encode(['status' => 'error', 'message' => 'Données manquantes']));
}

// Get and sanitize data
$nom = trim($_POST['Nom']);
$postnom = trim($_POST['postnom']);
$promotion = trim($_POST['promotion']);
$email = trim($_POST['email']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die(json_encode(['status' => 'error', 'message' => 'Email invalide']));
}

// Use prepared statement to prevent SQL injection
try {
    $stmt = $conn->prepare("INSERT INTO etudiant (Nom, postnom, promotion, email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $postnom, $promotion, $email]);
    echo json_encode(['status' => 'success', 'message' => 'Nouvel enregistrement créé avec succès']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>