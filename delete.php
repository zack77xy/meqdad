<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['index'])) {
    $index = $_GET['index'];

    if (isset($_COOKIE['etudiants'])) {
        $etudiants = unserialize($_COOKIE['etudiants']);

        // Suppression de l'étudiant
        if (isset($etudiants[$index])) {
            array_splice($etudiants, $index, 1);
            setcookie("etudiants", serialize($etudiants), time() + 3600, '/');
        }
    }
}

header('Location: page.php');
exit();
?>