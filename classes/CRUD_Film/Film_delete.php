
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
    $Film = new Film(null,null,null,null);

    if(isset($_POST["DeleteFilm"])){
        $Film->setFilmById($_POST["id"]);
        $Film->deleteInBdd();
    }

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
                    $Film->renderHTML(); 
                    ?>
                    <form action="" method="Post" >
                        <input type="Hidden" name="id"  value="<?= $Film->getID()?>">
                        <input type="submit" name="DeleteFilm" value="Supprimer le Film <?= $Film->getTitre() ?>" >
                    </form>
                   <?php
                }

                /*if(isset($_POST["UpdateFilm"])){
                    $Film->setFilmById($_POST["id"]); //id vient du champ hidden
                    $Film->setTitre($_POST["titre"]);
                    $Film->setResume($_POST["resume"]);
                    $Film->setLienImage($_POST["lienImage"]);
                    $Film->saveInBdd();
                }*/
                
                
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
            

            







            <?php
            }else{
                echo "vous etes un simple visiteur vous n'avez pas acces au crud";
            }
        ?>

    <?php
    }
   
   
    
   

    ?>
    
</body>
</html>