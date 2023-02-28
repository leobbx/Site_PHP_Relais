<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Joueurs</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <ul class="menu">
              <li>
                <a href="index.php" class="actif">Acceuil</a>
              </li>
              <li>
                <a href="afficherJoueur.php">Joueur</a>
              </li>
              <li>
                <a href="affichermatch.php">Match</a>
              </li>
        </ul>
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

<form method="get">
    <p> Prenom : <input type="text" name="prenom" /> </p>
    <input type="submit" name="ok" value="Valider" /> </p>
</form>

<?php
if(!isset($_SESSION['perm']) || $_SESSION['perm']<=0) {
                ///echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/login.php"/>';
                echo 'session = '.$_SESSION['perm'];
            }
 $server = "localhost";
 $db = "id19911480_r205_sport";
 $login = "id19911480_fatileo";
 $password = "NDF4080aBBL4356a*";
///Connexion au serveur MySQL
try {
 $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login,$password);
 }
 catch (Exception $e) {
 die('Erreur : ' . $e->getMessage());
 }


if (!empty($_GET["prenom"])) {
    $req = $linkpdo->prepare('SELECT numLicence, nom, prenom, postePrefere, statut FROM Joueur WHERE prenom = :prenom');
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
            <th colspan="9">Joueurs</th>
        </tr>
        </thead>';
    while($recipes = $req->fetch()) {
       echo '
       <tbody>
       <tr>
           <td>'.$recipes["nom"].'</td>
           <td>'.$recipes["prenom"].'</td>
           <td>'.$recipes["postePrefere"].'</td>
           <td>'.$recipes["statut"].'</td>
           <td><a href = "detailsJoueur.php?id='.$recipes["numLicence"].'">en voir plus</a></td>
       </tr>';
   }
   
      echo '</tbody>
      </table>';
 }else {
 

 ///Préparation de la requête sans les variables (marqueurs : ?)
    $req1 = $linkpdo -> prepare('SELECT numLicence, nom, prenom, postePrefere, statut FROM Joueur ORDER BY 1');
    if($req1 == false) {
        die('Erreur linkpdo');
    }
    $req2 = $req1->execute();
    echo '<table>
        <thead>
        <tr>
            <th colspan="9">Joueurs</th>
        </tr>
        </thead>';
     while($recipes = $req1->fetch()) {
        ///echo $recipes["nom"].'<br/>'.$recipes["prenom"].'<br/>'.$recipes["adresse"].'<br/>'.$recipes["codepostal"].'<br/>'.$recipes["ville"].'<br/>'.$recipes["telephone"];
        
        echo '
        <tbody>
        <tr>
            <td>'.$recipes["nom"].'</td>
            <td>'.$recipes["prenom"].'</td>
            <td>'.$recipes["postePrefere"].'</td>
            <td>'.$recipes["statut"].'</td>
            <td><a href = "detailsJoueur.php?id='.$recipes["numLicence"].'">en voir plus </a></td>
        </tr>';
    }
    
       echo '</tbody>
       </table>';
    
}

echo '<form method="get">
    <input type="submit" name="ajout" value="Ajout" /> </p>
</form>';

if (isset($_GET["ajout"])) {
    echo '    <meta http-equiv="Refresh" content="0; url=https://fl-project.000webhostapp.com/ajoutjoueur.html" />';
}

