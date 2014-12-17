<?php

class AnimalManager extends Animal {

    private $_db;
    private $_AnimalArray = array();

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getListeSelection($choix) {
        $cpt = 0;
        if ($choix != -1) {
            try {
                $query = "select * from vue_animal where idclassification_classification =:classification ";
                $resultset = $this->_db->prepare($query);
                $resultset->bindValue(1, $choix, PDO::PARAM_INT);
                $resultset->execute();
            } catch (PDOException $e) {
                print "Echec de la requ&ecirc;te " . $e->getMessage();
            }
            while ($data = $resultset->fetch()) {
                $cpt = $cpt + 1;
                $_AnimalArray[] = new Animal($data);
            }
            if ($cpt > 0) {
                return $_AnimalArray;
            } else {
                print "Aucun animal de cette catégorie n'est en vente pour le moment";
            }
        }
    }

    public function getListeAnimal() {
        try {
            $query = "select * from animal";
            $resultset = $this->_db->prepare($query);
            $resultset->execute();
        } catch (PDOException $e) {
            print "Echec de la requ&ecirc;te " . $e->getMessage();
        }
        while ($data = $resultset->fetch()) {
            $_AnimalArray[] = new Animal($data);
        }

        return $_AnimalArray;
    }

    public function addAnimal($choixEsp, $race, $num, $couleur, $taille, $poids, $choixSex, $px, $tva, $photo, $descPhoto, $stock, $pays) {
        try {
            $query = "select add_animal(:choixEsp,:race,:num,:couleur, :taille,:poids,:choixSex,:px, :tva,:photo, :descPhoto, :stock, :pays) as retour";
            $sql = $this->_db->prepare($query);
            $sql->bindValue(':choixEsp', $_POST['choixEsp']);
            $sql->bindValue(':race',$_POST['race']);
            $sql->bindValue(':num', $_POST['num']);
            $sql->bindValue(':couleur', $_POST['couleur']);
            $sql->bindValue(':taille', $_POST['taille']);
            $sql->bindValue(':poids', $_POST['poids']);
            $sql->bindValue(':choixSex', $_POST['choixSex']);
            $sql->bindValue(':px', $_POST['px']);
            $sql->bindValue(':tva', $_POST['tva']);
            $sql->bindValue(':photo', $_POST['photo']);
            $sql->bindValue(':descPhoto', $_POST['descPhoto']);
            $sql->bindValue(':stock', $_POST['stock']);
            $sql->bindValue(':pays', $_POST['pays']);
            $sql->execute();
            $retour = $sql->fetchColumn(0);                     
        } 
        catch(PDOException $e) {    
            print "Echec de la requ&ecirc;te.". $e;
        }
        return $retour;
    }

}