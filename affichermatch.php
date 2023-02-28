<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matchs</title>
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
    <p> Date du match : <input type="date" name="datem" /> </p>
    <input type="submit" name="ok" value="Valider" /> </p>
</form>

<?php
if(!isset($_SESSION['perm']) || $_SESSION['perm']<=0) {
                echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/login.php"/>';
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


if (!empty($_GET["datem"])) {
    $req = $linkpdo->prepare('SELECT id_matchs, dateMatch, heureMatch, nomEquipeAdverse, lieuDeRencontre FROM Matchs WHERE dateMatch = :date');
    if(isset($_GET["datem"])) {
       $date = $_GET["datem"];
   }
   if($req == false) {
       die('Erreur linkpdo');
   }
    ///Exécution de la requête avec les paramètres passés sous forme de tableau indexé
    $req2 = $req->execute(array('date' => $date));
     echo '<table>
        <thead>
        <tr>
            <th colspan="9">Matchs</th>
        </tr>
        </thead>';
    while($recipes = $req->fetch()) {
       echo '
       <tbody>
       <tr>
           <td>'.$recipes["dateMatch"].'</td>
           <td>'.$recipes["heureMatch"].'</td>
           <td>'.$recipes["nomEquipeAdverse"].'</td>
           <td>'.$recipes["lieuDeRencontre"].'</td>
           <td><a href = "detailsmatch.php?id='.$recipes["id_matchs"].'">en voir plus</a></td>
       </tr>';
   }
   
      echo '</tbody>
      </table>';
 }else {
 

 ///Préparation de la requête sans les variables (marqueurs : ?)
    $req1 = $linkpdo -> prepare('SELECT id_matchs, dateMatch, heureMatch, nomEquipeAdverse, lieuDeRencontre FROM Matchs Where dateMatch > DATE(NOW()) ORDER BY 1');
    if($req1 == false) {
        die('Erreur linkpdo');
    }
    $req2 = $req1->execute();
    echo '<table>
        <thead>
        <tr>
            <th colspan="9">Matchs à venir</th>
        </tr>
        </thead>';
     while($recipes = $req1->fetch()) {
        ///echo $recipes["nom"].'<br/>'.$recipes["prenom"].'<br/>'.$recipes["adresse"].'<br/>'.$recipes["codepostal"].'<br/>'.$recipes["ville"].'<br/>'.$recipes["telephone"];
        
        echo '
        <tbody>
        <tr>
            <td>'.$recipes["dateMatch"].'</td>
            <td>'.$recipes["heureMatch"].'</td>
            <td>'.$recipes["nomEquipeAdverse"].'</td>
            <td>'.$recipes["lieuDeRencontre"].'</td>
            <td><a href = "detailsmatch.php?id='.$recipes["id_matchs"].'">en voir plus </a></td>
        </tr>';
    }
    
       echo '</tbody>
       </table>';
    
    $req1 = $linkpdo -> prepare('SELECT id_matchs, dateMatch, heureMatch, nomEquipeAdverse, lieuDeRencontre FROM Matchs Where dateMatch < DATE(NOW()) ORDER BY 1');
    if($req1 == false) {
        die('Erreur linkpdo');
    }
    $req2 = $req1->execute();
    echo '</br>
    <table>
        <thead>
        <tr>
            <th colspan="9">Matchs déjà disputés </th>
        </tr>
        </thead>';
     while($recipes = $req1->fetch()) {
        ///echo $recipes["nom"].'<br/>'.$recipes["prenom"].'<br/>'.$recipes["adresse"].'<br/>'.$recipes["codepostal"].'<br/>'.$recipes["ville"].'<br/>'.$recipes["telephone"];
         $requete = $linkpdo -> prepare('SELECT COUNT(*) FROM Participer WHERE id_matchs = '.$recipes["id_matchs"]);
         $requete -> execute();
         
        echo '
        <tbody>
        <tr>
            <td>'.$recipes["dateMatch"].'</td>
            <td>'.$recipes["heureMatch"].'</td>
            <td>'.$recipes["nomEquipeAdverse"].'</td>
            <td>'.$recipes["lieuDeRencontre"].'</td>';
      $recipe = $requete -> fetch();
        if ($recipe["COUNT(*)"] == 0) {
            echo '    
            <td><a href = "feuilledematch.php?id='.$recipes["id_matchs"].'">Remplir feuille de match </a></td>';
        } else {
            echo '    <td><a href = "detailsmatch.php?id='.$recipes["id_matchs"].'">Afficher feuille de match </a></td>';
            }
            
       echo '</tr>';
    }
    
       echo '</tbody>
       </table>
       </br>';
}

echo '<form method="get">
    <input type="submit" name="ajout" value="Ajout" /> </p>
</form>';

if (isset($_GET["ajout"])) {
    echo '    <meta http-equiv="Refresh" content="0; url=https://fl-project.000webhostapp.com/ajoutmatch.html" />';
}

