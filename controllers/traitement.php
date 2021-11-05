<?php


class Traitement 
{
    private $server;
    private $username;
    private $password;

    public function __construct(){
        $this->server = "localhost";
        $this->username = "root";
        $this->password = "";
    }
    
    public function ConnexionBd(){
       
        //On essaie de se connecter
        try{
            $conn = new PDO("mysql:host=$this->server;dbname=test", $this->username, $this->password);
            //On définit le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        
        /*On capture les exceptions si une exception est lancée et on affiche
         *les informations relatives à celle-ci*/
        catch(PDOException $e){
          echo "Erreur : " . $e->getMessage();
        }

        return $conn;
    
    }
    public function Inscription($nom,$prenom,$email,$mot_de_passe){

        $db = $this->ConnexionBd();
        // Creer la table utilisateur si elle n'existe pas
        try{
            $query = " CREATE TABLE IF NOT EXISTS utilisateur(
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom varchar(255) null,
                prenom varchar(255) null,
                email varchar(255) null,
                mot_de_passe varchar(255)
             )ENGINE=INNODB;";
            
            $creation = $db->prepare($query);
            $creation->execute();
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

        // insertion des données dans la bd
        try {
            
        $sql = "INSERT INTO utilisateur (nom, prenom, email,mot_de_passe) VALUES (?,?,?,?)";
        $stmt= $db->prepare($sql);
        $stmt->execute([$nom,$prenom,$email,$mot_de_passe]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        
        return "Bravo pour votre inscription";

    }
}

?>