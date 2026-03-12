<?php
// Configuration connexion base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$basededonnes = "basededonnes";

// Créer la connexion
$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnes);

// Vérifier la connexion
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connexion échouée: ' . $conn->connect_error]));
}

// Définir le charset UTF-8
$conn->set_charset("utf8");
?>
