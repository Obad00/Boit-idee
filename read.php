

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails de l'idée</title>
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
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
  border-radius: 5px;
  margin-top: 50px;
}

.alert {
  margin: 20px 0;
  padding: 10px;
  border-radius: 5px;
  color: #fff;
}

.alert-success {
  background-color: #4CAF50;
}

.alert-danger {
  background-color: #F44336;
}

.details {
  margin: 20px 0;
}

.details p {
  margin-bottom: 10px;
}

.details strong {
  font-weight: bold;
  display: inline-block;
  width: 120px;
  text-align: right;
  margin-right: 10px;
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

// Vérifier si l'ID de l'idée est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idee_id = $_GET['id'];
    
    /* Inclure le fichier config */
    require_once "config.php";

    try {
        // Requête SQL pour obtenir les détails de l'idée
        $sql = "SELECT Idee.id, Idee.titre, Idee.description, Idee.date_creation, Idee.statut, Categorie.nom AS nom_categorie, Idee.contenu, Utilisateurs.prenom AS prenom_utilisateur 
                FROM Idee 
                LEFT JOIN Categorie ON idee.id_categorie = categorie.id 
                LEFT JOIN Utilisateurs ON idee.ID_utilisateurs = utilisateurs.ID 
                WHERE Idee.id = ?";
        
        // Préparer la requête
        $stmt = $pdo->prepare($sql);
        $stmt->bind_param('i', $idee_id);
        $stmt->execute();
        
        // Récupérer les résultats
        $result = $stmt->get_result();
        
        // Vérifier s'il y a des résultats
        if ($result->num_rows == 1) {
            // Récupérer les données de l'idée
            $idee = $result->fetch_assoc();

            // Afficher les détails de l'idée
            echo "<h2>Détails de l'idée</h2>";
            echo "<p><strong>Titre:</strong> " . $idee['titre'] . "</p>";
            echo "<p><strong>Description:</strong> " . $idee['description'] . "</p>";
            echo "<p><strong>Date de création:</strong> " . $idee['date_creation'] . "</p>";
            echo "<p><strong>Statut:</strong> " . $idee['statut'] . "</p>";
            echo "<p><strong>Contenu:</strong> " . $idee['contenu'] . "</p>";
            echo "<p><strong>Catégorie:</strong> " . $idee['nom_categorie'] . "</p>";
            echo "<p><strong>Utilisateur:</strong> " . $idee['prenom_utilisateur'] . "</p>";
        } else {
            echo '<div class="alert alert-danger">L\'idée spécifiée n\'existe pas.</div>';
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }
} else {
    echo '<div class="alert alert-danger">ID d\'idée non spécifié.</div>';
}
?>
</div>
</body>
</html>
