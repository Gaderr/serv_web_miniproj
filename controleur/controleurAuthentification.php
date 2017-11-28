<?php
require_once PATH_VUE."/vue.php";
require PATH_MODELE."/modele.php";

class ControleurAuthentification
{
  private $vue;
  private $modele;

  function __construct()
  {
    $this->vue=new Vue();
    $this->modele = new Modele();
  }

  function accueil()
  {
    $this->vue->vueLogin();
  }

  function affPlateau()
  {
    $this->vue->vuePlateau();
  }

  function affStartPlateau()
  {
    $this->vue->start();
  }

  function askStartPlateau()
  {
    $this->modele->startGame();
  }

  function checkAuth($pseudo, $passw)
  {
    if($this->modele->checkAuth($pseudo, $passw))
    {
      $_SESSION["auth"] = true;
      $_SESSION["pseudo"] = $pseudo;
      return true;
    }
    else
    {
      return false;
    }
  }
}
?>
