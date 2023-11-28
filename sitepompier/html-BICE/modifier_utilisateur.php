<?php
// Connexion à la base de données
include "config.php";

try {
    $pdo = new PDO("mysql:host=".config::SERVEUR.";dbname=".config::BDD,config::UTILISATEUR,config::MOTDEPASSE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérifier si un formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $id_materiel = $_POST['id_materiel'];

    // Mettre à jour l'utilisateur dans la base de données
    $stmt = $pdo->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, id_materiel = :id_materiel WHERE id = :id');
    $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'id_materiel' => $id_materiel, 'id' => $id]);

    // Rediriger vers la page d'accueil
    header('Location: utilisateur.php');
    exit();
}

// Récupérer l'utilisateur à modifier
$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE id = :id');
$stmt->execute(['id' => $id]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe
if (!$utilisateur) {
    die('Utilisateur non trouvé.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
</head>
<body>
<h1>Modifier Utilisateur</h1>
<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $utilisateur['id']; ?>">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?php echo $utilisateur['nom']; ?>" required><br>
    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" value="<?php echo $utilisateur['prenom']; ?>" required><br>
    <label for="id_materiel">ID Matériel:</label>
    <input type="text" id="id_materiel" name="id_materiel" value="<?php echo $utilisateur['id_materiel']; ?>" required><br>
    <input type="submit" name="submit" value="Enregistrer">
</form>

</body>
</html>
