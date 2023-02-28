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

            ///Affiche le formulaire de joueur pres remplie
            if($recipes = $req->fetch()) {
                echo '
                <form method="post" enctype="multipart/form-data">
                    <p> Nom : <input type="text" name= "nom" required value="'.$recipes["nom"].'"/></p>
                    <p> Prenom : <input type="text" name="prenom" required value="'.$recipes["prenom"].'"/></p>
                    <p> Photo : <input type="file" name="photo"/> (saisir uniquement si modification souhaité | formats supportés : .png, .jpeg, .jpg | taille maximale : 3 Mo)</p>
                    <p> Date de naissance : <input type = "date" name="date" max = "2009-12-31" min="1970-12-31" required value="'.$recipes["dateNaissance"].'"/></p>
                    <p> Poids : <input type = "number" placeholder= "en kg" min = "50" max = "120" name = "poids" required value="'.$recipes["poids"].'"/></p>
                    <p> Taille : <input type = "number" placeholder= "en cm" min = "130" max = "220" name ="taille" required value="'.$recipes["taille"].'"/></p>
                    ';
                if($recipes["postePrefere"]=="premier"){
                    echo '<p> Poste Préféré : <input type="radio"  name="poste" value="premier" checked><label for="premier">premier coureur</label>';
                } else {
                    echo '<p> Poste Préféré : <input type="radio"  name="poste" value="premier" ><label for="premier">premier coureur</label>';
                }
                if($recipes["postePrefere"]=="second"){
                    echo '<input type="radio"  name="poste" value="second" checked> <label for="second">second coureur</label>';
                } else {
                    echo '<input type="radio"  name="poste" value="second"> <label for="second">second coureur</label>';
                }
                if($recipes["postePrefere"]=="troisieme"){
                    echo '<input type="radio"  name="poste" value="troisieme" checked> <label for="troisieme">troisième coureur</label>';
                } else {
                    echo '<input type="radio"  name="poste" value="troisieme"> <label for="troisieme">troisième coureur</label>';
                }
                if($recipes["postePrefere"]=="quatrieme"){
                    echo '<input type="radio"  name="poste" value="quatrieme" checked> <label for="quatrieme">quatrième coureur</label></p>';
                } else {
                    echo '<input type="radio"  name="poste" value="quatrieme"> <label for="quatrieme">quatrième coureur</label></p>';
                }
                if($recipes["statut"]=="actif"){
                    echo '<p>Statut : <input type="radio"  name="statut" value="actif" checked><label for="actif">Actif</label>';
                } else {
                    echo '<p>Statut : <input type="radio"  name="statut" value="actif" ><label for="actif">Actif</label>';
                }
                if($recipes["statut"]=="blesse"){
                    echo '<input type="radio" name="statut" value="blesse" checked><label for="blesse">Blessé</label>';
                } else {
                    echo '<input type="radio" name="statut" value="blesse"><label for="blesse">Blessé</label>';
                }
                if($recipes["statut"]=="suspendu"){
                    echo '<input type="radio" name="statut" value="suspendu" checked><label for="suspendu">Suspendu</label>';
                } else {
                    echo '<input type="radio" name="statut" value="suspendu"><label for="suspendu">Suspendu</label>';
                }
                if($recipes["statut"]=="absent"){
                    echo '<input type="radio" name="statut" value="absent" checked><label for="absent">Absent</label></p>';
                } else {
                    echo '<input type="radio" name="statut" value="absent"><label for="absent">Absent</label></p>';
                }        
                echo '
                    <p> Commentaire * : <input type = "text" name="commentaire" value="'.$recipes["commentaire"].'"/></p>   <br>
                    <input type="submit" name="sub" value="Annuler"/> <input type="submit" name="sub" value="Modifier"/>
                </form>
                ';
            } else {
                die('Erreur de recuperation des donnees'); 
            }

            ///Preparation de la requete
           $req3 = $linkpdo->prepare('
                UPDATE Joueur SET
                nom = :nom,
                prenom = :prenom,
                dateNaissance = :dateNaissance,
                poids = :poids,
                taille = :taille,
                postePrefere = :poste,
                commentaire = :com,
                statut = :statut
                WHERE numLicence = '.$_GET["id"]
            ); ///voir pour poste sur la bd

            ///Celon les choix de l'utilisateur moddi le joueur ou non
            if(isset($_POST["sub"])){
                if($_POST["sub"] == "Modifier") {
                    if ($req3->execute(array(
                        'nom' => $_POST["nom"],
                        'prenom' => $_POST["prenom"],
                        'dateNaissance' => $_POST["date"],
                        'poids' => $_POST["poids"],
                        'taille' => $_POST["taille"],
                        'poste' => $_POST["poste"],
                        'com' => $_POST["commentaire"],
                        'statut' => $_POST["statut"]))
                        ) {
                                ///Sauvegarde de la nouvelle
                                // Testons si le fichier n'est pas trop gros
                                if (isset($_FILES['photo']) && ($_FILES['photo']['error'] == 0))
                                    {
                                    // Testons si le fichier n'est pas trop gros
                                    if ($_FILES['photo']['size'] <= 3145728) {
                                        // Testons si l'extension est autorisée
                                        $infosfichier = pathinfo($_FILES['photo']['name']);
                                        $extension_upload = $infosfichier['extension'];
                                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                                        if (in_array($extension_upload, $extensions_autorisees))
                                        {
                                                ///Suppresion de l'ancienne image
                                                $req2 = $linkpdo->prepare("SELECT photo FROM Joueur WHERE numLicence = ".$_GET["id"]);
                                                if (!($req2 -> execute())) {
                                                    echo("Erreur lors de l'enregistrement image : ");
                                                    $req2->debugDumpParams();
                                                }
                                                $recipes = $req2->fetch();
                                                unlink('img/'.$recipes["photo"]);
                                
                                                // On peut valider le fichier et le stocker définitivement
                                                move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . $_GET["id"].".".$infosfichier['extension']);
                                                $photo=$_GET["id"].".".$infosfichier['extension'];
                                                echo "L'envoi a bien été effectué !";
                                        }
                                        else
                                        {
                                            echo 'extention non-autorisee';
                                        }
                                    }
                                    else
                                    {
                                        echo 'image trop grosse';
                                    }
                                } else {
                                    echo 'probleme a l\'envoi';
                                    echo $_FILES['photo']['error'];
                                }
                            echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/detailsJoueur.php?id='.$_GET["id"].'"/>';
                    } else {
                        echo("Erreur lors de l'enregistrement");
                        $req3->debugDumpParams();
                    }
                }else if($_POST["sub"] == "Annuler") {
                    echo '<meta http-equiv="Refresh" content="0; url=
                                    https://fl-project.000webhostapp.com/detailsJoueur.php?id='.$_GET["id"].'"/>';
                }
            }
            
        ?>
    </body>
</html>
