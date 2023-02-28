<?php
    ///Démarrage de l’environnement de session
    session_start();
?>
<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset ="utf-8">
    <link rel='stylesheet' href = "index.css">
    </head>
    <body>
        <?php
            ///Celon les choix de l'utilisateur moddi le joueur ou non
            if(isset($_POST["sub"])){
                if($_POST["sub"] == "Se connecter") {
                    if ($_POST["login"]=="admin" && sha1($_POST['password'])=='d033e22ae348aeb5660fc2140aec35850c4da997'){
                        $_SESSION['perm'] = 1;
                    }
                }
            }

            ///Affiche le formulaire de joueur pres remplie
            if(!isset($_SESSION['perm']) || $_SESSION['perm']<=0) {
                echo '
                <form method="post" enctype="multipart/form-data">
                <div class="box">
                <h1> Connexion </h1>
                    <p> Login  <input type="text" name= "login" class = "login" required/></p>
                    <p> Password  <input type="password" name="password" class = "password" required/></p>
                    <input type="submit" name="sub" value="Se connecter" class="btn"/>
                </form>
                </div>';
            } else {
                echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/index.php"/>';
            }
        ?>
    </body>
</html>