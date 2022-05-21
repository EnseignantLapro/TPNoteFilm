
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
<?php 

    include("./session.php");

    if(isset($_SESSION['Connexion'])){
    ?>
        <h1> Page 2 </h2>
        <div> vous etes sur une page privé</div>

    <?php
    }
?>
</body>
</html>