<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Supprimer un étudiant
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
    $index = (int) $_GET['index'];
    $lines = file("notes.csv", FILE_IGNORE_NEW_LINES);
    
    if (isset($lines[$index + 1])) {
        unset($lines[$index + 1]);
        file_put_contents("notes.csv", implode("\n", $lines));
    }
    header('Location: index3.php');
    exit();
}

// Charger les étudiants
$etudiants = array_slice(file("notes.csv"), 1);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>

<header><h1>Liste des Étudiants</h1></header>

<div class="container">
    <table>
        <tr>
            <th>Nom</th>
            <th>Maths</th>
            <th>Informatique</th>
            <th>Moyenne</th>
            <th>Observation</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($etudiants as $index => $line) : 
            $data = str_getcsv($line, ";");
            if (count($data) < 3) continue;
            list($nom, $maths, $info) = $data;

            // Vérifier si les notes sont bien numériques
            if (is_numeric($maths) && is_numeric($info)) {
                $moyenne = ($maths + $info) / 2;
            } else {
                $moyenne = 0; // Si non numérique, assigne une moyenne de 0
            }
        ?>
            <tr>
                <td><?= htmlspecialchars($nom); ?></td>
                <td><?= $maths; ?></td>
                <td><?= $info; ?></td>
                <td><?= number_format($moyenne, 2); ?></td>
                <td><?= ($moyenne >= 10) ? "Admis" : "Non admis"; ?></td>
                <td>
                    <!-- Bouton Modifier -->
                    <a href="update.php?index=<?= $index; ?>" class="btn-modifier">Modifier</a>
                    <!-- Bouton Supprimer -->
                    <a href="index3.php?action=delete&index=<?= $index; ?>" onclick="return confirm('Voulez-vous supprimer cet étudiant ?');" class="btn-supprimer">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index2.php" class="btn">Retour</a>
</div>

</body>
</html>
