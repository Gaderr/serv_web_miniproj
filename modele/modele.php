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

    $_SESSION["plateau"] = $plateau; //TODO Utiliser une variable de session pour le plateau dans le reste des classes

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

    try
    {
      $chaine="mysql:host=".HOST.";dbname=".BD;
      $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      $exception=new ConnexionException("problème de connexion à la base");
      throw $exception;
    }
  }

  //Sélection de la première bille à supprimer pour commencer à jouer
  public function startGame($positions)
  {
    $x = $positions[0];
    $y = $positions[1];
    $plateau = $_SESSION["plateau"];
    if($this->plateau[x][y] != 'x' && $this->plateau[x][y] == 'o')
    {
      $this->plateau[x][y] = 'u';
    }
    $_SESSION["plateau"] = $plateau;
  }

  //relancer une partie / reinitialiser le plateau
  public function reInit()
  {
    for($ligne = 2; $ligne < 5; $ligne++)
    {
      for($colonne = 0; $colonne < 7; $colonne++)
      {
        $plateau[$ligne][$colonne] = 'o';
      }
    }
    for($colonne = 2; $colonne < 5; $colonne++)
    {
      for($ligne = 0; $ligne < 7; $ligne++)
      {
        $plateau[$ligne][$colonne] = 'o';
      }
    }
  }

  public function moveUp($positions)
  {
    $x = $positions[0];
    $y = $positions[1];
    if($this->plateau[x][y - 1] == 'o' && $this->plateau[x][y - 2] == 'u')
    {
      $this->plateau[x][y - 1] == 'u'; //bille supprimée
      $this->plateau[x][y - 2] == 'o'; //bille placée
      $this->plateau[x][y] == 'u'; //bille supprimée
      return true;
    }
    else
    {
      return false;
    }
  }

  public function moveDown($positions)
  {
    $x = $positions[0];
    $y = $positions[1];
    if($this->plateau[x][y + 1] == 'o' && $this->plateau[x][y - 2] == 'u')
    {
      $this->plateau[x][y + 1] == 'u'; //bille supprimée
      $this->plateau[x][y + 2] == 'o'; //bille placée
      $this->plateau[x][y] == 'u'; //bille supprimée
      return true;
    }
    else
    {
      return false;
    }
  }

  public function moveLeft($positions)
  {
    $x = $positions[0];
    $y = $positions[1];
    if($this->plateau[x - 1][y] == 'o' && $this->plateau[x][y - 2] == 'u')
    {
      $this->plateau[x - 1][y] == 'u'; //bille supprimée
      $this->plateau[x - 2][y] == 'o'; //bille placée
      $this->plateau[x][y] == 'u'; //bille supprimée
      return true;
    }
    else
    {
      return false;
    }
  }

  public function moveRight($positions)
  {
    $x = $positions[0];
    $y = $positions[1];
    if($this->plateau[x + 1][y] == 'o' && $this->plateau[x][y - 2] == 'u')
    {
      $this->plateau[x + 1][y] == 'u'; //bille supprimée
      $this->plateau[x + 2][y] == 'o'; //bille placée
      $this->plateau[x][y] == 'u'; //bille supprimée
      return true;
    }
    else
    {
      return false;
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
