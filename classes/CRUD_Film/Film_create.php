
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
    <div>
    <?php include("../../session.php");
    
    if(isset($_SESSION['Connexion'])){
    
            if($TheUser->isAdmin()){
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
    echo '<div class="contener">';
    foreach ($tabFilms as $lefilm) {
        $lefilm->renderHTML();
    }
    echo "</ul>";

    ?>
    
</body>
</html>