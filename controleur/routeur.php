<?php

require_once 'Controleur.php';

class Routeur
{
  private $ctrl;

  public function __construct()
  {
    $this->ctrl= new Controleur();
  }

  // Traite une requête entrante
  public function routerRequete()
  {
    //print_r($_SESSION);
    //Authentification
    if(isset($_POST['pseudo']) && isset($_POST['passw'])) //login envoyé;
    {
      $pseudo = $_POST['pseudo'];
      $mdp = $_POST['passw'];
      if($this->ctrl->checkAuth($pseudo, $mdp))
      {
        $_SESSION["pseudo"] = $pseudo;
        unset($_POST['pseudo']);
        unset($_POST['passw']);
      }
    }

    //vérif Authentification
    if(!isset($_SESSION["pseudo"]))
    {
      $this->ctrl->accueil();//titres + login
      $_SESSION["chxdep"] = false;
    }
    else
    {

      //Reinitialiser la partie
      if(isset($_POST["reset_post"]))
      {
        $this->ctrl->askInit();
      }

      //Choix de la bille de départ
      if($_SESSION["chxdep"] == false)
      {
        //Bille choisie
        if(isset($_POST["case"]))
        {
          $this->ctrl->askStartPlateau();
          $this->ctrl->affPlateau();
          $this->ctrl->checkCoups();
          $this->ctrl->affCoups();
          $this->ctrl->affActionsJeu();
        }
        else
        {
          $this->ctrl->affPlateau();
          $this->ctrl->affStartPlateau();
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
              $this->ctrl->askHaut();
              break;
            case "Bas":
              $this->ctrl->askBas();
              break;
            case "Gauche":
              $this->ctrl->askGauche();
              break;
            case "Droite":
              $this->ctrl->askDroite();
              break;
          }
        }
        $this->ctrl->affPlateau();
        $this->ctrl->checkCoups();
        $this->ctrl->affCoups();
        $this->ctrl->affActionsJeu();
      }
    }
  }
}
?>
