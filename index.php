<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord des idées</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
    margin-left: 70px;
    margin-right: 70px;
    padding-bottom: 100px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

h1 {
    color: #333;
    margin-bottom: 2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 0.75rem;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin-right: 0.5rem;
    border-radius: 0.25rem;
    text-align: center;
    text-decoration: none;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out, border-color 0.15s ease-in-out;
}

.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-warning {
    color: #fff;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-warning:hover {
    background-color: #ffb307;
    border-color: #ffa007;
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #1e7e34;
    border-color: #1c7430;
}
.align-right {
    float: right;
}
nav {
    background-color: #333;
    overflow: hidden;
    height: 80px;
    position: fixed;
}

nav ul {
    list-style-type: none;
    padding-left: 100px;

}

nav ul li {
    float: left;
    margin-left: 30px;
}

nav ul li a {
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

nav ul li a:hover {
    background-color: #111;
}

.welcome-text {
    font-size: 18px; 
    margin-right: 20px; 
    color: white;
}


.bienvenu {
    margin-left: -150px;

}
.barre{
    margin-left: 10px;
}
.Btn {
  --black: #000000;
  --ch-black: #141414;
  --eer-black: #1b1b1b;
  --night-rider: #2e2e2e;
  --white: #ffffff;
  --af-white: #f3f3f3;
  --ch-white: #e1e1e1;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: var(--af-white);
  margin-left: 850px;
}

/* plus sign */
.sign {
  width: 100%;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sign svg {
  width: 17px;
}

.sign svg path {
  fill: var(--night-rider);
}
/* text */
.text {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: var(--night-rider);
  font-size: 1.2em;
  font-weight: 600;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 125px;
  border-radius: 5px;
  transition-duration: .3s;
}

.Btn:hover .sign {
  width: 30%;
  transition-duration: .3s;
  padding-left: 20px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;
  width: 70%;
  transition-duration: .3s;
  padding-right: 10px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}
.button {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: rgb(20, 20, 20);
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
  cursor: pointer;
  transition-duration: .3s;
  overflow: hidden;
  
}

.svgIcon {
  width: 12px;
  transition-duration: .3s;
}

.svgIcon path {
  fill: white;
}

.button:hover {
  width: 140px;
  border-radius: 50px;
  transition-duration: .3s;
  background-color: rgb(255, 69, 69);
  align-items: center;
}

.button:hover .svgIcon {
  width: 50px;
  transition-duration: .3s;
  transform: translateY(60%);
}

.button::before {
  top: -20px;
  content: "Supprimer";
  color: white;
  transition-duration: .3s;
  font-size: 10px;
}

.button:hover::before {
  font-size: 0px;
  opacity: 1;
  transform: translateY(30px);
  transition-duration: .3s;
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               <div class=bienvenu>
                <li class="nav-item">
                    <span class="nav-link welcome-text">Bienvenue, <?php echo $_SESSION['email']; ?>!</span>
                </li>
                </div>
                <ul class=barre>
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#a-propos">À propos</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
                </ul>              
                <button class="Btn">
                   <div class="sign">
                    <svg viewBox="0 0 512 512">
                        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                    </svg>
                </div>
                <a href="./logout.php" class="text">Logout</a>
               </button>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<br>
<br>
<br>
    <div style="float: right;">
    <a href="create.php" class="btn btn-success">Créer une nouvelle idée</a>
    </div>
    <?php 
/* Inclure le fichier config */
require_once "config.php";
                    
$sql = "SELECT Idee.id, Idee.titre, Idee.description, Idee.date_creation, Idee.statut, Categorie.nom AS nom_categorie, Idee.contenu, Utilisateurs.prenom AS prenom_utilisateur 
        FROM Idee 
        LEFT JOIN Categorie ON idee.id_categorie = categorie.id 
        LEFT JOIN Utilisateurs ON idee.ID_utilisateurs = utilisateurs.ID";
                    
if($result = mysqli_query($pdo, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo '<table class="table table-bordered table-striped">';
        echo "<thead>";
        echo "<tr>";
       // echo "<th>ID</th>";
        echo "<th>Titre</th>";
        echo "<th>Description</th>";
        echo "<th>Date création</th>";
        echo "<th>Statut</th>";
        echo "<th>Contenu</th>";
        echo "<th>Catégories</th>";
        echo "<th>Utilisateurs</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            //echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['titre'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['date_creation'] . "</td>";
            echo "<td>" . $row['statut'] . "</td>";
            echo "<td>" . $row['contenu'] . "</td>";
            echo "<td>" . $row['nom_categorie'] . "</td>";
            echo "<td>" . $row['prenom_utilisateur'] . "</td>";
            echo "<td>";
            echo '<a href="read.php?id=' . $row['id'] . '" class="btn btn-primary me-3"><span class="bi bi-eye"></span> Lire</a>';

// Vérifiez si l'utilisateur est autorisé à effectuer des mises à jour
//if ($user_is_authorized_to_update) {
            echo '<a href="update.php?id=' . $row['id'] . '" class="btn btn-warning me-3"><span class="bi bi-pencil"></span> Modifier</a>';
//}

// Vérifiez si l'utilisateur est autorisé à supprimer
///if ($user_is_authorized_to_delete) {
            echo '<a href="delete.php?id=' . $row['id'] . '" <button class="button">
            <svg viewBox="0 0 448 512" class="svgIcon"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg>
             </button></a>';
//}
            echo "</td>";

            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
    }
} else {
    echo "Oops! Une erreur est survenue";
}

/* Fermer connection */
mysqli_close($pdo);
?>

</body>
</html>
 