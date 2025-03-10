<?php
// Inclusion du fichier d'initialisation de la connexion PDO
require_once("initPDO.php");

try {
    // Préparation et exécution de la requête
    $request = $pdo->prepare("SELECT * FROM users");
    $request->execute();

    // Affichage des résultats sous forme de tableau HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th></tr>";

    while ($row = $request->fetch(PDO::FETCH_OBJ)) {
        echo "<tr>";
        echo "<td>{$row->id}</td>";
        echo "<td>{$row->name}</td>";
        echo "<td>{$row->email}</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermeture de la connexion
$pdo = null;
?>
