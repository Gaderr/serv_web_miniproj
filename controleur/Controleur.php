<?php
require_once PATH_VUE."/Vue.php";
require PATH_MODELE."/Modele.php";

class Controleur
{
  private $vue;
  private $modele;

  function __construct()
  {
    $this->vue=new Vue();
    $this->modele = new Modele();
  }

  function accueil($arg)
  {
    $this->vue->titres();
    $this->vue->vueLogin($arg);
  }

  function affPlateau()
  {
    $this->vue->titres();
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
    return $this->modele->moveUp();
  }

  function askBas()
  {
    return $this->modele->moveDown();
  }

  function askGauche()
  {
    return $this->modele->moveLeft();
  }

  function askDroite()
  {
    return $this->modele->moveRight();
  }

  function askInit()
  {
    $this->modele->reInit();
  }

  function checkCoups()
  {
    $this->modele->calcCoups();
  }

  function affCoups()
  {
    $this->vue->coups();
  }

  function affPerdu()
  {
    return $this->vue->vueFin();
  }

  function affGagne()
  {
    return $this->vue->vueGagne();
  }

  function affAlerte($arg)
  {
    $this->vue->alerte($arg);
  }

  function cancel()
  {
    $this->modele->cancel();
  }

  function checkAuth($pseudo, $passw)
  {
    return $this->modele->checkAuth($pseudo, $passw);
  }

  function deco()
  {
    $this->modele->deconnexion();
  }
}
?>
