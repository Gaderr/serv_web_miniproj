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
    $this->vue->demandeLogin();
  }

  function salon()
  {
    $messages = $this->modele->get10RecentMessage();

    $this->vue->afficheMessages($messages);
  }

  function checkAuth($pseudo, $passw)
  {
    if($this->modele->checkAuth($pseudo, $passw))
    {
      $_SESSION["auth"] = true;
      return true;
    }
    else
    {
      return false;
    }
  }

  function prompt($m)
  {
    $this->modele->majSalon($_COOKIE['pseudo_auth'], $m);
  }
}
?>
