<?php
header('Content-Type: application/json; charset=utf-8');

// Test de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$basededonnes = "basededonnes";

echo "=== DIAGNOSTIC ===\n\n";

// Teste 1: Connexion simple
$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnes);
if ($conn->connect_error) {
    echo "❌ ERREUR CONNEXION: " . $conn->connect_error . "\n\n";
    echo "Solutions possibles:\n";
    echo "1. MySQL n'est pas en marche\n";
    echo "2. La base 'basededonnes' n'existe pas\n";
    echo "3. Les credentials (root, sans password) sont incorrects\n";
} else {
    echo "✓ Connexion OK\n";
    
    // Test 2: Vérifier la table
    $result = $conn->query("SHOW TABLES LIKE 'etudiant'");
    if ($result && $result->num_rows > 0) {
        echo "✓ Table 'etudiant' existe\n";
        
        // Test 3: Structure de la table
        $fields = $conn->query("DESCRIBE etudiant");
        echo "\nStructure de la table:\n";
        while ($row = $fields->fetch_assoc()) {
            echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
        }
    } else {
        echo "❌ Table 'etudiant' n'existe pas\n";
    }
}

$conn->close();
?>
