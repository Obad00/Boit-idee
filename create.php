<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inclure le fichier config
    require_once "config.php";

    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_creation = $_POST['date_creation'];
    $statut = $_POST['statut'];
    $contenu = $_POST['contenu'];
    $categorie = $_POST['id_categorie'];
    
    // Requête SQL pour insérer les données de l'idée dans la base de données
    $sql = "INSERT INTO Idee (titre, description, date_creation, statut, contenu, id_categorie, ID_utilisateurs) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Vérifier si la connexion à la base de données est établie
    if ($pdo) {
        // Préparer la requête
        $stmt = $pdo->prepare($sql);
        // Liaison des paramètres
        $stmt->bind_param('ssssssi', $titre, $description,  $date_creation, $statut, $contenu, $categorie, $_SESSION['user_id']);
        // Exécuter la requête
        if ($stmt->execute()) {
            // Rediriger vers la page d'accueil ou une autre page de votre choix
            header('Location: index.php');
            exit();
        } else {
            echo "Erreur lors de l'insertion de l'idée.";
        }
    } else {
        echo "Erreur de connexion à la base de données.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une nouvelle idée</title>
</head>
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

form {
  width: 500px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}

label {
  display: block;
  margin-bottom: 10px;
  color: #333;
}

input[type="text"],
textarea,
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-sizing: border-box;
  margin-bottom: 20px;
}

select {
  appearance: none;
  -webkit-appearance: none;
  background-position: right 10px top 50%, right 10px bottom 50%;
  background-repeat: no-repeat;
  padding-right: 35px;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}
</style>
<body>

    <h2>Créer une nouvelle idée</h2>
<br>
<br>
    <form method="POST" action="">
        <label for="titre">Titre</label><br>
        <input type="text" id="titre" name="titre" required><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description" required></textarea><br>

        <label for="date_creation">Date création</label><br>
        <input type="date" id="date_creation" name="date_creation" required><br>
        <br>


        <label for="statut">Statut</label><br>
        <select name="statut" id="statut" required>
            <option value="brouillon">Brouillon</option>
            <option value="soumise">Soumise</option>
            <option value="en cours">En cours</option>
            <option value="terminé">Terminé</option>
        </select><br>

        <label for="contenu">Contenu</label><br>
        <textarea id="contenu" name="contenu" required></textarea><br>

      <select name="id_categorie">
                <option value="">Sélectionner une catégorie</option>
                <?php
                    // Inclure le fichier de connexion à la base de données
                    include_once "config.php";

                    // Récupérer la liste des catégories depuis la base de données
                    $query_categories = "SELECT id, nom FROM Categorie";
                    $result_categories = mysqli_query($pdo, $query_categories);
                    while ($row_categorie = mysqli_fetch_assoc($result_categories)) {
                        echo "<option value='" . $row_categorie['id'] . "'>" . $row_categorie['nom'] . "</option>";
                    }
                ?>
      </select>
            <br>
            <br>      
        <button type="submit">Créer l'idée</button>
    </form>

</body>
</html>
