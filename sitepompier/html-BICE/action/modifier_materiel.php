<?php

function changerdate($date){
    if ($date != "") {
        $date[2] = "-";
        $date[5] = "-";
        $timestamp = strtotime($date);
        return date("Y-m-d", $timestamp);
    }else{
        return  NULL;
    }
}

function verification($verif){
    if($verif == ""){
        return NULL;
    }else{
        return $verif;
    }
}
include "../config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);


if(isset($_POST['importSubmit'])) {

    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            while (($line = fgetcsv($csvFile, null, ";")) !== FALSE) {

                $numero = $line[0];
                $nom = $line[1];
                $denomination = $line[2];
                $nbre_utilisation = verification($line[3]);
                $nbre_utilisation_max = verification($line[4]);
                $dlc = changerdate($line[5]);
                $date_maitenance = changerdate($line[6]);
                echo "<br>";
                echo $numero;
                echo "<br>";
                echo $nom;
                echo "<br>";
                echo $denomination;
                echo "<br>";
                echo $nbre_utilisation;
                echo "<br>";
                echo $nbre_utilisation_max;
                echo "<br>";
                echo $dlc;
                echo "<br>";
                echo $date_maitenance;
                echo "<br>";

                $requete = $pdo->prepare("SELECT id FROM materiel where numero =:numero");
                $requete->bindParam(":numero",$numero);
                $requete->execute();
                echo $requete->rowCount() > 0;
                echo "<br>";

                if ($requete->rowCount() > 0) {

                    $requete = $pdo->prepare("UPDATE materiel SET nom =:nom, denomination=:denomination, dlc=:dlc, nbre_utilisation=:nbre_utilisation,
                    nbre_utilisation_max=:nbre_utilisation_max, date_maintenance=:date_maintenance where numero=:numero ");
                    $requete->bindParam(":numero",$numero);
                    $requete->bindParam(":nom",$nom);
                    $requete->bindParam(":denomination",$denomination);
                    $requete->bindParam(":dlc",$dlc);
                    $requete->bindParam(":nbre_utilisation",$nbre_utilisation);
                    $requete->bindParam(":nbre_utilisation_max",$nbre_utilisation_max);
                    $requete->bindParam(":date_maintenance",$date_maitenance);
                    $requete->execute();

                } else {

                    $requete = $pdo->prepare("Insert into materiel (numero,nom,denomination,dlc,nbre_utilisation,nbre_utilisation_max,date_maintenance)
                    VALUES (:numero,:nom,:denomination,:dlc,:nbre_utilisation,:nbre_utilisation_max,:date_maintenance)");
                    $requete->bindParam(":numero",$numero);
                    $requete->bindParam(":nom",$nom);
                    $requete->bindParam(":denomination",$denomination);
                    $requete->bindParam(":dlc",$dlc);
                    $requete->bindParam(":nbre_utilisation",$nbre_utilisation);
                    $requete->bindParam(":nbre_utilisation_max",$nbre_utilisation_max);
                    $requete->bindParam(":date_maintenance",$date_maitenance);
                    $requete->execute();

                    }

            }

            fclose($csvFile);

            $qstring = '?statut=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring ='?status=invalid_file';
    }
}