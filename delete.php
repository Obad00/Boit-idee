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
        try {
            // Requête SQL pour supprimer l'idée
            $sql_delete = "DELETE FROM Idee WHERE id = ?";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->bind_param('i', $idee_id);
            $stmt_delete->execute();

            // Rediriger vers la page de lecture après la suppression
            header('Location: read.php');
            exit();
        } catch (PDOException $e) {
            echo "Erreur de suppression de l'idée: " . $e->getMessage();
        }
    }

    // Récupérer les détails de l'idée à supprimer pour confirmation
    try {
        // Requête SQL pour obtenir les détails de l'idée
        $sql_select = "SELECT id, titre FROM Idee WHERE id = ?";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->bind_param('i', $idee_id);
        $stmt_select->execute();

        $result_select = $stmt_select->get_result();

        // Vérifier s'il y a des résultats
        if ($result_select->num_rows == 1) {
            $idee = $result_select->fetch_assoc();
        } else {
            echo "L'idée spécifiée est supprimée.";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'idée</title>
</head>
<style>
.idee-container {
  width: 80%;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
  margin-top: 50px;
  display: flex;
  flex-wrap: wrap;
  background-color: #4CAF50;
}

.idee-titre {
  flex: 1 1 100%;
  margin-bottom: 20px;
  text-align: center;
  margin-left: 50px;
  background-color: #4CAF50;
}



.action {
  display: inline-block;
  margin-right: 10px;
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  background-color: #f44336;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.action:hover {
  background-color: #e53935;
}

</style>
<body>

   <div class="idee-container">
   <h1>Êtes-vous sûr de vouloir supprimer cette idée ?</h1>
   </div>

   <div style="display: flex; align-items: center;">
   <h2 class="idee-titre"><?php echo $idee['titre']; ?></h2>
   </div>

   <div class="action">
   <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $idee_id; ?>">
        <button type="submit">Confirmer la suppression</button>
    </form>
   </div>

</body>
</html>
