<?php
class Film{

    //Propriété private
    private $id_;
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