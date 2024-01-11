<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $host = "localhost";
        $dbname = "IOTMeteo";
        $user = "postgres";
        $password = "Paddy2002";
        

        // Connexion à la base de données
        try{
        $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
        catch(PDOException $e){// Vérifier la connexion
        die("Échec de la connexion à la base de données : " . $e->getMessage());}

    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $température = $_POST['température'];
        $humidité = $_POST['humidité'];
        $patmosphérique = $_POST['patmosphérique'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $idsonde = $_POST['idsonde'];

        if (isset($température, $humidité, $patmosphérique, $date, $heure, $idsonde)) {
            // Préparer la requête SQL
            $sqlInsertReadings = 'INSERT INTO Readings (température, humidité, patmosphérique, Date, Heure, idsonde) VALUES (:température, :humidité, :patmosphérique, :date, :heure, :idsonde)';

            $stmt = $bdd->prepare($sqlInsertReadings);
            $stmt->bindParam(':température', $température);
            $stmt->bindParam(':humidité', $humidité);
            $stmt->bindParam(':patmosphérique', $patmosphérique);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':heure', $heure);
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
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
// Récupérer la moyenne de la température des 5 dernières valeurs depuis la table readings
$sqlSelectReadings = 'SELECT température FROM readings ORDER BY idsonde DESC LIMIT 5';
$stmtSelect = $bdd->prepare($sqlSelectReadings);
$stmtSelect->execute();
$temperatures = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);

// Calculer la moyenne de la température
$températureMoyenne = array_sum($temperatures) / count($temperatures);

echo '<h2>Moyenne des 5 dernières valeurs :</h2>';
echo '<p>température : ' . $températureMoyenne . '</p>';

// Transmettre les données au script JavaScript
echo '<script>';
echo 'const températureMoyenne = ' . json_encode($températureMoyenne) . ';';
echo '</script>';
    }
 
?>