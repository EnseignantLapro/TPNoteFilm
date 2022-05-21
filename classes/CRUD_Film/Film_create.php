
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

    if(isset($_SESSION['Connexion'])){
    ?>
        <h1> Index </h2>
        <div> Bienvenu <?php echo $TheUser->getLogin()?></div>

        <?php
            if($TheUser->isAdmin()){
                echo "vous etes admin"; 
                if(isset($_POST["createFilm"])){
                   
                    $newfilm = new Film (null,$_POST["titre"],$_POST["resume"],$_POST["lienImage"]);
                    $newfilm->saveInBdd();
                }
                
                
            ?>

            

            <form action="" method="Post" >
                titre : <input type="text" name="titre" maxlength="100" >
                resume :<input type="text" name="resume" >
                lienImage : <input type="text" name="lienImage" >
                <input type="submit" name="createFilm" >
            </form>







            <?php
            }else{
                echo "vous etes un simple visiteur vous n'avez pas acces au crud";
            }
        ?>

    <?php
    }
   
    //affichage des films
    $Film = new Film(null,null,null,null);
    $tabFilms = $Film->getAllFilm();
    echo "<ul>";
    foreach ($tabFilms as $lefilm) {
        $lefilm->renderHTML();
    }
    echo "</ul>";

    ?>
    
</body>
</html>