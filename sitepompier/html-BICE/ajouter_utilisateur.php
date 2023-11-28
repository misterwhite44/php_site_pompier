<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $id_materiel = $_POST["id_materiel"];

include "config.php";
    try {
        $pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la requête SQL pour insérer un nouvel utilisateur
        $sql = "INSERT INTO utilisateur (nom, prenom, id_materiel) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $id_materiel]);

        echo "Utilisateur ajouté avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'utilisateur: " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $pdo = null;
}
?>
