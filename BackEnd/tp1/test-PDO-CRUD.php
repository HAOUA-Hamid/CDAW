<?php
// Inclusion du fichier d'initialisation PDO
require_once("initPDO.php");

class User {
    public int $id;
    public string $name;
    public string $email;

    public function __construct() {
        $this->id = 0;
        $this->name = "Unknown";
        $this->email = "unknown@example.com";
    }

    // Récupérer tous les utilisateurs
    public static function getAllUsers(PDO $pdo): array {
        $request = $pdo->prepare("SELECT * FROM users");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
    }

    // Ajouter un nouvel utilisateur
    public static function addUser(PDO $pdo, string $name, string $email): void {
        $request = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $request->execute(['name' => $name, 'email' => $email]);
    }

    // Modifier un utilisateur
    public static function updateUser(PDO $pdo, int $id, string $name, string $email): void {
        $request = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $request->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    // Supprimer un utilisateur
    public static function deleteUser(PDO $pdo, int $id): void {
        $request = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $request->execute(['id' => $id]);
    }

    // Afficher les utilisateurs sous forme de tableau HTML avec options de modification/suppression
    public static function showAllUsersAsTable(PDO $pdo): void {
        $users = self::getAllUsers($pdo);
        echo "<h1>Users</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";
        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user->id}</td>
                    <td>{$user->name}</td>
                    <td>{$user->email}</td>
                    <td>
                        <a href='test-PDO-CRUD.php?edit={$user->id}'>Modifier</a> |
                        <a href='test-PDO-CRUD.php?delete={$user->id}' onclick='return confirm(\"Supprimer cet utilisateur ?\")'>Supprimer</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
}

// Gérer les actions (ajout, mise à jour, suppression)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["name"]) && !empty($_POST["email"])) {
        if (!empty($_POST["id"])) {
            User::updateUser($pdo, (int)$_POST["id"], $_POST["name"], $_POST["email"]);
        } else {
            User::addUser($pdo, $_POST["name"], $_POST["email"]);
        }
        header("Location: test-PDO-CRUD.php");
        exit();
    }
} elseif (isset($_GET["delete"])) {
    User::deleteUser($pdo, (int)$_GET["delete"]);
    header("Location: test-PDO-CRUD.php");
    exit();
}

// Affichage du tableau des utilisateurs
User::showAllUsersAsTable($pdo);

// Affichage du formulaire d'ajout/modification
$name = $email = "";
$id = isset($_GET["edit"]) ? (int)$_GET["edit"] : 0;
if ($id) {
    $user = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $user->execute(['id' => $id]);
    $user = $user->fetch(PDO::FETCH_OBJ);
    $name = $user->name;
    $email = $user->email;
}

?>

<h2><?php echo $id ? "Modifier un utilisateur" : "Ajouter un utilisateur"; ?></h2>
<form method="post" action="test-PDO-CRUD.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    <br>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    <br>
    <button type="submit"><?php echo $id ? "Modifier" : "Ajouter"; ?></button>
</form>

<?php
// Fermeture de la connexion
$pdo = null;
?>
