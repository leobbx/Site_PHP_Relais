<?php
$server = "127.0.0.1";
$db = "exercice";
$login = "root";
///Connexion au serveur MySQL
try {
$linkpdo = new PDO("mysql:host=$server;dbname=$db", $login);
}
catch (Exception $e) {
die('Erreur : ' . $e->getMessage());
}
$id = $_GET["id"];
$nom = $_GET["nom"];
$prenom = $_GET["prenom"];
$adresse = $_GET["adresse"];
$codepostal = $_GET["codepostal"];
$ville = $_GET["ville"];
$telephone = $_GET["telephone"];

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">  
</head>
<h1> Êtes vous sur de vouloir supprimer l enregistrement</h1>
<form method="get">
    <input type="submit" name="sub" value="Supprimer"/> <input type="submit" name="sub" value="Annuler"
    </form>
</html>';
if (empty($_GET["sub"])){
    $req = $linkpdo->prepare('SELECT * FROM contact');
}else if($_GET["sub"] == "Supprimer") {
    $req = $linkpdo->prepare("DELETE FROM contact WHERE id = 6");
    $req -> execute();
    echo '    <meta http-equiv="Refresh" content="0; url=http://localhost/recherche.php" />';
}else if($_GET["sub"] == "Annuler") {
    echo '    <meta http-equiv="Refresh" content="0; url=http://localhost/recherche.php" />';
}

?>