<?php

include "../config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$id=filter_input(INPUT_POST,"id");

if(isset($_POST['importSubmit'])){

    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            $requete = $pdo->prepare("UPDATE materiel SET id_vehicule = NULL where id_vehicule = :id ");
            $requete->bindParam(":id",$id);
            $requete->execute();

            while(($line = fgetcsv($csvFile, NULL, ";")) !== FALSE) {

                $numero = $line[0];

                $requete = $pdo->prepare("UPDATE materiel SET id_vehicule = :id where numero=:numero");
                $requete->bindParam(":id",$id);
                $requete->bindParam(":numero",$numero);
                $requete->execute();

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

header("location:../actu_stock.php");
