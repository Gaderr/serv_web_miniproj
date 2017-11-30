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
    //Authentification
    if(isset($_POST['pseudo']) && isset($_POST['passw'])) //Le formulaire a été envoyé;
    {
      $pseudo = $_POST['pseudo'];
      $mdp = $_POST['passw'];
      if($this->ctrlAuthentification->checkAuth($pseudo, $mdp))
      {
        $_SESSION["auth"] = true;
        $_SESSION["pseudo"] = $pseudo;
      }
    }

    //vérif Authentification
    if($_SESSION["auth"] == false)
    {
      $this->ctrlAuthentification->accueil();
      $_SESSION["chxdep"] = false;
      unset($_POST['pseudo']);
      unset($_POST['passw']);
    }
    else
    {
      //Reinitialiser la partie
      if(isset($_POST["reset_post"]))
      {
        $this->ctrlAuthentification->askInit();
      }

      //Choix de la bille de départ
      if($_SESSION["chxdep"] == false)
      {
        //Bille choisie
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
        //Une bille et une direction ont été choisis
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
  }
}
?>
