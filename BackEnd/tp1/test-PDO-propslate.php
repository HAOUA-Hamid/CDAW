<?php
// Inclusion du fichier d'initialisation PDO
require_once("initPDO.php");

class User {
    public int $id;
    public string $name;
    public string $email;

    // Constructeur appelé en premier grâce à FETCH_PROPS_LATE
    public function __construct() {
        $this->id = 0;
        $this->name = "Unknown";
        $this->email = "unknown@example.com";
    }

    // Récupère tous les utilisateurs sous forme d'objets User
    public static function getAllUsers(PDO $pdo): array {
        $request = $pdo->prepare("SELECT * FROM users");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
    }

    // Affiche les utilisateurs sous forme de tableau HTML
    public static function showAllUsersAsTable(PDO $pdo): void {
        $users = self::getAllUsers($pdo);
        echo "<h1>Users</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        foreach ($users as $user) {
            echo $user->toHtml();
        }
        echo "</table>";
    }

    // Retourne les infos d'un utilisateur sous forme de ligne HTML
    public function toHtml(): string {
        return "<tr>
                    <td>{$this->id}</td>
                    <td>{$this->name}</td>
                    <td>{$this->email}</td>
                </tr>";
    }
}

// Affichage du tableau des utilisateurs
User::showAllUsersAsTable($pdo);

// Fermeture de la connexion
$pdo = null;
?>
