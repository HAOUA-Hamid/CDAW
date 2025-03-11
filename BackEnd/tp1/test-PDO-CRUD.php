<?php
require_once("initPDO.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<?php
class User {
    public int $id;
    public string $name;
    public string $email;

    public function __construct() {
        $this->id = 0;
        $this->name = "Unknown";
        $this->email = "unknown@example.com";
    }

    public static function getAllUsers(PDO $pdo): array {
        $request = $pdo->prepare("SELECT * FROM users");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
    }

    public static function addUser(PDO $pdo, string $name, string $email): void {
        $request = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $request->execute(['name' => $name, 'email' => $email]);
    }

    public static function updateUser(PDO $pdo, int $id, string $name, string $email): void {
        $request = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $request->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    public static function deleteUser(PDO $pdo, int $id): void {
        $request = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $request->execute(['id' => $id]);
    }

    public static function showAllUsersAsTable(PDO $pdo): void {
        $users = self::getAllUsers($pdo);
        echo "<h1 class='mb-4'>Utilisateurs</h1>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-dark'><tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr></thead><tbody>";
        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user->id}</td>
                    <td>{$user->name}</td>
                    <td>{$user->email}</td>
                    <td>
                        <div class='text-center'>
                            <a href='test-PDO-CRUD.php?edit={$user->id}' class='btn btn-warning btn-sm'>Modifier</a>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <a href='test-PDO-CRUD.php?delete={$user->id}' class='btn btn-danger btn-sm' onclick='return confirm(\"Supprimer cet utilisateur ?\")'>Supprimer</a>
                        </div>

                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    }
}

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

User::showAllUsersAsTable($pdo);

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

<h2 class="mt-5"> <?php echo $id ? "Modifier un utilisateur" : "Ajouter un utilisateur"; ?> </h2>
<form method="post" action="test-PDO-CRUD.php" class="mt-3 p-4 border rounded shadow-sm bg-light">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nom :</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary"> <?php echo $id ? "Modifier" : "Ajouter"; ?> </button>
</form>
<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
