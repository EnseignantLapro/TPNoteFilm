<?php
    class User{

        //propriétés private
        private $id_;
        private $isAdmin_ = false;
        private $login_;
        
        //méthode public
        public function __construct($id,$isAdmin,$login){
            $this->id_ = $id;
            $this->isAdmin_ = $isAdmin;
            $this->login_ = $login;
        }

        public function seConnecter($login,$pass){
            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `login` = '".$login."' 
            AND 
            `pass` = '".$pass."';";

            $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
            if ( $resultat->rowCount()>0){
                //echo "on a trouver le bon login";
               
                $tab = $resultat->fetch();
                $_SESSION['Connexion']=true;
                $_SESSION['id']=$tab['id'];

                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];

                return true;
            }else{
                // echo "Le login ".$_POST['login']." et le pass ".$_POST['pass']." n'est pas bon";
                return false;
            }
        }

        public function CreateNewUser($login,$pass){
            //etape 1 vérifier que le login n'existe pas déjà
            //etape 2 Générer un mdp temporaire pour ce user si $pass est vide
            //etape 3 Creer une entrée en BDD pour ajouter le user et le mdp
            //etape 4 envoyer un mail de confirmation avec login et mdp

            //ETAPE 1 --------------------------
            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `login` = '".$login."'";
            $resultat = $GLOBALS["pdo"]->query($RequetSql); 
            if ( $resultat->rowCount()>0){
                //echo "on a trouver le bon id";
                $tab = $resultat->fetch();
                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];
                $pass =  $tab['pass'];
                
            }else{
                //ETAPE 2 --------------------------
                if(empty($pass)){
                    $temp= password_hash($login, PASSWORD_DEFAULT);
                    $pass=substr($temp, 13, 3).substr($temp, 23, 3).substr($temp, 33, 3).'!';
                }
                //ETAPE 3 --------------------------
                $requetSQL = "INSERT INTO `User`
                ( `login`, `pass`, `isAdmin`) 
                VALUES 
                ('" . $login . "','" . $pass . "','0')";
                $resultat = $GLOBALS["pdo"]->query($requetSQL);
                $this->id_ = $GLOBALS["pdo"]->lastInsertId();
                $this->isAdmin_ = 0;
                $this->login_ = $login;
            }

            //ETAPE 4 --------------------------
            try {
                // Plusieurs destinataires
                 $to  = $this->login_; // notez la virgule
                 // Sujet
                 $subject = 'Bienvenu sur TP Note Film';
                 // message
                 $message = '<html><head><title>Bienvenu sur TP Note Film</title></head>
                 <body>
                 <p style=" background-image: url(\'https://getwallpapers.com/wallpaper/full/9/3/7/1267865-movie-poster-wallpaper-1920x1080-for-mobile-hd.jpg\') ;height:180px;color:white;text-align: center;font-size: 100px;">TP NOTE SITE</p>
                 <p><h2 style="color:black" >Voici votre login : '.$this->login_.'<h2></p>
                 <p><h3 style="color:black">Voici votre mdp temporaire : '.$pass.' <h3></p></body>
                 <p style="height:40px;background-color:#ffc107;color:black;text-align: center;font-size: 15px;">
                    Copyright © Rapidecho / Pour maitriser ce que vous faites inspirez vous mais ne faites pas de copier/coller
                 </p>
                 </html>';
                 // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                 $headers[] = 'MIME-Version: 1.0';
                 $headers[] = 'Content-type: text/html; charset=utf-8';
                 // En-têtes additionnels
                 $headers[] = 'To:  <'.$to.'>';
                 $headers[] = 'From: TP Note Film <no-reply@sendinblue.com>';
                 //copie 
                 //$headers[] = 'Cc: jlanglace@la-providence.net';
                 //copie caché
                     //$headers[] = 'Bcc: jlanglace@la-providence.net';
 
                 // Envoi ( cette fonction est bloquante privilégié un appel API)
                 mail($to, $subject, $message, implode("\r\n", $headers));
             } catch (Exception  $error) {
                 $error->getMessage();
             }
        }


        

        public function setUserById($id){
            $RequetSql = "SELECT * FROM `User` 
            WHERE 
            `id` = '".$id."'";

            $resultat = $GLOBALS["pdo"]->query($RequetSql); 
            if ( $resultat->rowCount()>0){
                //echo "on a trouver le bon id";
                $tab = $resultat->fetch();
                $this->id_ = $tab['id'];
                $this->isAdmin_ = $tab['isAdmin'];
                $this->login_ = $tab['login'];
                return true;
            }else{
                return false;
            }
        }

        public function seDeConnecter(){
            session_unset();
            session_destroy();
        }

        public function isAdmin(){
            return $this->isAdmin_;
        }

        public function  getLogin(){
            return $this->login_;
        }
        
    }
?>