<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbname = "Matching";
$user = "postgres";
$password = "Vemer";


try {
    $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creation des 3 tables
    $sqlCreateUtilisateurTable = '
    CREATE TABLE IF NOT EXISTS utilisateur (
        idutilisateur INT PRIMARY KEY,
        Email VARCHAR(255) UNIQUE NOT NULL,
        Email VARCHAR(255) UNIQUE NOT NULL,
        mdp VARCHAR(25),
        ville VARCHAR(50),
        date_de_naissance DATE
    );
    ';

    $sqlCreateSondeTable = '
    CREATE TABLE IF NOT EXISTS sonde (
        idsonde INT PRIMARY KEY,
        Disponibilité BOOLEAN,
        adresse_ip VARCHAR(255) UNIQUE,
        lieu VARCHAR(255)
    );
    ';

    $sqlCreateReadingsTable = '
    CREATE TABLE IF NOT EXISTS readings (
        idreadings SERIAL PRIMARY KEY,
        temperature DECIMAL(5,2),
        humidité DECIMAL(5,2),
        atmo DECIMAL(5,2),
        Date_et_heure TIMESTAMP,
        idsonde INT,
        FOREIGN KEY (idsonde) REFERENCES sonde(idsonde)
    );
    ';

    try {
        $bdd->exec($sqlCreateUtilisateurTable);
        $bdd->exec($sqlCreateSondeTable);
        $bdd->exec($sqlCreateReadingsTable);
        echo "Tables créées avec succès ou déjà existantes.";
    } catch (PDOException $e) {
        echo "Erreur lors de la création des tables : " . $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temperature = $_POST['temperature'];
        $humidite = $_POST['humidite'];
        $atmo = $_POST['atmo'];
        $date_et_heure = $_POST['date_et_heure'];
        $idsonde = $_POST['idsonde'];


        if (isset($temperature, $humidite, $atmo, $date_et_heure, $idsonde)) {
            // Préparer la requête SQL
            $sqlInsertReadings = 'INSERT INTO "readings" ("temperature", "humidité", "atmo", "Date_et_heure", "idsonde") VALUES (:temperature, :humidite, :atmo, :date_et_heure, :idsonde)';

            $stmt = $bdd->prepare($sqlInsertReadings);
            $stmt->bindParam(':temperature', $temperature);
            $stmt->bindParam(':humidite', $humidite);
            $stmt->bindParam(':atmo', $atmo);
            $stmt->bindParam(':date_et_heure', $date_et_heure);
            $stmt->bindParam(':idsonde', $idsonde);

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
} catch (PDOException $e) { // Vérifier la connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
