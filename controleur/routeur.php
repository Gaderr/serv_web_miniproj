<?php

require_once 'controleurAuthentification.php';

class Routeur
{
  private $ctrlAuthentification;

  public function __construct()
  {
    $this->ctrlAuthentification= new ControleurAuthentification();
  }

  // Traite une requête entrante
  public function routerRequete()
  {
    /*if($_SESSION["auth"] == false) //Le cookie est inexistant
    {
      if(isset($_POST['pseudo']) && isset($_POST['passw'])) //Le formulaire a été envoyé;
      {
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['passw'];
        if($this->ctrlAuthentification->checkAuth($pseudo, $mdp)) //vérif login
        {
          $this->ctrlAuthentification->affPlateau(); //TODO Afficher le plateau
          $prompt = true;
        }
        else //Erreur
        {
          echo "Problème d'authentification";
        }
      }
      else //Le formulaire n'a pas été envoyé
      {
        $this->ctrlAuthentification->accueil();
      }
    }
    else //Le cookie existe
    {
      $this->ctrlAuthentification->affPlateau(); //TODO Afficher le plateau
    }*/

    $this->ctrlAuthentification->affPlateau();

    if(isset($_POST['case']))
    {
      $this->ctrlAuthentification->start();
    }
  }
  //TODO Traitement des actions sur le plateau
}
?>
