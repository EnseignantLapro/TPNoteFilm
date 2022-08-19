<?php
class Film
{

    //Propriété private
    private $id_ = null;
    private $titre_;
    private $resume_;
    private $lienImage_;
    private $MoyenneNote_;

    //Methode public
    public function __construct($id, $titre, $resume, $lienImage, $note)
    {
        $this->id_ = $id;
        $this->titre_ = $titre;
        $this->resume_ = $resume;
        $this->lienImage_ = $lienImage;
        $this->MoyenneNote_ = $note;
    }

    //create si id est null et fait un update si id existe 
    public function saveInBdd()
    {
        //cas si id = null => INSERT
        $titre = addslashes($this->titre_);
        $resume = addslashes($this->resume_);
        $lienImage = addslashes($this->lienImage_);

        if (is_null($this->id_)) {
            $requetSQL = "INSERT INTO `Film`
            ( `titre`, `resume`, `lienImage`) 
            VALUES 
            ('" . $titre . "','" . $resume . "','" . $lienImage . "')";
            $resultat = $GLOBALS["pdo"]->query($requetSQL);
            $this->id_ = $GLOBALS["pdo"]->lastInsertId();

            $requetSQL = "INSERT INTO `Note` ( `idUser`, `idFilm`, `note`) 
            VALUES ( '".$_SESSION['id']."', '".$this->id_."', '".$this->MoyenneNote_."');";
            $GLOBALS["pdo"]->query($requetSQL);



        } else {
            //UPDATE
            echo "tu va updater le film id N°" . $this->id_;



            $requetSQL = "UPDATE `Film` SET 
            `titre`='" . $titre . "',
            `resume`='" . $resume . "',
            `lienImage`='" . $lienImage . "' 
            WHERE `id` = '" . $this->id_ . "'";

            $resultat = $GLOBALS["pdo"]->query($requetSQL);
        }
    }

    public function deleteInBdd()
    {
        if (!is_null($this->id_)) {
            $requetSQL = "DELETE FROM `Film`WHERE
            id = '" . $this->id_ . "'";
            $GLOBALS["pdo"]->query($requetSQL);
            echo "Le film " . $this->titre_ . " a été supprimé";
        }
    }

    public function setFilmById($id)
    {
        $RequetSql = "Select Film.id,Film.titre,Film.resume,Film.lienImage, AVG(Note.note) as 'note'
         FROM Film,Note,User
        WHERE
        Film.id = Note.idFilm
        AND
        Note.idUser = User.id
        AND
        Film.id = '" . $id . "'  
        Group By Film.id;";

        $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
        if ($resultat->rowCount() > 0) {
            $tab = $resultat->fetch();
            $this->id_ = $tab['id'];
            $this->titre_ = $tab['titre'];
            $this->resume_ = $tab['resume'];
            $this->lienImage_ = $tab['lienImage'];
            $this->MoyenneNote_ = $tab['note'];
        }
    }

    public function getAllFilm()
    {
        $ListFilms = array();
        //chercher en bdd tous les films
        $RequetSql = "Select Film.id,Film.titre,Film.resume,Film.lienImage, AVG(Note.note) as 'note'
        FROM Film,Note,User
        WHERE
        Film.id = Note.idFilm
        AND
        Note.idUser = User.id
        Group By Film.id;";

        $resultat = $GLOBALS["pdo"]->query($RequetSql); //resultat sera de type pdoStatement
        while ($tab = $resultat->fetch()) {
            $lefilm = new Film($tab['id'], $tab['titre'], $tab['resume'], $tab['lienImage'], $tab['note']);
            array_push($ListFilms, $lefilm);
        }

        return $ListFilms;
    }

    public function getTitre()
    {
        return $this->titre_;
    }
    public function getId()
    {
        return $this->id_;
    }
    public function getResume()
    {
        return $this->resume_;
    }

    public function renderHTML()
    {
    ?>
        <!--catre a dupplicquer -->
        <div class="col mb-5">
            <div class="card h-100 white">
                <!-- Sale badge-->
                <div class="badge bg-yellow text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Vote</div>
                <!-- Product image-->
                <img class="card-img-top" src="<?= $this->getLienImage(); ?>" alt="..." />
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder"><?= $this->titre_;?></h5>
                        <!-- Product reviews-->
                        <div class="d-flex justify-content-center small text-warning mb-2">
                            
                            <?php
                                for ($i=0; $i < round($this->MoyenneNote_); $i++) { 
                                   echo'<div class="bi-star-fill"></div>';
                                }
                                for ($i=$i; $i < 5; $i++) { 
                                    echo'<div class="bi-star"></div>';
                                }
                            ?>
                            <?= round($this->MoyenneNote_)."/5" ?>
                        </div>
                        <!-- Product price-->
                        <span class="text-muted"><?= $this->resume_;?></span>

                    </div>
                </div>
                <!-- Product actions-->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn login_btn mt-auto" href="CRUDFilm.php">Infos +</a></div>
                </div>
            </div>
        </div>
    <?php
    }

    public function getImage()
    {
        $imageHTML = '<img src="' . $this->lienImage_ . '"alt="' . $this->titre_ . '"/>';
        return $imageHTML;
    }

    public function getLienImage()
    {
        return $this->lienImage_;
    }

    public function setTitre($titre)
    {
        $this->titre_ = $titre;
    }
    public function setResume($resume)
    {
        $this->resume_ = $resume;
    }
    public function setLienImage($lienImage)
    {
        $this->lienImage_ = $lienImage;
    }
}

?>