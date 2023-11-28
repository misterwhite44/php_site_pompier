<?php
$title="Actu stock";
include('header.php');

include "config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("SELECT materiel.numero as numero, materiel.nom as nom_materiel, materiel.denomination as denomination, 
       materiel.nbre_utilisation as nbre_utilisation, materiel.nbre_utilisation_max as nbre_utilisation_max, materiel.dlc as dlc, 
       materiel.date_maintenance as date_maintenance, vehicule.nom as nom_vehicule
FROM `materiel` LEFT JOIN vehicule on vehicule.id = materiel.id_vehicule limit 10;");

$requete->execute();

$lignes = $requete->fetchAll();

$requete2 = $pdo->prepare("SELECT * FROM vehicule");

$requete2->execute();

?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Numéro du matériel</th>
            <th scope="col">Nom de voiture</th>
            <th scope="col">Dénomination</th>
            <th scope="col">Catégorie</th>
            <th scope="col">Nombre d'utilisations</th>
            <th scope="col">Nombres d'utilisations limites</th>
            <th scope="col">Date d'expiration</th>
            <th scope="col">Date prochain contrôle</th>
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
            <td><?php echo $l["numero"]?></td>
            <td><?php if($l["nom_vehicule"] == ""){
                    echo "Hangar";
                }else{
                    echo $l["nom_vehicule"];
                }
                ?></td>
            <td><?php echo $l["nom_materiel"] ?></td>
            <td><?php echo $l["denomination"]?></td>
            <td><?php echo $l["nbre_utilisation"]?></td>
            <td><?php if($l["nbre_utilisation_max"] == ""){
                    echo "∞";
                }else{
                    echo $l["nbre_utilisation_max"];
                } ?></td>
            <td><?php if($l["dlc"] == ""){
                    echo "Aucune";
                }else{
                    echo $l["dlc"];
                }
                ?></td>
            <td><?php if($l["date_maintenance"] == ""){
                    echo "Aucune";
                }else{
                    echo $l["date_maintenance"];
                }
              ?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <h3>Ajouter ou modifier du materiel</h3>
    <form enctype="multipart/form-data" action="action/modifier_materiel.php" method="post">
        <div class="form-group">
            <input type="file" name="file"/>
            <input type="submit" name="importSubmit" value="Envoyer">
        </div>
    </form>
    <h3>Gestion du materiel</h3>
    <form enctype="multipart/form-data" action="action/vehicule_materiel.php" method="post">
        <div class="from-group">
            <label for="id">Choisir Vehicule:</label>
            <select class="form-control" name="id">
                <?php while ($donnees = $requete2->fetch()){
                    ?>
                    <option value="<?php echo $donnees["id"]?>"><?php echo $donnees["nom"]?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <input type="file" name="file"/>
            <input type="submit" name="importSubmit" value="Envoyer">
        </div>
    </form>
    <h3>Export</h3>
    <div class="col-md-12 head">
        <div class="float-right">
            <a href="action/export_all.php" class="btn btn-success"><i class="dwn"></i>Export materiel</a>
        </div>
    </div>
    <div class="col-md-12 head">
        <div class="float-right">
            <a href="action/export.php" class="btn btn-success"><i class="dwn"></i>Export materiel inutilisable</a>
        </div>
    </div>
    <div class="col-md-12 head">
        <div class="float-right">
            <a href="action/export_controlle.php" class="btn btn-success"><i class="dwn"></i>Export a verifier</a>
        </div>
    </div>
<?php
include ('footer.php');
?>

