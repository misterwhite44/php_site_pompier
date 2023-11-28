<?php

include "../config.php";

$id = filter_input(INPUT_POST,"id");
$nom = filter_input(INPUT_POST,"nom_vehicule");
$immatriculation = filter_input(INPUT_POST,"immatriculation");

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("UPDATE vehicule SET nom=:nom, immatriculation=:immatriculation where id=:id ");

$requete->bindParam(":id",$id);
$requete->bindParam(":nom",$nom);
$requete->bindParam(":immatriculation",$immatriculation);

$requete->execute();

header("location:../gestion_vehicule.php");