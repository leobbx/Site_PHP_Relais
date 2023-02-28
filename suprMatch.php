<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">

    </head>
    <body>
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

            ///Demande la confirmation
            echo '
            <h1> Êtes vous sur de vouloir supprimer l\'enregistrement</h1>
            <form method="post">
                <input type="submit" name="sub" value="Supprimer"/>
                <input type="submit" name="sub" value="Annuler"/>
            </form>
            ';

            ///Celon les choix de l'utilisateur supprime le joueur ou non
            if(isset($_POST["sub"])){
                if($_POST["sub"] == "Supprimer") {
                    $req = $linkpdo->prepare("DELETE FROM Matchs WHERE id_matchs = ".$_GET["id"]);
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