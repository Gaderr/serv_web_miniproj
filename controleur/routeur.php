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

    //Déconnexion de l'utilisateur
    if(isset($_POST['logoff']))
    {
      $this->ctrl->deco();
      $this->ctrl->askInit();
    }

    //Annulation du coup précédent
    if(isset($_POST["cancel"]))
    {
      $this->ctrl->cancel();
      unset($_POST["direction"]);
      unset($_POST['case']);
    }

    $logerr = false; //(déclaration en raison de la version ancienne de PHP)
    //Authentification
    if(isset($_POST['pseudo']) && isset($_POST['passw'])) //login envoyé;
    {
      if($this->ctrl->checkAuth($_POST['pseudo'], $_POST['passw'], false))
      {
        $_SESSION["pseudo"] = $_POST['pseudo'];
        unset($_POST['pseudo']);
        unset($_POST['passw']);
        $logerr = false;
      }
      else
      {
        $logerr = true;
      }
    }

    //vérif Authentification
    if(isset($_SESSION["pseudo"]) == false)
    {
      $this->ctrl->accueil($logerr);//titres + login + verif erreur
      $_SESSION["chxdep"] = false;
    }
    else
    {
      //Vues principales après l'Authentification
      $def = true; //Flag pour la redirection automatique sur la vue du plateau (lors d'un jeu ou autre).

      //Vue des classements
      if(isset($_POST["menu"]) && $_POST["menu"] == "class")
      {
        $this->ctrl->askInit();
        $this->ctrl->getClassements();
        $this->ctrl->affClassements();
        /*$this->ctrl->bidon();
        var_dump($_SESSION["temp"]);
        echo $_SESSION["temp"]['partieGagnee'];*/
        $def = false;
      }

      //Vue des informations sur le site
      if(isset($_POST["menu"]) && $_POST["menu"] == "about")
      {
        $this->ctrl->askInit();
        $def = false;
      }

      //Vue du plateau
      //Le plateau ne s'affiche que si un utilisateur s'est connecté
      if((isset($_POST["menu"]) && $_POST["menu"] == "plateau") || $def)
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
          $err = true;//(déclaration en raison de la version ancienne de PHP)

          //Une bille et une direction ont été choisies
          if(isset($_POST["direction"]) && isset($_POST['case']))
          {
            switch ($_POST["direction"])
            {
              case "Haut":
                $err = $this->ctrl->askHaut();
                break;
              case "Bas":
                $err = $this->ctrl->askBas();
                break;
              case "Gauche":
                $err = $this->ctrl->askGauche();
                break;
              case "Droite":
                $err = $this->ctrl->askDroite();
                break;
            }
          }
          $this->ctrl->affPlateau();
          $this->ctrl->checkCoups();
          $this->ctrl->affActionsJeu();

          //Test victoire ou défaite
          if($_SESSION["billes"] > 1 && $_SESSION["coups_j"] == 0)
          {
            $this->ctrl->affPerdu();
          }
          else
          {
            if($_SESSION["billes"] == 1 && $_SESSION["coups_j"] == 0)
            {
              $this->ctrl->affGagne();
            }
            else
            {
              //Ni défaite, ni victoire
              //Erreur : Pas de bille choisie
              if(isset($_POST["direction"]) && !isset($_POST["case"]))
              {
                $this->ctrl->affAlerte("bille");
              }
              else
              {
                //Erreur : Mouvement impossible
                if($err == false)
                {
                  $this->ctrl->affAlerte("move");
                }
              }
            }
          }
        }
      }
    }
    //TODO Enregistrement parties gagnées
    //TODO Affichage statistiques joueur, joueurS et 3 meilleurs joueurs
    //TODO Base : statistiques joueurs [parties gagnées / parties jouées]
  }
}
?>
