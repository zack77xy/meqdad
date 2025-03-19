<?php 
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifiant = $_POST['username'];
    $password = ($_POST['password']); 
    $authentifier = false;

    if (file_exists("crendentiels.csv")) {
        $file = fopen("crendentiels.csv", "r");
        while (($line = fgetcsv($file, 255, ";")) !== false) {
            if ($line[0] == $identifiant && $line[1] == $password) {
                $authentifier = true;
                break;
            }
        }
        fclose($file);
    } else {
        $error = "Fichier de credentials introuvable.";
    }

    if ($authentifier) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $identifiant;
        header('Location: index2.php');
        exit();
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>LOGIN</h1></header>

<form action="" method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

<p><?php echo $error; ?></p>

</body>
</html>
