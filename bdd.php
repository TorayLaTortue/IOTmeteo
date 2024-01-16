<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $host = "localhost";
        $dbname = "iotmeteo";
        $user = "damien";
        $password = "damien";
        

        // Connexion à la base de données
        try{
        $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
        catch(PDOException $e){// Vérifier la connexion
        die("Échec de la connexion à la base de données : " . $e->getMessage());}

    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temperature = $_POST['température'];
        $humidite = $_POST['humidité'];
        $pression = $_POST['patmosphérique'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        

        if (isset($temperature, $humidite, $pression, $date, $heure, $idsonde)) {
            // Préparer la requête SQL
            $sqlInsertReadings = 'INSERT INTO Readings (Temperature, Humidite, Pression, Date, Heure, idsonde) VALUES (:température, :humidité, :patmosphérique, :date, :heure)';

            $stmt = $bdd->prepare($sqlInsertReadings);
            $stmt->bindParam(':température', $temperature);
            $stmt->bindParam(':humidité', $humidite);
            $stmt->bindParam(':patmosphérique', $pression);
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
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Récupérer les 5 dernières valeurs de chaque type depuis la table readings
        $sqlSelectReadings = 'SELECT Temperature, Humidite, Pression FROM Readings ORDER BY idreadings DESC LIMIT 5';
        $stmtSelect = $bdd->prepare($sqlSelectReadings);
        $stmtSelect->execute();
        $readings = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

        // Afficher la moyenne dans votre page HTML
        $temperatureMoyenne = array_sum(array_column($readings, 'temperature')) / count($readings);
        $humiditeMoyenne = array_sum(array_column($readings, 'humidite')) / count($readings);
        $pressionMoyenne = array_sum(array_column($readings, 'pression')) / count($readings);

        echo '<h2>Moyenne des 5 dernières valeurs :</h2>';
        echo '<p>Température : ' . $temperatureMoyenne . '</p>';
        echo '<p>Humidité : ' . $humiditeMoyenne . '</p>';
        echo '<p>Pression : ' . $pressionMoyenne . '</p>';

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