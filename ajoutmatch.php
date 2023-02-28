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
$date = $_POST["datem"];
$heure = $_POST["heure"];
$nom = $_POST["nom"];
$lieu = $_POST["lieu"];

if($_POST["sub"]=="Envoyer") {
    $req = $linkpdo->prepare('INSERT INTO Matchs VALUES(NULL,:dateMatch, :heureMatch, :nomEquipeAdverse, :lieuDeRencontre, :gagner)');
    ///Exécution de la requête
    if ($req->execute(array(
        'dateMatch' => $date,
        'heureMatch' => $heure,
        'nomEquipeAdverse' => $nom,
        'lieuDeRencontre' => $lieu,
        'gagner' => NULL
        ))
        ) {
    echo '    <meta http-equiv="Refresh" content="0; url=https://fl-project.000webhostapp.com/affichermatch.php" />';
    } else {
        echo("Erreur lors de l'enregistrement");
        $req->debugDumpParams();
    }
}
?>