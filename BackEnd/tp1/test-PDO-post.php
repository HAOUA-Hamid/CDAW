<?php
require_once("initPDO.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["name"]) && !empty($_POST["email"])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);

    try {
        $insert = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $insert->bindParam(':name', $name);
        $insert->bindParam(':email', $email);
        $insert->execute();
        header("Location: test-PDO-post.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur d'insertion : " . $e->getMessage();
    }
}

try {
    $request = $pdo->prepare("SELECT * FROM users");
    $request->execute();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";

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

$pdo = null;
?>
<h2>Ajouter un utilisateur</h2>
<form method="post" action="test-PDO-post.php">
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" required> 
    <br>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>
    <br>
    <button type="submit">Ajouter</button>
</form>
