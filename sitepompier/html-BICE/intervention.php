<?php
include("index.html");
//pour se connecter a la BDD on va utilisé PDO
//PHP Data Object
//je crée un objet PDO
include "config.php";
$pdo = new PDO("mysql:host=" . config::SERVEUR . ";dbname=" . config::BDD, config::UTILISATEUR, config::MOTDEPASSE);
//je prépare une requete SQL
$requete = $pdo->prepare("select * from intervention");
//execute ma requete
$requete->execute();
//recuperation des lignes
$lignes = $requete->fetchAll();

//afichage en debug du contenu d'une variable
//jamais en PROD dans une appli !
//var_dump($lignes);

// Exécuter une requête UPDATE pour mettre à jour les données d'une intervention existante
$sql = "UPDATE intervention SET nom='Intervention mise à jour' WHERE id_intervention=1";

if ($conn->query($sql) === TRUE) {
    echo "Intervention mise à jour avec succès";
} else {
    echo "Erreur lors de la mise à jour: " . $conn->error;
}
$conn->close();


