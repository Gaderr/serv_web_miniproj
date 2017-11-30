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
    $this->vue->menu();
    $this->vue->vueLogin();
  }

  function affPlateau()
  {
    $this->vue->menu();
    $this->vue->vuePlateau();
  }

  function affStartPlateau()
  {
    $this->vue->start();
  }

  function affActionsJeu()
  {
    $this->vue->actionsJeu();
  }

  function askStartPlateau()
  {
    $this->modele->startGame();
  }

  function askHaut()
  {
    $this->modele->moveUp();
  }

  function askBas()
  {
    $this->modele->moveDown();
  }

  function askGauche()
  {
    $this->modele->moveLeft();
  }

  function askDroite()
  {
    $this->modele->moveRight();
  }

  function askInit()
  {
    $this->modele->reInit();
  }

  function checkAuth($pseudo, $passw)
  {
    return $this->modele->checkAuth($pseudo, $passw);
  }
}
?>
