<!--http://127.0.0.1/Station%20m%c3%a9t%c3%a9o/IOTmeteo/login.php -->
<?php
session_start();

$host = "localhost";
// $dbname = "iotmeteo";
$dbname = "IOTMeteo";
$user = "postgres";
// $password = "damiens";
$password = "Paddy2002";

try {
    $bdd = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

$error_message = "";

// Logique de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email_utilisateur = $_POST["email_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $query = "SELECT idutilisateur, email_utilisateur, mot_de_passe FROM utilisateurs WHERE email_utilisateur = :email_utilisateur";
    $statement = $bdd->prepare($query);
    $statement->bindParam(":email_utilisateur", $email_utilisateur, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result && $mot_de_passe === $result['mot_de_passe']) {
        $_SESSION['idutilisateur'] = $result['idutilisateur'];
        $_SESSION['email_utilisateur'] = $result['email_utilisateur'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "E-mail ou mot de passe incorrect.";
    }
    
}


// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    $email = $_POST["email_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $ville = $_POST["ville_utilisateur"];
    $prenom = $_POST["prenom_utilisateur"];

    $query = "SELECT COUNT(*) FROM utilisateurs WHERE email_utilisateur = :email";
    $count = $bdd->prepare($query);
    $count->bindParam(":email", $email, PDO::PARAM_STR);
    $count->execute();

    if ($count->fetchColumn() > 0) {
        $error_message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $insert_query = "INSERT INTO utilisateurs (email_utilisateur, mot_de_passe, ville_utilisateur, prenom_utilisateur) 
        VALUES (:email, :mot_de_passe, :ville, :prenom)";

        $insert_stmt = $bdd->prepare($insert_query);
        
        $insert_stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $insert_stmt->bindParam(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
        $insert_stmt->bindParam(":ville", $ville, PDO::PARAM_STR);
        $insert_stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);

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

        <form method="post" action="login.php">
            <label for="email_utilisateur">Email:</label>
            <input type="text" name="email_utilisateur" id="email_utilisateur" required>

            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <input type="submit" name="login" value="Se connecter">
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
            <label for="email_utilisateur">Email :</label>
            <input type="email" id="email_utilisateur" name="email_utilisateur" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            
            <label for="ville_utilisateur">Ville :</label>
            <input type="text" id="ville_utilisateur" name="ville_utilisateur" required>
            
            <label for="prenom_utilisateur">Prénom :</label>
            <input type="text" id="prenom_utilisateur" name="prenom_utilisateur" required>
            
            <button type="submit" name="inscription">S'inscrire</button>
        </form>

    </div>
</div>

    <script src="script.js"></script>
</body>
</html>