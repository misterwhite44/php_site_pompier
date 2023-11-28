<?php

include "../config.php";

$id = filter_input(INPUT_GET,"id");

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("DELETE FROM vehicule where id=:id");

$requete->bindParam(":id",$id);

$requete->execute();

header("location:../gestion_vehicule.php");