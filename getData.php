<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // Définir le fuseau horaire à "Europe/Paris"
        date_default_timezone_set('Europe/Paris');


// URL de l'API Flask
$api_url = 'http://10.191.14.113:5000/readings';

// Appel à l'API en utilisant file_get_contents avec le contexte configuré
$response = file_get_contents($api_url);

// Vérification des erreurs
if ($response === FALSE) {
    die('Erreur lors de la requête à l\'API');
}

// Traitement de la réponse (par exemple, conversion du JSON en tableau associatif)
$data = json_decode($response, true);

// Utilisation des données


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $currentDate = date('Y-m-d');

    // Traitement des données pour obtenir les moyennes par heure
    // Vous devez adapter cela selon la structure réelle des données renvoyées par l'API
    $distinctHours = array_unique(array_column($data, 'heure'));

    $hourlyAveragesTemperature = [];
    $hourlyAveragesHumidite = [];
    $hourlyAveragesPression = [];

    foreach ($distinctHours as $hour) {
        $hourData = array_filter($data, function ($item) use ($currentDate, $hour) {
            return $item['date'] == $currentDate && $item['heure'] == $hour;
        });

        $temperatureMoyenne = count($hourData) > 0 ? array_sum(array_column($hourData, 'température')) / count($hourData) : 0;
        $humiditeMoyenne = count($hourData) > 0 ? array_sum(array_column($hourData, 'humidité')) / count($hourData) : 0;
        $pressionMoyenne = count($hourData) > 0 ? array_sum(array_column($hourData, 'patmosphérique')) / count($hourData) : 0;

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
}
?>