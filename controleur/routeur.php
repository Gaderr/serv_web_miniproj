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

    if(isset($_POST["reset_post"]))
    {
      $this->ctrlAuthentification->askInit();
    }

    if($_SESSION["chxdep"] == false)
    {
      if(isset($_POST["case"]))
      {
        $this->ctrlAuthentification->askStartPlateau();
        $this->ctrlAuthentification->affPlateau();
        $this->ctrlAuthentification->affActionsJeu();
      }
      else
      {
        $this->ctrlAuthentification->affPlateau();
        $this->ctrlAuthentification->affStartPlateau();
      }
    }
    else
    {
      if(isset($_POST["direction"]) && isset($_POST['case']))
      {
        switch ($_POST["direction"])
        {
          case "Haut":
            $this->ctrlAuthentification->askHaut();
            break;
          case "Bas":
            $this->ctrlAuthentification->askBas();
            break;
          case "Gauche":
            $this->ctrlAuthentification->askGauche();
            break;
          case "Droite":
            $this->ctrlAuthentification->askDroite();
            break;
        }
      }
      $this->ctrlAuthentification->affPlateau();
      $this->ctrlAuthentification->affActionsJeu();
    }
  }

  //TODO Traitement des actions sur le plateau
}
?>
