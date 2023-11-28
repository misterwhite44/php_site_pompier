<?php
$title="Gestion vehicule";
include('header.php');

include "config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$requete = $pdo->prepare("select * from vehicule");

$requete->execute();

$vehicule = $requete->fetchAll();

$requete2 = $pdo->prepare("Select id_vehicule from utilisation");

$requete2->execute();

$utilisation = $requete2->fetchAll();

function verification($id,$utilisation){
    foreach ($utilisation as $u){
        if($u["id_vehicule"] == $id){
            return 1;
        }
    }
    return 0;
}
?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Immatriculation</th>
            <th scope="col">Numéro interne</th>
            <th scope="col">Modifier</th>
            <th scope="col">Suprimer</th>
        </tr>
        </thead>
        <?php
        $nb_ligne = 1;
        foreach ($vehicule as $v){
            $verif = verification($v["id"],$utilisation)
        ?>
        <tbody>
        <tr>
            <th scope="row"><?php echo $nb_ligne; ?></th>
            <td><?php echo $v["nom"]?></td>
            <td><?php echo $v["immatriculation"]?></td>
            <td><?php echo $v["id"]?></td>
            <td><a class="btn btn-primary"
                   href="modifier_vehicule.php?id=<?php echo $v["id"]?>" class="mt5 btn btn-success">Modifier</a></td>
            <td><?php if($verif == 1){ ?>
                <a class="btn btn-primary"
                   href="action/desactiver_vehicule.php?id=<?php echo $v["id"]?>" class="mt5 btn btn-success">Desactiver</a><?php
                }else{ ?>
                <a class="btn btn-primary"
                   href="action/suprimer_vehicule.php?id=<?php echo $v["id"]?>" class="mt5 btn btn-success">Supprimer</a>
       <?php }
                $nb_ligne += 1;
                ?>
            </td>
            <?php }  ?>
        </tr>
        </tbody>
    </table>
    <a class="btn btn-primary"
       href="ajouter_vehicule.php" class="mt5 btn btn-success">Ajouter</a>


<?php
include ('footer.php');