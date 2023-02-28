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
    
    <h3> Remplir la feuille de match</h3>
    <p> Rentrer tout d'abord vos 4 titulaires puis vos 2 remplaçants</p>
    <?php
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

    $req1 = $linkpdo->prepare('SELECT numLicence, nom, prenom FROM Joueur WHERE statut = "actif" ORDER BY 1');

    echo '<form method= post>';
            
    for($i = 0;$i < 4; $i++ ) {
        echo '<fieldset>';
        echo '<label for="joueur">Joueur  :</label>';
        echo ' <select id = "joueurs" name= "joueurs">';
        $req1 -> execute();
        while($recipes = $req1->fetch()) {
           echo '<option value ='.$recipes["numLicence"].' name = "joueur">'.$recipes["nom"].','.$recipes["prenom"].'</option>';
          
        }
        echo '</select>
        </br>
        <p> Performance : <input type = "number" min = "1" max = "5" name = "perf" required>';
        echo '</br>';
         echo '</fieldset>';
    }
    echo '<input type="reset" name="sub" value="Reintialiser"/> <input type="submit" name="sub" value="Envoyer"/>';
        echo '</form>';
    echo'</br>';
    $req2 = $linkpdo->prepare('INSERT INTO Participer VALUES (:performance, :titulaire,:numLicence,:id_matchs)');
    if(isset($_POST["sub"])){
                if($_POST["sub"] == "Envoyer") {
                    $req2 = $linkpdo -> execute(array('performance' => $POST["perf"], 'titulaire' => 1, 'numLicence' => $POST["joueur"], 'id_matchs' => $_GET["id"]));
                }
        }
    
    $req = $linkpdo->prepare('SELECT numLicence, nom, prenom FROM Joueur WHERE statut = "actif" ORDER BY 1');
    echo '<form method= post>
            <fieldset>';
    for($i = 0;$i < 2; $i++ ) {
        echo '<label for="joueur">Joueur  :</label>';
        echo ' <select id = "joueursrem" name= "joueursrem">';
        $req -> execute();
        while($recipe = $req->fetch()) {
           echo '<option value ='.$recipe["numLicence"].' name = "joueurr">'.$recipe["nom"].','.$recipe["prenom"].'</option>';
        }
        echo '</select>
        </br>
        <p> Performance : <input type = "number" min = "1" max = "5" name = "perfo" required>';
        echo '</br>';
        echo '</fieldset>';
        $req1 = $linkpdo->prepare('INSERT INTO Participer VALUES (:performance, :titulaire,:numLicence,:id_matchs)');
    }
    echo'<input type="reset" name="sub" value="Reintialiser"/> <input type="submit" name="sub" value="Envoyer"/>';
    echo '</form>';
    echo '</br>';
    if(isset($_POST["sub"])){
            if($_POST["sub"] == "Envoyer") {
                $req1 = $linkpdo -> execute(array('performance' => $POST["perfo"], 'titulaire' => 0, 'numLicence' => $POST["joueurr"], 'id_matchs' => $_GET["id"]));
            }
        }
    
    $req3 = $linkpdo-> prepare("UPDATE Matchs SET gagner = :valeur WHERE id_matchs = ".$_GET["id"]);
    echo '<form method= post>
    <label for="matchs">Resultat de la course</label>
    <select id = "matchs">
        <option value = 1 name = "valeur"> Gagner </option> 
        <option value = 0 name = "valeur"> Perdu </option>
    </select>';
    
    echo '<input type="submit" name="subres" value="Enregistrer"/>';
    echo '</form>';
    if(isset($_POST["subres"])){
            if($_POST["subres"] == "Envoyer") {
                $req3 = $linkpdo -> execute(array('valeur' => $POST["valeur"]));
            }
        }
    
    ?>