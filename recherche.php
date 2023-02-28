
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
</head>
<style type="text/css">
table,
td {
    border: 1px solid black;
}
thead,
tfoot {
    background-color: #333;
    color: #fff;
}

</style>
<h1> Entrer le prenom de la variable recherché <h1>

<form method="get">
    <p> Prenom : <input type="text" name="prenom" /> </p>
    <input type="submit" name="ok" value="Valider" /> </p>
</form>

<?php
 $server = "127.0.0.1";
 $db = "id19911480_r205_sport";
 $login = "id19911480_fatileo";
///Connexion au serveur MySQL
try {
 $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login);
 }
 catch (Exception $e) {
 die('Erreur : ' . $e->getMessage());
 }



 ///Préparation de la requête sans les variables (marqueurs : ?)
 if (empty($_GET["prenom"])){
    $req1 = $linkpdo -> prepare('SELECT * FROM contact');
 } else {
    $req = $linkpdo->prepare('SELECT * FROM contact WHERE prenom = :prenom');
    if(isset($_GET["prenom"])) {
       $prenom = $_GET["prenom"];
   }
   if($req == false) {
       die('Erreur linkpdo');
   }
    ///Exécution de la requête avec les paramètres passés sous forme de tableau indexé
    $req2 = $req->execute(array('prenom' => $prenom));
    echo '<table>
       <thead>
       <tr>
           <th colspan="9">Votre Utilisateur</th>
       </tr>
       </thead>';
   
       if ($req2 == false) {
           $req2 -> debugDumpParams();
       }
    while($recipes = $req->fetch()) {
       ///echo $recipes["nom"].'<br/>'.$recipes["prenom"].'<br/>'.$recipes["adresse"].'<br/>'.$recipes["codepostal"].'<br/>'.$recipes["ville"].'<br/>'.$recipes["telephone"];
       echo '
       <tbody>
       <tr>
           <td>'.$recipes["id"].'</td>
           <td>'.$recipes["nom"].'</td>
           <td>'.$recipes["prenom"].'</td>
           <td>'.$recipes["adresse"].'</td>
           <td>'.$recipes["codepostal"].'</td>
           <td>'.$recipes["ville"].'</td>
           <td>'.$recipes["telephone"].'</td>
           <td><a href = "modification.php?id='.$recipes["id"].'&nom='.$recipes["nom"].'&prenom='.$recipes["prenom"].'&adresse='.$recipes["adresse"].'&codepostal='.$recipes["codepostal"].'&ville='.$recipes["ville"].'&telephone='.$recipes["telephone"].'"> Modification</a></td>
           <td><a href = "suppression.php?id='.$recipes["id"].'&nom='.$recipes["nom"].'&prenom='.$recipes["prenom"].'&adresse='.$recipes["adresse"].'&codepostal='.$recipes["codepostal"].'&ville='.$recipes["ville"].'&telephone='.$recipes["telephone"].'"> Suppression</a></td>
       </tr>';
   }
   
      echo '</tbody>
      </table>';
 }
 


