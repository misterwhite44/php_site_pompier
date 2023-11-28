<?php


include "../config.php";

$nom = filter_input(INPUT_POST, "nom");
$date = filter_input(INPUT_POST, "date");
$lieu = filter_input(INPUT_POST,"lieu");

$pdo = new PDO("mysql:host=" . config::SERVEUR . ";dbname=" . config::BDD, config::UTILISATEUR, config::MOTDEPASSE);

$requete = $pdo->prepare("INSERT INTO intervention (nom,date,lieu) values (:nom,:date,:lieu)");

$requete->bindParam(":nom", $nom);
$requete->bindParam(":date", $date);
$requete->bindParam(":lieu",$lieu);

$requete->execute();

header("location:../rtr_intervention.php");