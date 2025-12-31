<?php
$host = "localhost";
$dbname = "todo_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    //$pdo une avriable de type PDO; la chaine de connection
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //rapport d'erreur 
} 
catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
    //arreter le script, afficher le message d'erreur
}

// try {
//     $stmt = $pdo->query("SELECT * FROM utilisateur");
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     echo "Table utilisateur OK :<br>";
//     echo "<pre>";
//     print_r($users);
//     echo "</pre>";
// } catch (PDOException $e) {
//     echo "Erreur table utilisateur : " . $e->getMessage();
// }
?>

