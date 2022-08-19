<?php
class Note{

    //propriété
    private $id_;
    private $idFilm_;
    private $idUser_;
    private $note_;


    //méthode
    public function __construct($newIddUser,$newIdFilm,$NewNote){
        $this->idFilm_ = $newIdFilm;
        $this->idUser_ = $newIddUser;
        $this->note_ = $NewNote;
    }

    public function saveInBdd(){
        if (is_null($this->id_)) {

            //vérifier si le film n'a pas déjà été noté par le user en question
            $RequetSql = "Select Film.id
            FROM Film,Note,User
            WHERE
            Film.id = Note.idFilm
            AND
            Note.idUser = User.id
            AND
            Film.id = '" . $this->idFilm_ . "'  
            AND 
            User.id = '" . $this->idUser_ . "'  
            Group By Film.id;";

            $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
            if ($resultat->rowCount() > 0) {
                $requetSQL = "UPDATE `Note` SET 
                `note`='" . $this->note_ . "'
                WHERE Note.idFilm = '" .$this->idFilm_ . "'
                AND Note.idUser ='" .$this->idUser_ . "'";
                $GLOBALS["pdo"]->query($requetSQL);
            }else{
                $requetSQL = "INSERT INTO `Note` ( `idUser`, `idFilm`, `note`) 
                VALUES ( '".$this->idUser_."', '".$this->idFilm_."', '".$this->note_."');";
                $GLOBALS["pdo"]->query($requetSQL);
                $this->id_ = $GLOBALS["pdo"]->lastInsertId();
            }

        } else {
            $requetSQL = "UPDATE `Note` SET 
            `note`='" . $this->note_ . "',
            WHERE `id` = '" . $this->id_ . "'";
            $GLOBALS["pdo"]->query($requetSQL);
        }
    }

}

?>
