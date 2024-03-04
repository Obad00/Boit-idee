<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Valider les données du formulaire (ne pas oublier de le faire !)
    
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $conn = connect();
    $query = "SELECT id, email FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" required>
        <br>
        <label for="mot_de_passe">Mot de passe</label>
        <input type="mot_de_passe" name="mot_de_passe" required>
        <br>
        <br>
        <button type="submit">Se Connecter</button>
    </form>
</body>
</html>
