<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $host = "localhost";
        $dbname = "Matching";
        $user = "postgres";
        $password = "Vemer";
        

        // Connexion à la base de données
        try{
        $bdd = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
        catch(PDOException $e){// Vérifier la connexion
        die("Échec de la connexion à la base de données : " . $e->getMessage());}

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //recuperer les donnée du python pour ensuite les mettres dans la bdd
        $sqlInsertSonde = 'INSERT INTO "Readings" ("Température", "Humidité", "PAtmosphérique", "Date", "Heure") VALUES (:Température, :Humidité, :PAtmosphérique, :Date, :Heure)'
    }

    else {
        echo "Aucune donnée n'a été soumise.";
    }