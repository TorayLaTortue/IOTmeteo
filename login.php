<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$host = "";
$dbname = "";
$user = "";
$password = "";

try {
    $bdd = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

$error_message = "";

// Logique de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $Email = $_POST["username"];
    $password = $_POST["password"];

    // Préparer et exécuter la requête SQL pour vérifier l'utilisateur
    $query = "SELECT * FROM Utilisateur WHERE email_utilisateur = :email";
    $statement = $bdd->prepare($query);
    $statement->bindParam(":email", $Email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['email_utilisateur'] = $user['email_utilisateur'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "E-mail ou mot de passe incorrect.";
    }
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    $nom = $_POST["nom_utilisateur"];
    $prenom = $_POST["prenom_utilisateur"];
    $email = $_POST["email_utilisateur"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);
    $ville = $_POST["ville_utilisateur"];

    // Vérification si l'email existe déjà
    $query = "SELECT COUNT(*) FROM Utilisateur WHERE email_utilisateur = :email";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error_message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Insertion de l'utilisateur dans la base de données
        $insert_query = "INSERT INTO Utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, mot_de_passe, ville_utilisateur) 
                         VALUES (:nom, :prenom, :email, :mot_de_passe, :ville)";
        $insert_stmt = $bdd->prepare($insert_query);
        $insert_stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
        $insert_stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $insert_stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $insert_stmt->bindParam(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
        $insert_stmt->bindParam(":ville", $ville, PDO::PARAM_STR);

        if ($insert_stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toobo - Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <h1>Toobo!</h1>
    <div class="container">
        <img src="TooboLogo.png" alt="LogoToobo" class="LogoToobo">
        <h2>Connexion</h2>
        <?php if (!empty($error_message)) { echo "<p>$error_message</p>"; } ?>
        <form action="login.php" method="post">
            <label for="username">Email :</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Se connecter</button>
        </form>
        <div class="signup-link">
    <p>Vous n'avez pas de compte ? <a href="#" id="modalBtnInscription">Inscrivez-vous ici</a></p>
</div>
<!-- Modal d'inscription -->
<div id="inscriptionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Inscription</h2>
        <form action="login.php" method="post">
            <label for="nom_utilisateur">Nom :</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

            <label for="prenom_utilisateur">Prénom :</label>
            <input type="text" id="prenom_utilisateur" name="prenom_utilisateur" required>

            <label for="email_utilisateur">Email :</label>
            <input type="email" id="email_utilisateur" name="email_utilisateur" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <label for="ville_utilisateur">Ville :</label>
            <input type="text" id="ville_utilisateur" name="ville_utilisateur" required>

            <button type="submit" name="inscription">S'inscrire</button>
        </form>
    </div>
</div>

    <script src="script.js"></script>
</body>
</html>