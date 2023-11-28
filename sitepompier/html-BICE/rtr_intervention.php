<?php
$title="Intervention";
include('header.php');

include "config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("SELECT * FROM intervention");

$requete->execute();

$lignes = $requete->fetchAll();

$requete2 = $pdo->prepare("SELECT * FROM intervention");

$requete2->execute();

$requete3 = $pdo->prepare("SELECT * FROM vehicule");

$requete3->execute();
?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Lieu</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <?php
        $nb_ligne = 1;
        foreach ($lignes as $l){
        ?>
        <tbody>
        <tr>
            <th scope="row" ><?php echo $nb_ligne;
                $nb_ligne += 1; ?></th>
            <td><?php echo $l["nom"] ?></td>
            <td><?php echo $l["lieu"] ?></td>
            <td><?php echo $l["date"] ?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary"
                href="ajouter_intervention.php" class="mt5 btn btn-success">Ajouter</a>
    <a class="btn btn-primary"
                href="supprimer_intervention.php" class="mt5 btn btn-success">Supprimer</a>
    <h3>Materiel de l'intervention</h3>
    <form enctype="multipart/form-data" action="action/materiel_intervention.php" method="post">
        <div class="from-group">
            <label for="intervention">Choisir Intervention:</label>
            <select class="form-control" name="intervention">
                <?php while ($donnees = $requete2->fetch()){
                    ?>
                    <option value="<?php echo $donnees["id_intervention"]?>"><?php  echo $donnees["nom"];
                                                                                    echo " | ";
                                                                                    echo $donnees["lieu"];
                                                                                    echo " | ";
                                                                                    echo $donnees["date"];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="from-group">
            <label for="vehicule">Choisir Vehicule:</label>
            <select class="form-control" name="vehicule">
                <?php while ($donnees2 = $requete3->fetch()){
                    ?>
                    <option value="<?php echo $donnees2["id"]?>"><?php echo $donnees2["nom"]?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <input type="file" name="file"/>
            <input type="file" name="file2"/>
            <input type="submit" name="importSubmit" value="Envoyer">
        </div>
    </form>
<?php
include ('footer.php');
?>