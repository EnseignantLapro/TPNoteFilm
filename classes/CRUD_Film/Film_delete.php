
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
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