<?php
$title="Ajouter vehicule";
include('header.php');
?>

<h1>Ajouter un vehicule</h1>
<form class="was-validated" action="action/ajoue_vehicule.php" method="post">
    <div class="from-group">
        <label for="nom_vehicule">Nom</label>
        <input class="form-control" name="nom_vehicule" type="text" required maxlength="50">
    </div>
    <div id="es" class="from-group">
        <label for="immatriculation">Immatriculation</label>
        <input class="form-control" name="immatriculation"  type="text" required pattern="^[A-Z]{2} ?- ?\d{3} ?- ?[A-Z]{2}$" >
    </div>
    <input type="submit" class="mt-5 btn btn-success" value="Enregistrer">
    <a href="gestion_vehicule.php" class="mt-5 btn btn-light">Annuler</a>
</form>
