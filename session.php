<?php session_start(); 
include("classes/User.php");
include("classes/Film.php");

$TheUser = new User(null,null,null);

try {
    // ---------------Connexion à la BDD et récupération et traitement du formulaire
    $ipserver = "192.168.65.193";
    $nomBase = "NoteFilm";
    $loginPrivilege = "SiteWeb";
    $passPrivilege = "SiteWeb";

    $GLOBALS["pdo"] = new PDO('mysql:host='.$ipserver.';dbname='.$nomBase.'', $loginPrivilege, $passPrivilege);
    
} catch (Exception  $error) {
    $error->getMessage();
}

if(isset($_POST['connexion'])){
    $TheUser->seConnecter($_POST['login'],$_POST['pass']);
}

if (isset($_POST['deconnexion'])){
    //echo "vous êtes déconnecter";
    $TheUser->seDeConnecter();
}

if(isset($_SESSION['Connexion']) && $_SESSION['Connexion']==true){
   
    $TheUser->setUserById($_SESSION['id']);


    ?>
    <form action="" method="post">
        <input type="submit" name="deconnexion" value="Se déconnecter">
    </form>
    <a href="page2.php">acces à la page2</a>
    <?php
}else{

    echo "Veuillez vous identifier";
    ?>
    <form action="" method="post">
        Login : <input type="text" name="login" value="julien"/>
        Pass : <input type="password" name="pass" value="julien"/>
        <input type="submit" name="connexion">
    </form>
    <?php
}

?>