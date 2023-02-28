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
<form method="get">
    <p> ID : <input type="text" name"id" value='.$id.' disabled="disabled"> </p>
    <p> Nom : <input type="text" name="nnom" value='.$nom.'> </p>
    <p> Prenom : <input type="text" name="nprenom" value ='.$prenom.'></p>
    <p> Adresse : <input type="text" name="nadresse" value ='.$adresse.'></p>
    <p> Code Postal : <input type="text" name="ncode" value = '.$codepostal.'></p>
    <p> Ville : <input type="text" name="nville" value = '.$ville.'></p>
    <p> Téléphone : <input type="tel" name="ntel" value ='.$telephone.'></p>
    <input type="submit" name="sub" value="Envoyer">
</form>
</html>';
if(empty($_GET["nnom"]) || empty($_GET["nprenom"]) || empty($_GET["nadresse"]) ||empty($_GET["ncode"]) || empty($_GET["nville"])|| empty($_GET["ntel"])){
    $req = $linkpdo->prepare('SELECT * FROM contact WHERE prenom = :prenom');
   }else{
$newnom = $_GET["nnom"];
$newprenom = $_GET["nprenom"];
$newadresse = $_GET["nadresse"];
$newcodepostal = $_GET["ncode"];
$newville = $_GET["nville"];
$newtel = $_GET["ntel"];
if($_GET["sub"]=="Envoyer") {
    $req = $linkpdo->prepare("UPDATE contact SET nom = :newnom, prenom = :newprenom, adresse= :newadresse, codepostal = :newcodepostal, ville = :newville, telephone = :newtel WHERE id= 3");
    $req->execute(array(
        'newnom' => $newnom,
        'newprenom' => $newprenom,
        'newadresse' => $newadresse,
        'newcodepostal' => $newcodepostal,
        'newville' => $newville,
        'newtel' => $newtel
        ));   
    echo '    <meta http-equiv="Refresh" content="0; url=http://localhost/recherche.php" />';
    }}

?>