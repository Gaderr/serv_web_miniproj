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
    $prompt = false;

    if(!isset($_COOKIE['pseudo_auth'])) //Le cookie est inexistant
    {
      if(isset($_POST['pseudo']) && isset($_POST['passw'])) //Le formulaire a été envoyé;
      {
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['passw'];
        if($this->ctrlAuthentification->checkAuth($pseudo, $mdp)) //vérif login
        {
          $this->ctrlAuthentification->salon(); //Afficher le salon
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
      $this->ctrlAuthentification->salon(); //Afficher le salon
      $prompt = true;
    }

    if($prompt)
    {
      if((isset($_POST['message'])) && (!$_POST['message'] == ''))
      {
          $this->ctrlAuthentification->prompt($_POST['message']);
      }
    }
  }
}
?>
