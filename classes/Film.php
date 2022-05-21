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
        if(is_null($this->id_)){
            $requetSQL = "INSERT INTO `Film`
            ( `titre`, `resume`, `lienImage`) 
            VALUES 
            ('".$this->titre_."','".$this->resume_."','".$this->lienImage_."')";
            $resultat = $GLOBALS["pdo"]->query($requetSQL); 
            $this->id_ = $GLOBALS["pdo"]->lastInsertId();
        }else{
            //UPDATE

        }
    }
    
    public function setFilmById($id){

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


}

?>