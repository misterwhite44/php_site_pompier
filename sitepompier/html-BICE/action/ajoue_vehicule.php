<?php

include "../config.php";

$nom = filter_input(INPUT_POST,"nom_vehicule");
$immatriculation = filter_input(INPUT_POST,"immatriculation");

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("INSERT INTO vehicule (nom,immatriculation) values (:nom,:immatriculation)");

$requete->bindParam(":nom",$nom);
$requete->bindParam(":immatriculation",$immatriculation);

$requete->execute();

header("location:../gestion_vehicule.php");