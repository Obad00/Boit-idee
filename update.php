

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'idée</title>
    <style>
        body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f0f0f0;
}

h2 {
  color: #333;
  text-align: center;
  padding: 20px;
  background-color: #4CAF50;
  margin: 0;
}

.container {
  width: 80%;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
  margin-top: 50px;
}

form {
  width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
  margin-top: 50px;
}

form label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

form input[type="text"],
form textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-sizing: border-box;
  margin-bottom: 20px;
}

form button[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

form button[type="submit"]:hover {
  background-color: #3e8e41;
}
    </style>
</head>
<body>
    <div class="container">
    <?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idee_id = $_GET['id'];

    // Inclure le fichier config
    require_once "config.php";

    // Vérifier si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $contenu = $_POST['contenu'];
        // Autres champs à mettre à jour...

        try {
            // Requête SQL pour mettre à jour l'idée
            $sql_update = "UPDATE Idee  SET titre = ?, description = ?, contenu = ? 
                            WHERE id = ?";
            
            // Préparer la requête
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bind_param('sssi', $titre, $description, $contenu, $idee_id);
            $stmt_update->execute();

            // Rediriger vers la page de lecture après la mise à jour
            header('Location: read.php?id=' . $idee_id);
            exit();
        } catch (PDOException $e) {
            echo "Erreur de mise à jour de l'idée: " . $e->getMessage();
        }
    }

    // Récupérer les détails actuels de l'idée
    try {
        // Requête SQL pour obtenir les détails de l'idée
        $sql_select = "SELECT id, titre, description, contenu FROM Idee WHERE id = ?";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->bind_param('i', $idee_id);
        $stmt_select->execute();

        $result_select = $stmt_select->get_result();

        // Vérifier s'il y a des résultats
        if ($result_select->num_rows == 1) {
            $idee = $result_select->fetch_assoc();
        } else {
            echo "L'idée spécifiée n'existe pas.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur de récupération des détails de l'idée: " . $e->getMessage();
    }
} else {
    echo "ID d'idée non spécifié.";
    exit();
}

?>
    </div>

    <h2>Modifier l'idée</h2>
    <div>
    <form method="POST" action="">
        <label for="titre">Titre</label>
        <input type="text" name="titre" value="<?php echo $idee['titre']; ?>" required><br>

        <label for="description">Description</label>
        <textarea name="description" required><?php echo $idee['description']; ?></textarea><br>

        <label for="contenu">Contenu</label>
        <textarea name="contenu" required><?php echo $idee['contenu']; ?></textarea><br>

        <button type="submit">Enregistrer les modifications</button>
    </form>
    </div>

</body>
</html>
