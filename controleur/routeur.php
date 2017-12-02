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

    if(isset($_POST['logoff']))
    {
      $this->ctrl->deco();
    }

    //Authentification
    if(isset($_POST['pseudo']) && isset($_POST['passw'])) //login envoyé;
    {
      if($this->ctrl->checkAuth($_POST['pseudo'], $_POST['passw']))
      {
        $_SESSION["pseudo"] = $_POST['pseudo'];
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
        if($_SESSION["billes"] > 1 && $_SESSION["coups_j"] == 0)
        {
          $this->ctrl->affPerdu();
        }
        else
        {
          if($_SESSION["billes"] == 1 && $_SESSION["coups_j"] == 0)
          {
            $this->ctrl->affActionsJeu();
            $this->ctrl->affGagne();
          }
          else
          {
            $this->ctrl->affActionsJeu();
          }
        }
      }
    }
    //TODO Messages d'erreur (Authentification, mauvais déplacements)
    //TODO Enregistrement partie
    //TODO Affichage statistiques joueur (!!!!--> La table parties a des valeurs Booléenes, normal ?)
    //TODO Annulation du coup précédent
  }
}
?>
