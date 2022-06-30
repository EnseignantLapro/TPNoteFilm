<?php session_start();

include("classes/User.php");
include("classes/Film.php");

$TheUser = new User(null, null, null);

try {
    // ---------------Connexion à la BDD et récupération et traitement du formulaire
    $ipserver = "192.168.65.193";
    $nomBase = "NoteFilm";
    $loginPrivilege = "SiteWeb";
    $passPrivilege = "SiteWeb";

    $GLOBALS["pdo"] = new PDO('mysql:host=' . $ipserver . ';dbname=' . $nomBase . '', $loginPrivilege, $passPrivilege);
} catch (Exception  $error) {
    $error->getMessage();
}

if (isset($_POST['connexion'])) {
    $TheUser->seConnecter($_POST['login'], $_POST['pass']);
}

if (isset($_POST['deconnexion'])) {
    //echo "vous êtes déconnecter";
    $TheUser->seDeConnecter();
}

if (isset($_SESSION['Connexion']) && $_SESSION['Connexion'] == true) {
    $TheUser->setUserById($_SESSION['id']);
    
    $htmlformdeco = '<form action="" method="post" class="form-inline my-2 my-lg-0">
    <input class="btn btn-outline-dark bg-light" type="submit" name="deconnexion" value="Se déconnecter">
    </form>';
    $htmllinkCompte = '<li class="nav-item"><a class="nav-link active" aria-current="page" href="compte.php">Compte</a></li>';
} else {
    
    $htmlformdeco = '';
    $htmllinkCompte = '';
?>
<div class="imageDeFond">
        <div class="container">
            <div class="d-flex justify-content-center h-100">
                <div class="card">
                    <div class="card-header">
                        <h3>Sign In</h3>
                        <div class="d-flex justify-content-end social_icon">
                            <span><i class="fab fa-facebook-square"></i></span>
                            <span><i class="fab fa-google-plus-square"></i></span>
                            <span><i class="fab fa-twitter-square"></i></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="username" name="login">

                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="password" name="pass">
                            </div>
                            <div class="row align-items-center remember">
                                <input type="checkbox">Remember Me
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Login" class="btn float-right login_btn" name="connexion">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center links">
                            Don't have an account?<a href="#">Sign Up</a>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="#">Forgot your password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
if (isset($_SESSION['Connexion'])) {
?><nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Voir Tous les Films</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?= $htmllinkCompte; ?>

                    <?php
                    if ($TheUser->isAdmin()) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Film</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">Gerer les films</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#!">Ajouter un film</a></li>
                                <li><a class="dropdown-item" href="classes/CRUD_Film/Film_update.php">Modifier un film</a></li>
                                <li><a class="dropdown-item" href="#!">Supprimer un film</a></li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                </ul>
               
                <form class="form-inline my-2 my-lg-0" action="index.php">
                    <button class="btn btn-outline-dark bg-light" type="submit">
                        <i class="bi bi-person-fill"></i>
                        <?php echo $TheUser->getLogin() ?>
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
                <?= $htmlformdeco ?>
               
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5 imageDeFond">
        <div class="fondBlancRadial">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">TP Note Film</h1>
                    <p class=" lead fw-normal text-white-50 mb-0">TP de Première année</p>
                </div>
            </div>
        </div>
    </header>
<?php
}
?>