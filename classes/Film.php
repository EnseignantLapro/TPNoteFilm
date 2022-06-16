<?php
class Film{

    //Propriété private
    private $id_ = null;
    private $titre_;
    private $resume_;
    private $lienImage_;

    //Methode public
    public function __construct($id,$titre,$resume,$lienImage){
        $this->id_ = $id;
        $this->titre_ = $titre;
        $this->resume_ = $resume;
        $this->lienImage_ = $lienImage;
    }

    //create si id est null et fait un update si id existe 
    public function saveInBdd(){
        //cas si id = null => INSERT
        $titre = addslashes($this->titre_);
        $resume = addslashes($this->resume_);
        $lienImage = addslashes($this->lienImage_);

        if(is_null($this->id_)){
            $requetSQL = "INSERT INTO `Film`
            ( `titre`, `resume`, `lienImage`) 
            VALUES 
            ('".$titre."','".$resume."','".$lienImage."')";
            $resultat = $GLOBALS["pdo"]->query($requetSQL); 
            $this->id_ = $GLOBALS["pdo"]->lastInsertId();
        }else{
            //UPDATE
            echo "tu va updater le film id N°".$this->id_;

            

            $requetSQL = "UPDATE `Film` SET 
            `titre`='".$titre."',
            `resume`='".$resume."',
            `lienImage`='".$lienImage."' 
            WHERE `id` = '".$this->id_."'";
            
            $resultat = $GLOBALS["pdo"]->query($requetSQL); 

        }
    }
    
    public function deleteInBdd($idUser){
        if(!is_null($this->id_)){
            $requetSQL = "DELETE FROM `Film`WHERE
            id = '". $this->id_."'";
           $GLOBALS["pdo"]->query($requetSQL); 
           echo "Le film ".$this->titre_." a été supprimé";
        }
    }

    public function setFilmById($id){
        $RequetSql = "SELECT * FROM `Film` 
        WHERE `id` = '".$id."'  ";

        $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
        if($resultat->rowCount()>0){
            $tab=$resultat->fetch();
            $this->id_ = $tab['id'];
            $this->titre_ = $tab['titre'];
            $this->resume_ = $tab['resume'];
            $this->lienImage_ = $tab['lienImage'];  
        }
       
    }

    public function getAllFilm(){
        $ListFilms = array();
        //chercher en bdd tous les films
        $RequetSql = "SELECT * FROM `Film`";

        $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
        while($tab=$resultat->fetch()){
            $lefilm = new Film($tab['id'],$tab['titre'],$tab['resume'],$tab['lienImage']);
            array_push($ListFilms,$lefilm);
        }

        return $ListFilms;
    }

    public function getTitre(){
        return $this->titre_;
    }
    public function getId(){
        return $this->id_;
    }
    public function getResume(){
        return $this->resume_;
    }

    public function renderHTML(){
        echo "<li>";
        echo $this->titre_;
        echo $this->resume_;
        echo $this->getImage();
        echo "</li>";
    }

    public function getImage(){
        $imageHTML = '<img src="'.$this->lienImage_.'"alt="'.$this->titre_.'"/>';
        return $imageHTML ;
    }

    public function getLienImage(){
        return $this->lienImage_ ;
    }

    public function setTitre($titre){
        $this->titre_ = $titre;
    }
    public function setResume($resume){
        $this->resume_ = $resume;
    }
    public function setLienImage($lienImage){
        $this->lienImage_ = $lienImage;
    }


}

?>