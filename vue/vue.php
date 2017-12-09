<?php
//require_once PATH_METIER."/Message.php";
//header("Content-type: text/html; charset=utf-8");
class Vue
{
  function navBar()
  {
    ?>
    <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="Jeu : Solitaire">
      <meta name="author" content="Gabriel Derrien / Ilyas Fahmi">

      <!--CSS BOOTSTRAP-->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

      <!--CSS LOCAL-->
      <link rel="stylesheet" href="./css/main.css">

      <!--JAVASCRIPT-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
      <script src="https://use.fontawesome.com/d35de52d98.js"></script>

      <script>
      $(function ()
      {
        $('[data-toggle="popover"]').popover()
      })
      </script>
    </head>

    <body>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <span class="navbar-brand mb-0 h1">Solitaire</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <form class="form-inline my-2 my-lg-0" method="post" action="index.php">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <!--<a class="nav-link" href="index.php">Plateau <span class="sr-only">(current)</span></a>-->
                <button type="submit" class="btn btn-dark" name="menu" value="plateau">Plateau</input>
              </li>
              <li class="nav-item">
                <!--<a class="nav-link" href="#">A propos</a>-->
                <button type="submit" class="btn btn-dark" name="menu" value="class">Classements</input>
              </li>
            </ul>
          </form>
          <form class="form-inline my-2 my-lg-0 ml-auto" method="post" action="index.php">
            <span class="navbar-text" style='padding-right: 20px;'>
              <?php
              if(isset($_SESSION["pseudo"]))
              {
                echo "<i class='fa fa-user-circle' aria-hidden='true' style='padding-right: 5px;'> </i> <strong>".$_SESSION["pseudo"]."</strong> </span> <input class='btn btn-danger' type='submit' name='logoff' value='Déconnexion'></input>";
              }
              else
              {
                echo "Connexion [toto | toto]</span>";
              }
              ?>
          </form>
        </div>
      </nav>
      <?php
  }

  //Formulaire d'Authentification
  function vueLogin($arg)
  {
    if(!$arg)
    {
      ?>
      <form class="form-signin" method="post" action="index.php">
        <h2 class="form-signin-heading">Veuillez vous connecter</h2>
        <label for="inputText" class="sr-only">Pseudo</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Pseudo" required autofocus name="pseudo">
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required name="passw">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
      </form>
      <?php
    }
    else
    {
      ?>
      <form class="form-signin" method="post" action="index.php">
        <h2 class="form-signin-heading">Veuillez vous connecter</h2>
        <label for="inputText" class="sr-only">Pseudo</label>
        <input type="text" id="inputEmail" class="form-control is-invalid" placeholder="Pseudo" required autofocus name="pseudo">
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" class="form-control is-invalid" placeholder="Mot de passe" required name="passw">
        <div class="invalid-feedback">
          Identifiant ou mot de passe incorrect(s).
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
      </form>
      <?php
    }
  }

  //Vue des classements
  function vueClassements($classj, $top3, $classg)
  {
    ?>
      <div class="container">
        <h1>Casse-tête : Le Solitaire <small class="text-muted">(Peg solitaire)</small></h1>
        <hr class="my-4">
        <h2>Classements</h2>
      </div>
    </br>
      <div class="container">
        <div class="row">
          <!--STATISTIQUES JOUEUR CONNECTÉ-->
          <div class="col-lg-6 card card-body text-white bg-info mb-1">
            <h3>Vous</h3>
            <table class="table table-striped text-white">
              <thead>
                <tr>
                  <th scope="col">Parties gagnées</th>
                  <th scope="col">Parties perdues</th>
                  <th scope="col">Ratio Vict/Def</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($classj as $id)
                {
                  echo "<tr>";
                  $i = 0;
                  foreach($id as $val)
                  {
                    if($i < 2)
                    {
                      $i++;
                    }
                    else
                    {
                      if($val == $_SESSION["pseudo"])
                      {
                        echo "<td class='table-dark'><strong>".$val."</strong></br>";
                      }
                      else
                      {
                        echo "<td>".$val."</br>";
                      }
                      $i++;
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!--STATISTIQUES TOP 3-->
          <div class="col-lg-6 card card-body text-white bg-success mb-1">
            <h3>Top 3</h3>
            <table class="table table-striped text-white">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pseudo</th>
                  <th scope="col">Parties gagnées</th>
                  <th scope="col">Parties perdues</th>
                  <th scope="col">Ratio Vict/Def</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $y = 0;
                foreach($top3 as $id)
                {
                  echo "<tr>";
                  $i = true;
                  foreach($id as $val)
                  {
                    if($i)
                    {
                      echo "<th scope='row'>".++$y."</th>";
                      $i = false;
                    }
                    else
                    {
                      if($val == $_SESSION["pseudo"])
                      {
                        echo "<td class='table-dark'><strong>".$val."</strong></br>";
                      }
                      else
                      {
                        echo "<td>".$val."</br>";
                      }
                      $i++;
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <!--STATISTIQUES TOUS JOUEURS-->
          <div class="col-lg-12 card card-body text-white bg-secondary mb-1">
            <h3>Classement général</h3>
            <table class="table table-striped table-sm  text-white">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Pseudo</th>
                  <th scope="col">Parties gagnées</th>
                  <th scope="col">Parties perdues</th>
                  <th scope="col">Ratio Vict/Def</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $y = 0;
              foreach($classg as $id)
              {
                echo "<tr>";
                $i = true;
                foreach($id as $val)
                {
                  if($i)
                  {
                    echo "<th scope='row'>".++$y."</th>";
                    $i = false;
                  }
                  else
                  {
                    if($val == $_SESSION["pseudo"])
                    {
                      echo "<td class='table-dark'><strong>".$val."</strong></br>";
                    }
                    else
                    {
                      echo "<td>".$val."</br>";
                    }
                    $i++;
                  }
                }
              }
              ?>
            </table>
          </div>
        </div>
      </div>
    <?php
  }

  function vueAbout()
  {
    ?>

    <?php
  }

  function vuePlateau()
  {
    ?>
    <div class="container">
      <h1>Casse-tête : Le Solitaire <small class="text-muted">(Peg solitaire)</small></h1>
      <p class="lead">A vous de jouer !
      <hr class="my-4">
      <h2>Le plateau</h2>
      Les règles sont simples : Le but est de retirer toutes les billes jusqu'à ce qu'il n'en reste plus qu'une.
      Pour "manger" une bille, il faut qu'une bille puisse sauter par dessus une autre, sous réserve que la case d'arrivée soit vide !
      Sélectionnez en une pour manger celle qui se trouve à côté d'elle. Pas de diagonale possible !
    </div>
    </br>
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <form method="post" action="index.php">
            <table border="1" class="table table-bordered" id="plateau">
              <tr>

    <?php

    $iy = 0;
    $ix = 0;
    foreach( $_SESSION["plateau"] as $val )
    {
      foreach( $val as $key )
      {
        $pos = $ix.$iy;
        if ($key == "o")
        {
          ?>
          <td class="border border-secondary" bgcolor="#fff">
            <label class="custom-control custom-radio">
              <input id="radio1" name="case" type="radio" class="custom-control-input" value="<?php echo $pos ?>">
              <span class="custom-control-indicator"></span>
            </label>
          </td>
          <?php
        }
        else
        {
          if($key == "u")
          {
            //echo '<td bgcolor="#fff"></td>';
            ?>
            <td class="border border-secondary" bgcolor="#fff">
              <label class="custom-control custom-radio">
                <input id="radio1" name="case" type="radio" class="custom-control-input" value="<?php echo $pos ?>" disabled>
                <span class="custom-control-indicator"></span>
              </label>
            </td>
            <?php
          }
          else
          {
            echo '<td id="unplayable"></td>';
          }
        }
        $ix++;
        if($ix == 7)
        {
          $ix = 0;
        }
      }
      echo '</tr>';
      $iy++;
      if($iy == 7)
      {
        $iy = 0;
      }
    }
    echo '</table> </div>';
  }

  function coups()
  {
    ?>
    <div class="card card-body">
      <div class="col-lg-8">
        <div class="alert alert-info">
          Nombre de coups jouables :<strong> '.$_SESSION["coups_j"].'</strong>
        </div>
        <div class="alert alert-info">
          Nombre de billes restantes : <strong>'.$_SESSION["billes"].'</strong>
        </div>
    <?php
  }

  function start()
  {
    ?>
      <div class="col-lg-8">
        <div class="card card-body">
          <p><strong>Commencez par sélectionner n'importe quelle bille à retirer pour commencer à jouer</strong></p>
          <input type="submit" class="btn btn-primary" name="start_post" value="J'ai sélectionné ma bille de départ"/>
        </div>
      </div>
    </form>
    <?php
  }

  function vueFin()
  {
    ?>
        </br>
        <div class="alert alert-danger my-1" role="alert">
          Vous avez perdu ! Dommage !
        </div>
        <form method="post" action="index.php">
          <button type="submit" class="btn btn-info btn-lg btn-block" name="menu" value="class">Voir mes scores</button>
        </form>
      </div>
    </div>
    <?php
  }

  function vueGagne()
  {
    ?>
        </br>
        <div class="alert alert-success my-1" role="alert">
          Bravo vous avez gagné !
        </div>
        <form method="post" action="index.php">
          <button type="submit" class="btn btn-info btn-lg btn-block" name="menu" value="class">Voir mes scores</button>
        </form>
      </div>
    </div>
    <?php
  }

  function actionsJeu()
  {
    ?>
      <div class="col-lg-8">
        <div class="alert alert-info">
          Nombre de coups jouables  : <strong><?php echo $_SESSION["coups_j"] ?></strong>
        </div>
        <div class="alert alert-info">
          Nombre de billes restantes : <strong><?php echo $_SESSION["billes"] ?></strong>
      </div>
      <p>Sélectionnez une bille, puis un déplacement</p>
      <div class="btn-group">
        <button type="submit" class="btn btn-primary" name="direction" value="Haut"><i class="fa fa-arrow-up fa-2x" aria-hidden="true"></i></button>
        <button type="submit" class="btn btn-primary" name="direction" value="Bas"><i class="fa fa-arrow-down fa-2x" aria-hidden="true"></i></button>
        <button type="submit" class="btn btn-primary" name="direction" value="Gauche"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></button>
        <button type="submit" class="btn btn-primary" name="direction" value="Droite"><i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i></button>
      </div>
      <div class="btn-group">
        <?php
        if(isset($_SESSION["plateau_pre"]))
        {
          echo '<input type="submit" class="btn btn-warning" name="cancel" value="Annuler le coup précédent">';
        }
        ?>
        <input type="submit" class="btn btn-danger" name="reset_post" value="Remettre à zéro">
        </form>
      </div>
    <?php
  }

  function alerte($arg)
  {
    if($arg == "bille")
    {
      ?>
        <div class="alert alert-danger my-1" role="alert">
          <strong>Vous devez d'abord choisir une bille !</strong>
        </div>
      <?php
    }
    if($arg == "move")
    {
      ?>
        <div class="alert alert-danger my-1" role="alert">
          <strong>Déplacement impossible dans cette direction !</strong>
        </div>
      <?php
    }
  }
}
?>
