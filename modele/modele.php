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
    // [[X, X, o, o, o, X, X], [X, X, o, o, o, X, X], ...]

    if(!isset($_SESSION["plateau"]) && !isset($_SESSION["billes"]))
    {
      $_SESSION["plateau"] = $plateau;
      $_SESSION["billes"] = 33;
    }

    try
    {
      $chaine="mysql:host=".HOST.";dbname=".BD;
      $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      /*$exception = new ConnexionException($e->getMessage());
      throw $exception->getMessage();*/
      echo $e->getMessage();
    }
  }


  /*******************************
  ************PLATEAU*************
  ********************************/

  //Sélection de la première bille à supprimer pour commencer à jouer
  public function startGame()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    $_SESSION["plateau"][$posy][$posx] = 'u';
    $_SESSION["chxdep"] = true;
    $_SESSION["billes"]--;
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
    $_SESSION["billes"] = 33;
    if(isset($_POST["case"]) && isset($_POST["reset_pos"]))
    {
      unset($_POST["case"]);
      unset($_POST["reset_pos"]);
    }
  }

  //Action de jeu vers le haut
  public function moveUp()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy - 1][$posx] == 'o' && $_SESSION["plateau"][$posy - 2][$posx] == 'u')
    {
      $_SESSION["plateau_pre"] = $_SESSION["plateau"];
      $_SESSION["plateau"][$posy - 1][$posx] = 'u';
      $_SESSION["plateau"][$posy - 2][$posx] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
      $_SESSION["billes"]--;
      return true;
    }
    else
    {
      return false;
    }
  }

  //Action de jeu vers le bas
  public function moveDown()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy + 1][$posx] == 'o' && $_SESSION["plateau"][$posy + 2][$posx] == 'u')
    {
      $_SESSION["plateau_pre"] = $_SESSION["plateau"];
      $_SESSION["plateau"][$posy + 1][$posx] = 'u';
      $_SESSION["plateau"][$posy + 2][$posx] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
      $_SESSION["billes"]--;
      return true;
    }
    else
    {
      return false;
    }
  }

  //Action de jeu vers la gauche
  public function moveLeft()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy][$posx - 1] == 'o' && $_SESSION["plateau"][$posy][$posx - 2] == 'u')
    {
      $_SESSION["plateau_pre"] = $_SESSION["plateau"];
      $_SESSION["plateau"][$posy][$posx - 1] = 'u';
      $_SESSION["plateau"][$posy][$posx - 2] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
      $_SESSION["billes"]--;
      return true;
    }
    else
    {
      return false;
    }
  }

  //Action de jeu vers la droite
  public function moveRight()
  {
    $posx = (int) $_POST["case"][0];
    $posy = (int) $_POST["case"][1];
    if($_SESSION["plateau"][$posy][$posx + 1] == 'o' && $_SESSION["plateau"][$posy][$posx + 2] == 'u')
    {
      $_SESSION["plateau_pre"] = $_SESSION["plateau"];
      $_SESSION["plateau"][$posy][$posx + 1] = 'u';
      $_SESSION["plateau"][$posy][$posx + 2] = 'o';
      $_SESSION["plateau"][$posy][$posx] = 'u';
      $_SESSION["billes"]--;
      return true;
    }
    else
    {
      return false;
    }
  }

  //Calculer le nombre de coups possible sur le plateau de la session
  public function calcCoups()
  {
    $coups = 0;
    for($ligne = 0; $ligne < 7; $ligne++)
    {
      for($colonne = 0; $colonne < 7; $colonne++)
      {
        if($_SESSION["plateau"][$colonne][$ligne] == 'o') // on teste toutes les billes sur le plateau
        {
          //Haut
          if($colonne >= 2) // Nécéssaire pour PHP 5, inutile pour PHP 7
          {
            if($_SESSION["plateau"][$colonne - 1][$ligne] == 'o' && $_SESSION["plateau"][$colonne - 2][$ligne] == 'u')
            {
              $coups++;
            }
          }

          //Bas
          if($colonne <= 4)
          {
            if($_SESSION["plateau"][$colonne + 1][$ligne] == 'o' && $_SESSION["plateau"][$colonne + 2][$ligne] == 'u')
            {

              $coups++;
            }
          }

          //Gauche
          if($ligne >= 2)
          {
            if($_SESSION["plateau"][$colonne][$ligne - 1] == 'o' && $_SESSION["plateau"][$colonne][$ligne - 2] == 'u')
            {
              $coups++;
            }
          }

          //Droite
          if($ligne <= 4)
          {
            if($_SESSION["plateau"][$colonne][$ligne + 1] == 'o' && $_SESSION["plateau"][$colonne][$ligne + 2] == 'u')
            {
              $coups++;
            }
          }
        }
      }
    }
    $_SESSION["coups_j"] = $coups;
  }

  //Annuler le coup précédent
  public function cancel()
  {
    $_SESSION["plateau"] = $_SESSION["plateau_pre"];
    $_SESSION["billes"]++;
    unset($_SESSION["plateau_pre"]);
  }


  /*******************************
  *********BASE DE DONNEES********
  ********************************/

  //Récupérer le classement général
  public function getClassements()
  {
    $statement = $this->connexion->prepare("SELECT * FROM parties;");
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  //Récupérer le classement du joueur connecté
  public function getClassementJoueur()
  {
    $statement = $this->connexion->prepare("SELECT * FROM parties WHERE pseudo=?;");
    $statement->bindParam(1, $_SESSION["pseudo"]);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  //Récupérer les 3 joueurs ayant le plus de parties gagnées
  public function getTop3()
  {
    $statement = $this->connexion->prepare("SELECT id, pseudo, partieGagnee, partieJouee FROM parties ORDER BY partieGagnee DESC LIMIT 3");
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  //Enregistrer une partie gagnée (et une partie jouée)
  public function adVictoriam()
  {
    $this->addPartieJouee();
    $statement = $this->connexion->prepare("UPDATE parties SET partieGagnee = partieGagnee + 1 WHERE pseudo=?");
    $statement->bindParam(1, $_SESSION["pseudo"]);
    $statement->execute();
  }

  //Enregistrer une partie jouée
  public function addPartieJouee()
  {
    $statement = $this->connexion->prepare("SELECT partieJouee FROM parties WHERE pseudo=?");
    $statement2 = $this->connexion->prepare("INSERT INTO parties (id, pseudo, partieGagnee, partieJouee) VALUES (NULL, ?, 0, 1)");
    $statement3 = $this->connexion->prepare("UPDATE parties SET partieJouee = partieJouee + 1 WHERE pseudo=?");
    $statement->bindParam(1, $_SESSION["pseudo"]);
    $statement2->bindParam(1, $_SESSION["pseudo"]);
    $statement3->bindParam(1, $_SESSION["pseudo"]);

    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$res)//True si un enregistrement existe déjà
    {
      $statement2->execute();//Insertion
    }
    else
    {
      $statement3->execute();//Incrémentation
    }
  }

  //Déconnexion de la base
  public function deconnexion()
  {
    $this->connexion=null;
    unset($_POST);
    unset($_SESSION['pseudo']);
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
