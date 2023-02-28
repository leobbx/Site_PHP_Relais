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
    die('Erreur : ' . $e->getMessage());
}

///Préparation de la requête
$licence = $_POST["licence"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
if (isset($_FILES['photo']) && ($_FILES['photo']['error'] == 0))
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 3145728)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . $licence.".".$infosfichier['extension']);
                        $photo=$licence.".".$infosfichier['extension'];
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

$date = $_POST["date"];
$poids = $_POST["poids"];
$taille = $_POST["taille"];
$poste = $_POST["poste"];
$statut = $_POST["statut"];
$com = $_POST["commentaire"];

if($_POST["sub"]=="Envoyer") {
    $req = $linkpdo->prepare('INSERT INTO Joueur VALUES(:licence,:nom, :prenom, :photo, :dateNaissance, :poids, :taille, :poste, :commentaire, :statut)');
    ///Exécution de la requête
    if ($req->execute(array(
        'licence' => $licence,
        'nom' => $nom,
        'prenom' => $prenom,
        'photo' => $photo,
        'dateNaissance' => $date,
        'poids' => $poids,
        'taille' => $taille,
        'poste' => $poste,
        'commentaire' => $com,
        'statut' => $statut))
        ) {
    echo '    <meta http-equiv="Refresh" content="0; url=https://fl-project.000webhostapp.com/afficherJoueur.php" />';
    } else {
        echo("Erreur lors de l'enregistrement");
        $req->debugDumpParams();
    }
}
?>