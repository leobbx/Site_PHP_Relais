<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">

    </head>
    <body>
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

            ///Demande la confirmation
            echo '
            <h1> Êtes vous sur de vouloir supprimer la feuille de match</h1>
            <form method="post">
                <input type="submit" name="sub" value="Supprimer"/>
                <input type="submit" name="sub" value="Annuler"/>
            </form>
            ';

            ///Selon les choix de l'utilisateur supprime le joueur ou non
            if(isset($_POST["sub"])){
                if($_POST["sub"] == "Supprimer") {
                    $req = $linkpdo->prepare("DELETE FROM Participer WHERE id_matchs = ".$_GET["id"]);
                    $re1 = $linkpdo->prepare("UPDATE Matchs SET gagner = NULL WHERE id_matchs = ".$_GET["id"]);
                    if ($req -> execute()) {
                        echo '<meta http-equiv="Refresh" content="0; url=https://fl-project.000webhostapp.com/affichermatch.php"/>';
                    } else {
                        echo("Erreur lors de l'enregistrement : ");
                        $req->debugDumpParams();
                    }
                }else if($_POST["sub"] == "Annuler") {
                    echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/detailsmatch.php?id='.$_GET["id"].'"/>';
                }
            }
        ?>
    </body>
</html>