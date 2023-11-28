<?php

function verification($verif){
    if($verif == ""){
        return -1;
    }else{
        return $verif;
    }
}

$intervention = filter_input(INPUT_POST,"intervention");
$vehicule = filter_input(INPUT_POST,"vehicule");

include "../config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

if(isset($_POST['importSubmit'])) {

    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if ((!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) && (!empty($_FILES['file2']['name']) && in_array($_FILES['file2']['type'], $csvMimes))) {

        if (is_uploaded_file($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file2']['tmp_name'])) {

            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            $csvFile2 = fopen($_FILES['file2']['tmp_name'], 'r');

            $arr = [];

            while (($line = fgetcsv($csvFile, null, ";")) !== FALSE) {

                $numero = $line[0];

                $arr[] = $numero;

                $requete = $pdo->prepare("UPDATE materiel SET id_vehicule = :vehicule where numero =:numero ");
                $requete->bindParam(":vehicule",$vehicule);
                $requete->bindParam(":numero",$nuemro);
                $requete->execute();
            }

            while (($line = fgetcsv($csvFile2, null, ";")) !== FALSE) {

                $numero = $line[0];

                $arr[] = $numero;

                $requete = $pdo->prepare("UPDATE materiel SET nbre_utilisation = nbre_utilisation + 1 where numero = :numero ");
                $requete->bindParam(":numero",$numero);
                $requete->execute();

                $requete = $pdo->prepare("INSERT INTO utilisation (id_intervention, id_vehicule, id_materiel) VALUES (:intervention, :vehicule, (SELECT id from materiel where numero = :numero))");
                $requete->bindParam(":numero",$numero);
                $requete->bindParam(":intervention",$intervention);
                $requete->bindParam(":vehicule",$vehicule);

                $requete = $pdo->prepare("SELECT dlc, nbre_utilisation, nbre_utilisation_max FROM materiel where numero = :numero");
                $requete->bindParam(":numero",$numero);
                $requete->execute();

                $ligne = $requete->fetch();

                $dlc =  $ligne["dlc"];
                $utilisation =  $ligne["nbre_utilisation"];
                $utilisation_max =  verification($ligne["nbre_utilisation_max"]);

                $aujourdhui  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
                $aujourdhui = date("Y-m-d", $aujourdhui);

                if (($dlc > $aujourdhui) || ($utilisation > $utilisation_max)){
                    $requete = $pdo->prepare("UPDATE materiel SET id_vehicule = NULL, stock = 0 where numero = :numero");
                    $requete->bindParam(":numero",$numero);
                    $requete->execute();
                }
            }

            $requete = $pdo->query("SELECT numero FROM materiel");

            while ($donne = $requete->fetch()){
                if(in_array($donne["numero"],$arr)){

                }else{
                    $requete2 = $pdo->preare("UPDATE materiel SET id_vehicule = NULL, stock = 0 where numero = :numero");
                    $requete->bindParam(":numero",$numero);
                    $requete->execute();
                }
            }

            fclose($csvFile);
            fclose($csvFile2);

            $qstring = '?statut=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring ='?status=invalid_file';
    }
}

header("location:../rtr_intervention.php");