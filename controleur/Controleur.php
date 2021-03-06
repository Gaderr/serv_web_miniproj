<?php
require_once PATH_VUE."/vue.php";
require PATH_MODELE."/modele.php";

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
    $this->vue->navBar();
    $this->vue->vueLogin($arg);
  }

  function affClassements()
  {
    $this->vue->navBar();
    $this->vue->vueClassements($this->modele->getClassementJoueur(), $this->modele->getTop3(), $this->modele->getClassements());
  }

  function affPlateau()
  {
    $this->vue->navBar();
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
    $this->modele->addPartiePerdue();
    return $this->vue->vueFin();
  }

  function affGagne()
  {
    $this->modele->adVictoriam();
    return $this->vue->vueGagne();
  }

  function bidon()
  {
    $this->modele->addPartieJouee();
  }

  function cancel()
  {
    $this->modele->cancel();
  }

  function affAlerte($arg)
  {
    $this->vue->alerte($arg);
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
