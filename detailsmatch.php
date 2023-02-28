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
            $req = $linkpdo->prepare('SELECT * FROM Matchs WHERE id_matchs = :id');    
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
                <ul>
                    <li>Date du match : '.$recipes["dateMatch"].'</li>
                    <li>Heure du match : '.$recipes["heureMatch"].'</li>
                    <li>Nom équipe adverse : '.$recipes["nomEquipeAdverse"].'</li>
                    <li>Lieu de la rencontre : '.$recipes["lieuDeRencontre"].'</li>
                </ul>
                <a href="modifMatch.php?id='.$_GET["id"].'">Modifier</a>
                <a href="suprMatch.php?id='.$_GET["id"].'">Supprimer</a>
                </br>
                </br>';
                
            } else {
                die('Erreur de recuperation des donnees'); 
            }
            $req1 = $linkpdo -> prepare('SELECT Joueur.photo, Joueur.nom, Joueur.prenom, Participer.titulaire, gagner FROM Joueur, Participer, Matchs WHERE Joueur.numLicence = Participer.numLicence AND Participer.id_matchs = Matchs.id_matchs AND Matchs.id_matchs = '.$_GET["id"].' AND Participer.titulaire = 1');
            $req1 -> execute();
            $recipes = $req1 -> fetch();
            if ($recipes["gagner"] == NULL) {
                echo 'Match non joué';
            } else {
                echo 'Titulaires';
                echo '<table>';
                echo '
                    <tbody>
                    <tr><th>Photo</th> <th>Nom</th> <th>Prénom</th></tr>';
                     while ($recipes = $req1 -> fetch()) {
                        echo '<tr>
                            <td><a href = "afficherJoueur.php"><img src="img/'.$recipes["photo"].'" alt="Image de profil" width=120px height=120px> </td></a>
                            <td>'.$recipes["nom"].'</td>
                            <td>'.$recipes["prenom"].'</td>
                        </tr>';
                        }
                    echo '</tbody>
                    </table>';
                    
                echo '<h4> Remplaçants </h4>';
                $req = $linkpdo -> prepare('SELECT Joueur.photo, Joueur.nom, Joueur.prenom, Participer.titulaire, gagner FROM Joueur, Participer, Matchs WHERE Joueur.numLicence = Participer.numLicence AND Participer.id_matchs = Matchs.id_matchs AND Matchs.id_matchs = '.$_GET["id"].' AND Participer.titulaire = 0');
                $req -> execute();
                echo '<table>';
                echo '
                <tbody>
                <tr><th>Photo</th> <th>Nom</th> <th>Prénom</th></tr>';
                while ($recipe = $req -> fetch()) {
                    echo '<tr>
                    <td><a href = "afficherJoueur.php"><img src="img/'.$recipe["photo"].'" alt="Image de profil" width=120px height=120px> </td></a>
                    <td>'.$recipe["nom"].'</td>
                    <td>'.$recipe["prenom"].'</td>
                    </tr>';
                    }
                echo '</tbody>
                 </table>';
                 
                 echo '<a href="suprfeuillematch.php?id='.$_GET["id"].'">Supprimer feuille de match</a>';
                 echo '</br>';
            $req2 = $linkpdo -> prepare('SELECT gagner FROM Matchs WHERE id_matchs = '.$_GET["id"]);
            $req2 -> execute();
            $recipes3 = $req2 -> fetch();
            if ($recipes3["gagner"] == 1) {
                echo 'Course remporté';
                echo'</br>';
            } else {
                echo 'Course perdu';
                echo'</br>';
            }
            }
        ?>
        <a href="affichermatch.php">Retour</a>
    </body>
</html>