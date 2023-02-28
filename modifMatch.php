<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modification</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <ul class="menu">
              <li>
                <a href="index.html" class="actif">Acceuil</a>
              </li>
              <li>
                <a href="afficherJoueur.php">Joueur</a>
              </li>
              <li>
                <a href="affichermatch.php">Match</a>
              </li>
        </ul>
        <?php
        session_start();
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

            ///Affiche le formulaire de joueur pres remplie
            if($recipes = $req->fetch()) {
                echo '<form method="post">
                <p> Date du match : <input type="date" name="datem" value="'.$recipes["dateMatch"].'" required/> </p>
                <p> Heure du match : <input type="time" name= "heure" min ="8:00" max = "20:00" value="'.$recipes["heureMatch"].'" required/></p>
                <p> Nom de l \' equipe adverse : <input type="text" name="nom" value="'.$recipes["nomEquipeAdverse"].'" required/></p>
                <p> Lieu de rencontre : <input type = "text" name="lieu" value="'.$recipes["lieuDeRencontre"].'"required/></p>
                <input type="submit" name="sub" value="Annuler"/> <input type="submit" name="sub" value="Modifier"/>
                </form>';
            } else {
                die('Erreur de recuperation des donnees'); 
            }

            ///Preparation de la requete
           $req3 = $linkpdo->prepare('
                UPDATE Matchs SET
                dateMatch = :date,
                heureMatch = :heure,
                nomEquipeAdverse = :nom,
                lieuDeRencontre = :lieu
                WHERE id_matchs = '.$_GET["id"]
            );

            ///Celon les choix de l'utilisateur moddi le joueur ou non
            if(isset($_POST["sub"])){
                if($_POST["sub"] == "Modifier") {
                    if ($req3->execute(array(
                        'date' => $_POST["datem"],
                        'heure' => $_POST["heure"],
                        'nom' => $_POST["nom"],
                        'lieu' => $_POST["lieu"]))
                        ) {
                        echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/detailsmatch.php?id='.$_GET["id"].'"/>';
                    } else {
                        echo("Erreur lors de l'enregistrement");
                        $req3->debugDumpParams();
                    }
                }else if($_POST["sub"] == "Annuler") {
                    echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/detailsmatch.php?id='.$_GET["id"].'"/>';
                }
            }
        ?>
    </body>
</html>
