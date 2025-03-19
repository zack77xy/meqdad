<?php
session_start();
include_once 'Etudiant.php'; // Inclure la classe Etudiant

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Récupérer les étudiants depuis le cookie
$etudiants = isset($_COOKIE['etudiants']) ? unserialize($_COOKIE['etudiants']) : [];

// Vérifier si l'index est passé en paramètre
if (isset($_GET['index']) && isset($etudiants[$_GET['index']])) {
    $index = (int)$_GET['index'];
    $etudiant = $etudiants[$index];

    // Traitement du formulaire de modification
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom']);
        $math = (float)$_POST['math'];
        $info = (float)$_POST['info'];

        if (!empty($nom) && $math >= 0 && $math <= 20 && $info >= 0 && $info <= 20) {
            // Mettre à jour l'étudiant
            $etudiants[$index] = new Etudiant($nom, $math, $info);

            // Sauvegarder les modifications dans le cookie
            setcookie("etudiants", serialize($etudiants), time() + 3600, '/');

            // Redirection vers la page avec la liste des étudiants
            header('Location: index3.php');
            exit();
        } else {
            echo "<p>Veuillez entrer des valeurs valides.</p>";
        }
    }
} else {
    // Rediriger si l'index est invalide
    header('Location: index3.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Étudiant</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <div class="container">
        <h2>Modifier Étudiant</h2>
        <form method="POST">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($etudiant->getNom()); ?>" required>

            <label for="math">Maths:</label>
            <input type="number" id="math" name="math" min="0" max="20" value="<?php echo $etudiant->getMath(); ?>" required>

            <label for="info">Informatique:</label>
            <input type="number" id="info" name="info" min="0" max="20" value="<?php echo $etudiant->getInfo(); ?>" required>

            <button type="submit" class="btn">Enregistrer</button>
        </form>
        <a href="index3.php" class="btn">Retour</a>
    </div>
</body>
</html>
