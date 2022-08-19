
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
            $Film = new Film(null,null,null,null,0);
            $tabFilms = $Film->getAllFilm();
            if($TheUser->isAdmin()){
                if(isset($_POST["idFilm"])){
                    $Film->setFilmById($_POST["idFilm"]);
                }

                if(isset($_POST["etoile"])){
                    echo "la note est : ".$_POST["etoile"];
                    $Note = new Note($_SESSION['id'],$_POST["idFilmNote"],$_POST["etoile"]);
                    $Note->saveInBdd();
                }
            


                
            ?>
            <form action="" method="Post" onchange="this.submit()">
                <select id="idFilm" name="idFilm">
                    <option value="null" >Choisi un film</option>
                <?php
                    $afficheEtoile = false;
                    foreach ($tabFilms as  $TheFilm) {

                        if($Film->getId() == $TheFilm->getId()){
                            $selected = "selected";
                            $afficheEtoile = true;
                        }else{$selected = "";}

                        echo '<option '.$selected.' value="'.$TheFilm->getId().'">'.$TheFilm->getTitre().'</option>';
                    }
                ?>
                </select>
            </form>
            
                <?php if($afficheEtoile){
                     $Film->renderHTML();
                    ?>
                    <form action="" method="Post"  class="stars5" onclick="this.submit();">
                    
                        <div class="starRating">
                            <input id="s5" type="radio" name="etoile" value="5">
                            <label for="s5">5</label>
                            <input id="s4" type="radio" name="etoile" value="4">
                            <label for="s4">4</label>
                            <input id="s3" type="radio" name="etoile" value="3">
                            <label for="s3">3</label>
                            <input id="s2" type="radio" name="etoile" value="2">
                            <label for="s2">2</label>
                            <input id="s1" type="radio" name="etoile" value="1">
                            <label for="s1">1</label>
                        </div>
                        <input type="hidden"  name="idFilmNote" value="<?= $Film->getId()?>" >

                        
                    </form>

                    <?php
                }
            }else{
                echo "vous etes un simple visiteur vous n'avez pas acces au crud";
            }
        ?>

    <?php
    }
   
    ?>
    
</body>
</html>