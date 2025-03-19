<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = htmlspecialchars($_POST['etudiant']);
    $math = (float)$_POST['maths'];
    $info = (float)$_POST['informatique'];

    if (!empty($nom) && $math >= 0 && $math <= 20 && $info >= 0 && $info <= 20) {
        // Crée l'étudiant
        include_once 'Etudiant.php';
        $etudiant = new Etudiant($nom, $math, $info);

        // Récupérer les étudiants existants
        $etudiants = isset($_COOKIE['etudiants']) ? unserialize($_COOKIE['etudiants']) : [];
        $etudiants[] = $etudiant;

        // Sauvegarder dans le cookie
        setcookie("etudiants", serialize($etudiants), time() + 3600, '/');

        // Sauvegarder dans le fichier CSV
        $file = fopen("notes.csv", "a");
        fputcsv($file, [$nom, $math, $info], ";");
        fclose($file);

        header('Location: index2.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        Formulaire d'ajout de notes
    </header>
    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="etudiant">Étudiant</label>
                <input type="text" id="etudiant" name="etudiant" required>
            </div>

            <div class="form-group">
                <label for="maths">Maths</label>
                <input type="number" min="0" max="20" id="maths" name="maths" required>
            </div>

            <div class="form-group">
                <label for="informatique">Informatique</label>
                <input type="number" min="0" max="20" id="informatique" name="informatique" required>
            </div>

            <div class="buttons">
                <button type="submit" name="ajouter">Ajouter</button>
                <a href="index3.php" class="btn">Afficher</a>
                <button type="button" onclick="window.location.href='logout.php';">Déconnexion</button>
            </div>
        </form>
    </div>
</body>
</html>
