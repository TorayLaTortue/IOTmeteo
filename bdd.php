<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$host = "localhost";
$dbname = "Matching";
$user = "postgres";
$password = "Vemer";


// Connexion à la base de données
try {
    $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { // Vérifier la connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données de la requête POST
    $temperature = $_POST['temperature'];  // Remplacez 'temperature' par le nom de la variable envoyée depuis votre Raspberry Pi
    $humidite = $_POST['humidite'];        // Remplacez 'humidite' par le nom de la variable envoyée depuis votre Raspberry Pi
    $p_atmospherique = $_POST['p_atmospherique']; // Remplacez 'p_atmospherique' par le nom de la variable envoyée depuis votre Raspberry Pi
    $date = $_POST['date'];                // Remplacez 'date' par le nom de la variable envoyée depuis votre Raspberry Pi
    $heure = $_POST['heure'];              // Remplacez 'heure' par le nom de la variable envoyée depuis votre Raspberry Pi

    // Vérifier si toutes les données nécessaires ont été fournies
    if (isset($temperature, $humidite, $p_atmospherique, $date, $heure)) {
        // Préparer la requête SQL
        $sqlInsertSonde = 'INSERT INTO "Readings" ("Température", "Humidité", "PAtmosphérique", "Date", "Heure") VALUES (:temperature, :humidite, :p_atmospherique, :date, :heure)';

        // Préparer et exécuter la requête
        $stmt = $bdd->prepare($sqlInsertSonde);
        $stmt->bindParam(':temperature', $temperature);
        $stmt->bindParam(':humidite', $humidite);
        $stmt->bindParam(':p_atmospherique', $p_atmospherique);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':heure', $heure);

        try {
            $stmt->execute();
            echo "Données insérées avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion des données : " . $e->getMessage();
        }
    } else {
        echo "Certaines données sont manquantes.";
    }
} else {
    echo "Aucune donnée n'a été soumise.";
}
?>