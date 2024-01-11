<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbname = "IOTMeteo";
$user = "postgres";
$password = "Paddy2002";

// Connexion à la base de données
try {
    $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Vérifier la connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}


 if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Nouvelle partie pour la moyenne par jour de la semaine
    $currentDate = date("Y-m-d"); // Date actuelle
    $dayOfWeek = date("N", strtotime($currentDate)); // Jour de la semaine (1 pour lundi, 2 pour mardi, etc.)

    // Calculer la date du lundi de la semaine en cours
    $mondayDate = date("Y-m-d", strtotime($currentDate . " - " . ($dayOfWeek - 1) . " days"));

    // Récupérer les valeurs moyennes par jour de la semaine
    $sqlSelectByDay = 'SELECT 
                        EXTRACT(ISODOW FROM Date) as day_of_week,
                        AVG(température) as températureMoyenne,
                        AVG(humidité) as humiditéMoyenne,
                        AVG(patmosphérique) as pressionMoyenne
                    FROM readings
                    WHERE Date >= CURRENT_DATE - EXTRACT(ISODOW FROM CURRENT_DATE)::integer + 1
                    GROUP BY day_of_week
                    ORDER BY day_of_week';

$stmtSelectByDay = $bdd->prepare($sqlSelectByDay);

try {
    $stmtSelectByDay->execute();
    $valuesByDay = $stmtSelectByDay->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($valuesByDay)) {
        echo '<h2>Moyennes par jour pour la semaine en cours :</h2>';

        foreach ($valuesByDay as $value) {
            $dayOfWeek = $value['day_of_week'];
            $températureMoyenne = $value['températureMoyenne'];
            $humiditéMoyenne = $value['humiditéMoyenne'];
            $pressionMoyenne = $value['pressionMoyenne'];

            echo '<h3>Jour ' . $dayOfWeek . ' :</h3>';
            echo '<p>température : ' . $températureMoyenne . '</p>';
            echo '<p>humidité : ' . $humiditéMoyenne . '</p>';
            echo '<p>pression : ' . $pressionMoyenne . '</p>';

            echo '<script>';
            echo 'const températureMoyenne' . $dayOfWeek . ' = ' . json_encode($températureMoyenne) . ';';
            echo 'const humiditéMoyenne' . $dayOfWeek . ' = ' . json_encode($humiditéMoyenne) . ';';
            echo 'const pressionMoyenne' . $dayOfWeek . ' = ' . json_encode($pressionMoyenne) . ';';
            echo '</script>';
        }
    } else {
        echo "Aucune valeur trouvée pour la semaine en cours.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
}}

?>
