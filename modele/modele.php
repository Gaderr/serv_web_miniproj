<?php

class Modele
{
  private $connexion;
  private $plateau;

  // Constructeur
  public function __construct()
  {
    $plateau = array(); //La matrice/plateau de jeu

    //Initialisation du plateau
    //Chaque case est définie par un caractère :
    //  - 'x' = Non jouable
    //  - 'o' = Bille présente & case jouable
    //  - 'u' = Bille absente & case jouable
    //On commence par définir toutes les cases non jouables
    for ($ligne = 0; $ligne < 7; $ligne++)
    {
      for ($colonne = 0; $colonne < 7; $colonne++)
      {
        $plateau[$ligne][$colonne] = 'x'; //une case non jouable
      }
    }

    //Définition des emplacements
    //On définit les cases jouables par dessus les non-jouables
    for($ligne = 2; $ligne < 5; $ligne++)//Les lignes 3, 4, 5 sont jouables
    {
      for($colonne = 0; $colonne < 7; $colonne++)
      {
        $plateau[$ligne][$colonne] = 'o'; //o = un emplacement
      }
    }
    for($colonne = 2; $colonne < 5; $colonne++)//Les colonnes 3, 4, 5 sont jouables
    {
      for($ligne = 0; $ligne < 7; $ligne++)
      {
        $plateau[$ligne][$colonne] = 'o';
      }
    }

    if(!isset($_SESSION["plateau"]))
    {
      $_SESSION["plateau"] = $plateau; //TODO Utiliser une variable de session pour le plateau dans le reste des classes
    }

    //résultat :
    //  +---------------> axe X
    //  | X X o o o X X
    //  | X X o o o X X
    //  | o o o o o o o
    //  | o o o o o o o
    //  | o o o o o o o
    //  | X X o o o X X
    //  | X X o o o X X
    //  v
    //  axe Y

    /*try
    {
      $chaine="mysql:host=".HOST.";dbname=".BD;
      $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      $exception=new ConnexionException("problème de connexion à la base");
      throw $exception;
    }*/
  }

  //Sélection de la première bille à supprimer pour commencer à jouer
  public function startGame()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    $_SESSION["plateau"][$posy][$posx] = 'u';
    $_SESSION["chxdep"] = true;
    //$_SESSION["reinit"] = true;
  }

  //relancer une partie / reinitialiser le plateau
  public function reInit()
  {
    for($ligne = 2; $ligne < 5; $ligne++)
    {
      for($colonne = 0; $colonne < 7; $colonne++)
      {
        $_SESSION["plateau"][$colonne][$ligne] = 'o';
      }
    }
    for($colonne = 2; $colonne < 5; $colonne++)
    {
      for($ligne = 0; $ligne < 7; $ligne++)
      {
        $_SESSION["plateau"][$colonne][$ligne] = 'o';
      }
    }
    $_SESSION["chxdep"] = false;
    unset($_POST["case"]);
    unset($_POST["reset_pos"]);
  }

  public function moveUp()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy - 1][$posx] == 'o' && $_SESSION["plateau"][$posy - 2][$posx] == 'u')
    {
      $_SESSION["plateau"][$posy - 1][$posx] = 'u';
      $_SESSION["plateau"][$posy - 2][$posx] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
    }
  }

  public function moveDown()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy + 1][$posx] == 'o' && $_SESSION["plateau"][$posy + 2][$posx] == 'u')
    {
      $_SESSION["plateau"][$posy + 1][$posx] = 'u';
      $_SESSION["plateau"][$posy + 2][$posx] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
    }
  }

  public function moveLeft()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy][$posx - 1] == 'o' && $_SESSION["plateau"][$posy][$posx - 2] == 'u')
    {
      $_SESSION["plateau"][$posy][$posx - 1] = 'u';
      $_SESSION["plateau"][$posy][$posx - 2] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
    }
  }

  public function moveRight()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy][$posx + 1] == 'o' && $_SESSION["plateau"][$posy][$posx + 2] == 'u')
    {
      $_SESSION["plateau"][$posy][$posx + 1] = 'u';
      $_SESSION["plateau"][$posy][$posx + 2] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
    }
  }

  //Déconnexion de la base
  public function deconnexion()
  {
    $this->connexion=null;
  }

  public function checkAuth($pseudo, $pass)
  {
    $statement = $this->connexion->prepare("SELECT motDePasse FROM joueurs where pseudo=?;");
    $statement->bindParam(1, $pseudo);
    $statement->execute();
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    if(crypt($pass, $result['motDePasse']) == $result['motDePasse'])
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
?>
