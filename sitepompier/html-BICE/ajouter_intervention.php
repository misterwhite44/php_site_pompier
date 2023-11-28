<?php
$title="Ajouter vehicule";
include('header.php');
?>

<h1>Ajouter un vehicule</h1>
<form class="was-validated" action="action/ajouter_intervention.php" method="post">
    <div class="from-group">
        <label for="nom">Nom</label>
        <input class="form-control" name="nom" type="text" required maxlength="50">
    </div>
    <div class="from-group">
        <label for="date">Date</label>
        <input class="form-control" name="date"  type="text" placeholder="Ex : 2023-03-14" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))">
    </div>
    <div class="from-group">
        <label for="lieu">Lieu</label>
        <input class="form-control" name="lieu" type="text" required maxlength="50" >
    </div>
    <input type="submit" class="mt-5 btn btn-success" value="Enregistrer">
    <a href="gestion_vehicule.php" class="mt-5 btn btn-light">Annuler</a>
</form>
