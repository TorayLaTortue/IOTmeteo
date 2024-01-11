<?php
// Connectez-vous à votre base de données et exécutez la requête pour obtenir les données
$pdo = new PDO('mysql:host=your_host;dbname=your_database', 'your_username', 'your_password');
$stmt = $pdo->prepare("SELECT temperature FROM temperature_data");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Renvoyer les données au format JSON
echo json_encode($data);
?>
