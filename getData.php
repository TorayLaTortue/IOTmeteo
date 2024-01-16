<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // Définir le fuseau horaire à "Europe/Paris"
        date_default_timezone_set('Europe/Paris');

        
        $host = "localhost";
        // $dbname = "iotmeteo";
        $dbname = "iotmeteo";
        $user = "damien";
        // $password = "damiens";
        $password = "damien";
        

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

        if (isset($température, $humidité, $patmosphérique, $date, $heure)) {
            // Préparer la requête SQL
            $sqlInsertReadings = 'INSERT INTO Readings (température, humidité, patmosphérique, Date, Heure) VALUES (:température, :humidité, :patmosphérique, :date, :heure)';

            $stmt = $bdd->prepare($sqlInsertReadings);
            $stmt->bindParam(':température', $température);
            $stmt->bindParam(':humidité', $humidité);
            $stmt->bindParam(':patmosphérique', $patmosphérique);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':Heure', $heure);
            

            try {
                $stmt->execute();
                echo "Données insérées avec succès.";
            } catch (PDOException $e) {
                echo "Erreur lors de l'insertion des données : " . $e->getMessage();
            }
        } else {
            echo "Certaines données sont manquantes.";
        }
    } 
        
        elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            $currentDate = date('Y-m-d');

    // Sélectionner les heures distinctes pour la journée en cours
    $sqlSelectDistinctHours = 'SELECT DISTINCT heure FROM readings WHERE Date = :currentDate ORDER BY heure';
    $stmtSelectDistinctHours = $bdd->prepare($sqlSelectDistinctHours);
    $stmtSelectDistinctHours->bindParam(':currentDate', $currentDate);
    $stmtSelectDistinctHours->execute();
    $distinctHours = $stmtSelectDistinctHours->fetchAll(PDO::FETCH_COLUMN);

    // Initialiser des tableaux pour stocker les moyennes par heure
    $hourlyAveragesTemperature = [];
    $hourlyAveragesHumidite = [];
    $hourlyAveragesPression = [];

    // Pour chaque heure distincte, récupérer les données et calculer la moyenne
    foreach ($distinctHours as $hour) {
        // Sélectionner les données pour l'heure spécifiée
        $sqlSelectData = 'SELECT température, humidité, patmosphérique FROM readings WHERE Date = :currentDate AND heure = :hour ';
        $stmtSelectData = $bdd->prepare($sqlSelectData);
        $stmtSelectData->bindParam(':currentDate', $currentDate);
        $stmtSelectData->bindParam(':hour', $hour);
        $stmtSelectData->execute();
        $data = $stmtSelectData->fetchAll(PDO::FETCH_ASSOC);

        // Calculer les moyennes
        $temperatureMoyenne = count($data) > 0 ? array_sum(array_column($data, 'température')) / count($data) : 0;
        $humiditeMoyenne = count($data) > 0 ? array_sum(array_column($data, 'humidité')) / count($data) : 0;
        $pressionMoyenne = count($data) > 0 ? array_sum(array_column($data, 'patmosphérique')) / count($data) : 0;

        // Ajouter les moyennes au tableau avec l'heure correspondante
        $hourlyAveragesTemperature[$hour] = $temperatureMoyenne;
        $hourlyAveragesHumidite[$hour] = $humiditeMoyenne;
        $hourlyAveragesPression[$hour] = $pressionMoyenne;
    }

    // Encoder les tableaux en JSON
    $jsonHourlyAveragesTemperature = json_encode($hourlyAveragesTemperature);
    $jsonHourlyAveragesHumidite = json_encode($hourlyAveragesHumidite);
    $jsonHourlyAveragesPression = json_encode($hourlyAveragesPression);

    // Afficher les données JavaScript
    echo '<script>';
    echo 'const labels = ' . json_encode($distinctHours) . ';';
    echo 'const datasetsTemperature = [{';
    echo '    label: "Température",';
    echo '    data: ' . $jsonHourlyAveragesTemperature . ',';
    echo '    fill: false,';
    echo '    backgroundColor: "red",';
    echo '    tension: 0.4';
    echo '}];';

    echo 'const datasetsHumidite = [{';
    echo '    label: "Humidité",';
    echo '    data: ' . $jsonHourlyAveragesHumidite . ',';
    echo '    fill: false,';
    echo '    backgroundColor: "turquoise",';
    echo '    tension: 0.4';
    echo '}];';

    echo 'const datasetsPression = [{';
    echo '    label: "Pression",';
    echo '    data: ' . $jsonHourlyAveragesPression . ',';
    echo '    fill: false,';
    echo '    backgroundColor: "grey",';
    echo '    tension: 0.4';
    echo '}];';
    echo '</script>';

    // echo 'console.log("Labels (PHP):", ' . json_encode($distinctHours) . ');';
    // echo 'console.log("Datasets Temperature (PHP):", ' . json_encode($hourlyAveragesTemperature) . ');';
    // echo 'console.log("Datasets Humidite (PHP):", ' . json_encode($hourlyAveragesHumidite) . ');';
    // echo 'console.log("Datasets Pression (PHP):", ' . json_encode($hourlyAveragesPression) . ');';
}
?>

    