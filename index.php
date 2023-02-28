<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceuil</title>
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
    </body>
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
    } catch (Exception $e) {
        die('Erreur lien bd : '.$e->getMessage());
    }
    
    echo '<h1>Effectif</h1>';
    $req = $linkpdo -> prepare("SELECT photo, nom, prenom, statut FROM Joueur");
    $req->execute();
    echo '<table>';
    echo '
       <tbody>
       <tr><th>Photo</th> <th>Nom</th> <th>Prénom</th> <th>Statut</th></tr>';
    while ($recipe = $req -> fetch()) {
       echo '<tr>
           <td><a href = "afficherJoueur.php"><img src="img/'.$recipe["photo"].'" alt="Image de profil" width=120px height=120px> </td></a>
           <td>'.$recipe["nom"].'</td>
           <td>'.$recipe["prenom"].'</td>
           <td>'.$recipe["statut"].'</td>
       </tr>';
    }
    
      echo '</tbody>
       </table>';
       
    echo '<h1>Match</h1>';
    $req1 = $linkpdo->prepare("SELECT dateMatch, heureMatch, nomEquipeAdverse, lieuDeRencontre FROM Matchs");
    $req1->execute();
    echo '<table>';
    echo '
       <tbody>
       <tr><th>Date</th> <th>Heure</th> <th>Adversaire</th> <th>Lieu de rencontre</th></tr>';
    while ($recipes = $req1 -> fetch()) {
       echo '<tr>
           <td>'.$recipes["dateMatch"].'</td>
           <td>'.$recipes["heureMatch"].'</td>
           <td>'.$recipes["nomEquipeAdverse"].'</td>
           <td>'.$recipes["lieuDeRencontre"].'</td>
       </tr>';
    }
    
    echo '</tbody>
       </table>';
       
    echo '<h1> Statistiques</h1>';
    $req2 = $linkpdo->prepare("SELECT COUNT(*) AS matchsj FROM Matchs WHERE gagner is not null");
    $req2->execute();
    $matchjouer = $req2->fetch();
    $req3 = $linkpdo->prepare("SELECT COUNT(gagner) AS matchg FROM Matchs WHERE gagner = 1");
    $req3->execute();
    $matchgagne = $req3 -> fetch();
    $req4 = $linkpdo->prepare("SELECT COUNT(gagner) AS matchp FROM Matchs WHERE gagner = 0");
    $req4->execute();
    $matchperdu = $req4 -> fetch(); 
    $pourcentageg = (($matchgagne["matchg"]/$matchjouer["matchsj"])*100);
    $pourcentagep = (($matchperdu["matchp"]/$matchjouer["matchsj"])*100);
     echo '</br>';
            echo '<table>';
            echo '
            <tbody>
            <tr><th>Matchs joués</th> <th>Matchs gagnés</th> <th>Match perdu</th> <th>Pourcentage de courses gagnés</th><th>Pourcentage courses perdus </th></tr>
            <tr>
                <td>'.$matchjouer["matchsj"].'</td>
                <td>'.$matchgagne["matchg"].'/'.$matchjouer["matchsj"].'</td>
                <td>'.$matchperdu["matchp"].'/'.$matchjouer["matchsj"].'</td>
                <td>'.round($pourcentageg,2).' %</td>
                <td>'.round($pourcentagep,2).' %</td>
            </tr>
            </tbody>
            </table>';
    

    ?>
</html>