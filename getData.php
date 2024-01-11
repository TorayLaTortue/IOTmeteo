<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $host = "localhost";
        $dbname = "IOTMeteo";
        $user = "postgres";
        $password = "postgres";
        

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
        // Récupérer les 5 dernières valeurs de chaque type depuis la table readings
        $sqlSelectReadings = 'SELECT température, humidité, patmosphérique FROM Readings ORDER BY idreadings DESC LIMIT 5';
        $stmtSelect = $bdd->prepare($sqlSelectReadings);
        $stmtSelect->execute();
        $readings = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

        // Afficher la moyenne dans votre page HTML
        $températureMoyenne = array_sum(array_column($readings, 'température')) / count($readings);
        $humiditéMoyenne = array_sum(array_column($readings, 'humidité')) / count($readings);
        $patmosphériqueMoyenne = array_sum(array_column($readings, 'patmosphérique')) / count($readings);

        echo '<h2>Moyenne des 5 dernières valeurs :</h2>';
        echo '<p>température : ' . $températureMoyenne . '</p>';
        echo '<p>humidité : ' . $humiditéMoyenne . '</p>';
        echo '<p>patmosphérique : ' . $patmosphériqueMoyenne . '</p>';

        // Ajoutez des messages de débogage pour vérifier les données
        echo '<pre>';
        print_r($readings);
        echo '</pre>';

        // Transmettre les données au script JavaScript
        echo '<script>';
        echo 'const readingsData = ' . json_encode($readings) . ';';
        echo '</script>';
    }
 
?>