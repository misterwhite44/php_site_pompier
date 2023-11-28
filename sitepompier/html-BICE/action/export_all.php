<?php

include "../config.php";

$pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);

$query = $pdo->query("SELECT * FROM materiel where stock = 1");

if($query->rowCount() > 0){
    $delimiter = ";";
    $filename = "members-data_" . date('Y-m-d') . ".csv";

    // Create a file pointer
    $f = fopen('php://memory', 'w');

    // Set column headers
    $fields = array('NUMERO', 'NOM', 'DENOMINATION', 'DATE LIMITE', 'NOMBRE UTILISATION', 'NOMBRE UTILISATION TOTAL', 'DATE MAINTENANCE');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch()){
        $lineData = array($row['numero'],$row["nom"], $row['denomination'], $row['dlc'], $row['nbre_utilisation'], $row['nbre_utilisation_max'], $row['date_maintenance']);
        fputcsv($f, $lineData, $delimiter);
    }

    // Move back to beginning of file
    fseek($f, 0);

    // Set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>