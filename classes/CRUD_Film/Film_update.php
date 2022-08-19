
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

     <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="../../css/styles.css" rel="stylesheet" />
    <!-- Bootstrap icons-->
   
</head>
<body>
    <?php include("../../session.php");
    $Film = new Film(null,null,null,null,0);
    $tabFilms = $Film->getAllFilm();

    if(isset($_SESSION['Connexion'])){
    ?>
        <h1> Index </h2>
        <div> Bienvenu <?php echo $TheUser->getLogin()?></div>

        <?php
            if($TheUser->isAdmin()){
                echo "vous etes admin"; 
                
                if(isset($_POST["idFilm"])){
                    $Film->setFilmById($_POST["idFilm"]);
                }

                if(isset($_POST["UpdateFilm"])){
                    $Film->setFilmById($_POST["id"]); //id vient du champ hidden
                    $Film->setTitre($_POST["titre"]);
                    $Film->setResume($_POST["resume"]);
                    $Film->setLienImage($_POST["lienImage"]);
                    $Film->saveInBdd();
                }
                
                
            ?>
            <form action="" method="Post" onchange="this.submit()">
                <select id="idFilm" name="idFilm">
                    <option value="null" >Choisi un film</option>
                <?php
                    foreach ($tabFilms as  $TheFilm) {

                        if($Film->getId() == $TheFilm->getId()){
                            $selected = "selected";
                        }else{$selected = "";}

                        echo '<option '.$selected.' value="'.$TheFilm->getId().'">'.$TheFilm->getTitre().'</option>';
                    }
                ?>
                </select>
            </form>

            <form action="" method="Post" >
                titre : <input type="text" name="titre" maxlength="100" value="<?=  $Film->getTitre() ?>" >
                resume :<input type="text" name="resume"  value="<?= $Film->getresume()?>">
                lienImage : <input type="text" name="lienImage"  value="<?= $Film->getLienImage()?>">
                <input type="Hidden" name="id"  value="<?= $Film->getID()?>">
                <input type="submit" name="UpdateFilm" value="Mettre à jour" >
            </form>

            <?php
            }else{
                echo "vous etes un simple visiteur vous n'avez pas acces au crud";
            }
        ?>

    <?php
    }
   
    //affichage des film
    ?>
        <div class="contener">
            <section class="py-5">
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <?php foreach ($tabFilms as $lefilm) {
                            $lefilm->renderHTML();
                        }
                        ?></div>
                </div>
            </section>
            <!-- Footer-->
            <footer class="py-5 bg-dark">
                <div class="container">
                    <p class="m-0 text-center text-white">Copyright &copy; Rapidecho / Pour maitriser ce que vous faites inspirez vous mais ne faites pas de copier/coller</p>
                </div>
            </footer>
            <!-- Bootstrap core JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>