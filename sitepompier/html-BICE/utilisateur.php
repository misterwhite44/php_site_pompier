<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<?php
include "header.php";

include "config.php";

try {
    $pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer tous les utilisateurs
    $sql = "SELECT * FROM utilisateur";
    $stmt = $pdo->query($sql);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermer la connexion à la base de données
    $pdo = null;
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des utilisateurs: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Utilisateurs</title>
</head>
<body>
<h2>Liste des Utilisateurs</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>ID Matériel</th>
        <th>Action</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            <td><?php echo $utilisateur["nom"]; ?></td>
            <td><?php echo $utilisateur["prenom"]; ?></td>
            <td><?php echo $utilisateur["id_materiel"]; ?></td>
            <td>
                <a href="modifier_utilisateur.php?id=<?php echo $utilisateur["id"]; ?>">Modifier</a>
            </td>
        </tr>
    <?php } ?>
</table>

<h2>Ajouter un Utilisateur</h2>
<form action="ajouter_utilisateur.php" method="POST">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" required><br>

    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" required><br>

    <label for="id_materiel">ID Matériel:</label>
    <input type="number" name="id_materiel" required><br>

    <input type="submit" value="Ajouter">
</form>

</body>
</html>
