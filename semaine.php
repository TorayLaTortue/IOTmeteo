<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Paris');

    $host = "localhost";
    $dbname = "iotmeteo";
    $user = "damien";
    $password = "damien";

    try {
        $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Échec de la connexion à la base de données : " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Sélectionner les données pour la semaine en cours
        $sqlSelectData = 'SELECT température, humidité, patmosphérique, DATE_PART(\'dow\', "date") AS day_of_week, "date" FROM readings WHERE "date" >= :startOfWeek AND "date" <= :endOfWeek ORDER BY "date", heure';
        
        $startOfWeek = date('Y-m-d', strtotime('last Monday'));
        $endOfWeek = date('Y-m-d', strtotime('next Sunday'));

        $stmtSelectData = $bdd->prepare($sqlSelectData);
        $stmtSelectData->bindParam(':startOfWeek', $startOfWeek);
        $stmtSelectData->bindParam(':endOfWeek', $endOfWeek);
        $stmtSelectData->execute();
        $data = $stmtSelectData->fetchAll(PDO::FETCH_ASSOC);

        // Initialiser des tableaux pour stocker les moyennes par jour de la semaine
        $dailyAveragesTemperature = [];
        $dailyAveragesHumidite = [];
        $dailyAveragesPression = [];
        $dates = [];

        // Pour chaque jour de la semaine, récupérer les données et calculer la moyenne
        foreach ($data as $entry) {
            // Récupérer le jour de la semaine et la date
            $day = intval($entry['day_of_week']);
            $date = $entry['date'];

            // Filtrer les données pour le jour spécifique
            $filteredData = array_filter($data, function($e) use ($day, $date) {
                return intval($e['day_of_week']) == $day
                    && $e['date'] == $date
                    && is_numeric($e['température'])
                    && is_numeric($e['humidité'])
                    && is_numeric($e['patmosphérique']);
            });

            // Calculer les moyennes
            $temperatureMoyenne = count($filteredData) > 0 ? array_sum(array_column($filteredData, 'température')) / count($filteredData) : 0;
            $humiditeMoyenne = count($filteredData) > 0 ? array_sum(array_column($filteredData, 'humidité')) / count($filteredData) : 0;
            $pressionMoyenne = count($filteredData) > 0 ? array_sum(array_column($filteredData, 'patmosphérique')) / count($filteredData) : 0;

            // Ajouter les moyennes au tableau avec la date correspondante
            $dailyAveragesTemperature[$date] = $temperatureMoyenne;
            $dailyAveragesHumidite[$date] = $humiditeMoyenne;
            $dailyAveragesPression[$date] = $pressionMoyenne;
           
        }

        // Encoder les tableaux en JSON
        $jsonDailyAveragesTemperature = json_encode($dailyAveragesTemperature);
        $jsonDailyAveragesHumidite = json_encode($dailyAveragesHumidite);
        $jsonDailyAveragesPression = json_encode($dailyAveragesPression);

        // Fermer la connexion à la base de données
        $bdd = null;

        // Retourner les données JSON
        echo json_encode([
            'dates' => $dates,
            'temperatureWeek' => $jsonDailyAveragesTemperature,
            'humiditeWeek' => $jsonDailyAveragesHumidite,
            'pressionWeek' => $jsonDailyAveragesPression,
        ]);
    }
?>
