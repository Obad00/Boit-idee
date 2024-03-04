<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'Boite');
define('DB_USER', 'root');
define('DB_PASS', 'Sqlobad64');

function connect()
{
    $pdo = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($pdo->connect_error) {
        die("Erreur de connexion à la base de données : " . $pdo->connect_error);
    }

    return $pdo;
}

// Appel de la fonction connect() pour obtenir la connexion
$pdo = connect();

