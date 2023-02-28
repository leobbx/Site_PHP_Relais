<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Details</title>
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

            ///Préparation de la requête
            $req = $linkpdo->prepare('SELECT * FROM Joueur WHERE numLicence = :id');    
            if($req == false) {
                die('Erreur creation requete');
            }

            ///Exécution de la requête avec les paramètres passés sous forme de tableau indexé
            $req2 = $req->execute(array('id' => $_GET["id"]));
            if($req2 == false) {
                die('Erreur execution requete');
            }

            ///Affichage des valeurs
            if($recipes = $req->fetch()) {
                echo '
                <img src="img/'.$recipes["photo"].'" alt="Image de profil" width=100px height=100px>
                <ul>
                    <li>Numéro de licence : '.$recipes["numLicence"].'</li>
                    <li>Nom : '.$recipes["nom"].'</li>
                    <li>Prenom : '.$recipes["prenom"].'</li>
                    <li>Date de naissance : '.$recipes["dateNaissance"].'</li>
                    <li>Poids : '.$recipes["poids"].'</li>
                    <li>Taille : '.$recipes["taille"].'</li>
                    <li>Poste favori : '.$recipes["postePrefere"].'</li>
                    <li>Commentaire : '.$recipes["commentaire"].'</li>
                    <li>Statut : '.$recipes["statut"].'</li>
                </ul>
                <a href="modifJoueur.php?id='.$_GET["id"].'">Modifier</a>
                <a href="suprJoueur.php?id='.$_GET["id"].'">Supprimer</a>
                ';
                 echo '</br>';
            } else {
                die('Erreur de recuperation des donnees'); 
            }
            $reqnbsectitu = $linkpdo -> prepare('SELECT numLicence, COUNT(numLicence) AS nbmatchst FROM Participer WHERE numLicence ='.$_GET["id"].' and titulaire = 1 GROUP BY numLicence');
            $reqnbsecremp = $linkpdo -> prepare('SELECT numLicence, COUNT(numLicence) AS nbmatchsr FROM Participer WHERE numLicence ='.$_GET["id"].' and titulaire = 0 GROUP BY numLicence');
            $reqmoyenne = $linkpdo -> prepare('SELECT AVG(performance) AS mmatchs FROM Participer WHERE numLicence ='.$_GET["id"].' GROUP BY numLicence');
            $reqmatchgagné = $linkpdo -> prepare('SELECT COUNT(*) AS matchgagne FROM Matchs, Participer, Joueur WHERE Matchs.id_matchs = Participer.id_matchs AND Participer.numLicence = Joueur.numLicence AND gagner = 1 AND Joueur.numLicence = '.$_GET["id"]);
            $reqnbsectitu -> execute();
            $reqnbsecremp -> execute();
            $reqmoyenne -> execute();
            $reqmatchgagné -> execute();
            $recipetitu = $reqnbsectitu -> fetch();
            $reciperemp = $reqnbsecremp -> fetch();
            $recipemoy =  $reqmoyenne -> fetch();
            $recipmatchgagné = $reqmatchgagné -> fetch();
            $pourcentage = ($recipmatchgagné["matchgagne"] / ($reciperemp["nbmatchsr"] + $recipetitu["nbmatchst"]))*100;
            echo '</br>';
            echo '<table>
            <thead>
            <tr>
                <th colspan="9">Statistiques du joueurs</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Moyenne note du coach : '.round($recipemoy["mmatchs"],2).'/5</td>
                <td>Nombre de titularisation : '.$recipetitu["nbmatchst"].'</td>
                <td>Nombre de match commencé sur le banc : '.$reciperemp["nbmatchsr"].'</td>
                <td>Pourcentage de match gagné : '.round($pourcentage,2).' %</td>
            </tr>
            </tbody>
            </table>';
        ?>
        </br>
        <a href="afficherJoueur.php">Retour</a>
    </body>
</html>