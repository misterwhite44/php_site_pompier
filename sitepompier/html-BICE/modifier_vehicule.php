<?php
$title="Gestion vehicule";
include('header.php');

include "config.php";

$id = filter_input(INPUT_GET,"id");

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("SELECT * FROM vehicule where id=:id");

$requete->bindParam(":id",$id);

$requete->execute();

$valeur = $requete->fetchAll();
?>


<h1>Modifier un véhicule</h1>
<form class="was-validated" action="action/modif_vehicule.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <div class="from-group">
        <label for="nom_vehicule">Nom</label>
        <input value="<?php echo $valeur[0]["nom"] ?>" class="form-control" name="nom_vehicule" type="text" required maxlength="50" >
    </div>
    <div id="es" class="from-group">
        <label for="immatriculation">Immatriculation</label>
        <input class="form-control" name="immatriculation"  type="text" required pattern="^[A-Z]{2} ?- ?\d{3} ?- ?[A-Z]{2}$" value="<?php echo $valeur[0]["immatriculation"] ?>">
    </div>
    <input type="submit" class="mt-5 btn btn-success" value="Enregistrer">
    <a href="gestion_vehicule.php" class="mt-5 btn btn-light">Annuler</a>
</form>
