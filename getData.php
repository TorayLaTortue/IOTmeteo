<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $host = "localhost";
        $dbname = "iotmeteo";
        $user = "damien";
        $password = "damiens";
        

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
        $idrelevé = $_POST['idrelevé'];

        if (isset($température, $humidité, $patmosphérique, $date, $heure, $idrelevé)) {
            // Préparer la requête SQL
            $sqlInsertReadings = 'INSERT INTO Readings (température, humidité, patmosphérique, Date, Heure, idrelevé) VALUES (:température, :humidité, :patmosphérique, :date, :heure, :idrelevé)';

            $stmt = $bdd->prepare($sqlInsertReadings);
            $stmt->bindParam(':température', $température);
            $stmt->bindParam(':humidité', $humidité);
            $stmt->bindParam(':patmosphérique', $patmosphérique);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':heure', $heure);
            $stmt->bindParam(':idrelevé', $idrelevé);

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
$sqlSelectReadings = 'SELECT température FROM readings ORDER BY idrelevé DESC LIMIT 5';
$stmtSelect = $bdd->prepare($sqlSelectReadings);
$stmtSelect->execute();
$temperatures = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);

// Calculer la moyenne de la température
$températureMoyenne = array_sum($temperatures) / count($temperatures);

// Récupérer la moyenne de l'humidité des 5 dernières valeurs depuis la table readings
$sqlSelectHumidity = 'SELECT humidité FROM readings ORDER BY idrelevé DESC LIMIT 5';
$stmtSelectHumidity = $bdd->prepare($sqlSelectHumidity);
$stmtSelectHumidity->execute();
$humidities = $stmtSelectHumidity->fetchAll(PDO::FETCH_COLUMN);

// Calculer la moyenne de l'humidité
$humiditéMoyenne = array_sum($humidities) / count($humidities);

// Récupérer la moyenne de la pression des 5 dernières valeurs depuis la table readings
$sqlSelectpression = 'SELECT patmosphérique FROM readings ORDER BY idrelevé DESC LIMIT 5';
$stmtSelectpression = $bdd->prepare($sqlSelectpression); // Correction du nom de la variable
$stmtSelectpression->execute();
$pression = $stmtSelectpression->fetchAll(PDO::FETCH_COLUMN);

// Calculer la moyenne de la pression
$pressionMoyenne = array_sum($pression) / count($pression);

echo '<h2>Moyenne des 5 dernières valeurs :</h2>';
echo '<p>température : ' . $températureMoyenne . '</p>';
echo '<p>humidité : ' . $humiditéMoyenne . '</p>';
echo '<p>pression : ' . $pressionMoyenne . '</p>';

// Transmettre les données au script JavaScript
echo '<script>';
echo 'const températureMoyenne = ' . json_encode($températureMoyenne) . ';';
echo 'const humiditéMoyenne = ' . json_encode($humiditéMoyenne) . ';';
echo 'const pressionMoyenne = ' . json_encode($pressionMoyenne) . ';';
echo '</script>';
    }
?>