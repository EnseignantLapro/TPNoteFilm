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