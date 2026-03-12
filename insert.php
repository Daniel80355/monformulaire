<?php
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
$stmt = $conn->prepare("INSERT INTO etudiant (Nom, postnom, promotion, email) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => 'Erreur de préparation: ' . $conn->error]));
}

// Bind parameters
$stmt->bind_param("ssss", $nom, $postnom, $promotion, $email);

// Execute query
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Nouvel enregistrement créé avec succès']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>