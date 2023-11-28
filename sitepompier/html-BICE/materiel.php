<?php
include("actu_stock.html");
//pour se connecter a la BDD on va utilisé PDO
//PHP Data Object
//je crée un objet PDO
include "config.php";
$pdo = new PDO("mysql:host=" . config::SERVEUR . ";dbname=" . config::BDD, config::UTILISATEUR, config::MOTDEPASSE);
//je prépare une requete SQL
$requete = $pdo->prepare("select * from materiel");
//execute ma requete
$requete->execute();
//recuperation des lignes
$lignes = $requete->fetchAll();

//afichage en debug du contenu d'une variable
//jamais en PROD dans une appli !
//var_dump($lignes);

// Récupération de l'identifiant du matériel sélectionné
$id_materiel = $_GET['id'];

// Récupération des informations sur le matériel dans la base de données
$req = $pdo->prepare('SELECT * FROM materiel WHERE id = ?');
$req->execute(array($id_materiel));
$materiel = $req->fetch();

// Vérification des règles d'utilisation du matériel
if ($materiel['nbre_utilisation'] <= 0) {
    echo 'Ce matériel ne peut plus être utilisé';
} else if ($materiel['dlc'] < date('Y-m-d')) {
    echo 'Ce matériel est périmé et ne peut plus être utilisé';
} else if ($materiel['date_maintenance'] != null && $materiel['date_maintenance'] < date('Y-m-d')) {
    echo 'Ce matériel doit être contrôlé avant utilisation';
}

// Mise à jour du nombre d'utilisations restantes du matériel
$nouveau_nbre_utilisation = $materiel['nbre_utilisation'] - 1;
$req = $pdo->prepare('UPDATE materiel SET nbre_utilisation = ? WHERE id = ?');
$req->execute(array($nouveau_nbre_utilisation, $id_materiel));
?>


