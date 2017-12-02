<?php
//require_once PATH_METIER."/Message.php";
//header("Content-type: text/html; charset=utf-8");
class Vue
{
  function titres()
  {
    ?>
    <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="Jeu : Solitaire">
      <meta name="author" content="Gabriel Derrien / Elias Fahmi">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

      <link rel="stylesheet" href="/css/main.css">

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
        <a class="navbar-brand" href="#">Solitaire</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Plateau <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">A propos</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" method="post" action="index.php">
            <span style='color: white;padding-right: 20px;'>
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

  function vueLogin()
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

  function vuePlateau()
  {
    ?>
    <div class="container">
      <h1>Casse-tête : Le Solitaire <small class="text-muted">Plateau anglais</small></h1>
      <p class="lead">A vous de jouer !
      <hr class="my-4">
      Les règles sont simples : Le but est de retirer toutes les billes jusqu'à ce qu'il n'en reste plus qu'une.
      Pour "manger" une bille, il faut qu'une bille puisse sauter par dessus une autre, sous réserve que la case d'arrivée soit vide !
      Sélectionnez en une pour manger celle qui se trouve à côté d'elle. Pas de diagonale possible !
    </div>

    <div class="container">

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
        if ($key == "o")
        {
          $pos = $ix.$iy;
          ?>
          <td bgcolor="#fff">
            <div style="height: 50px; overflow:hidden;">
              <label class="custom-control custom-radio">
                <input id="radio1" name="case" type="radio" class="custom-control-input" value="<?php echo $pos ?>">
                <span class="custom-control-indicator"></span>
              </label>
            </div>
          </td>
          <?php
        }
        else
        {
          if($key == "x")
          {
            echo '<td id="unplayable" bgcolor="#868e96"><div style="height: 25px;"></div> </td>';
          }
          else
          {
            echo '<td bgcolor="#fff"> </td>';
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
    echo '<div class="col-lg-8"> <div class="alert alert-info">Nombre de coups jouables :<strong> '.$_SESSION["coups_j"].' coups.</strong></div><div class="alert alert-info">Nombre de billes restantes : <strong>'.$_SESSION["billes"].'</strong></div>';
  }

  function start()
  {
    ?>
      <div class="col-lg-8">
        <div class="card card-body">
          Commencez par sélectionner n'importe quelle bille à retirer pour commencer à jouer
        </div>
        <input type="submit" class="btn btn-primary btn-lg btn-block" name="start_post" value="J'ai sélectionné ma bille de départ"/>
      </div>
    </form>
    <?php
  }

  function vueFin()
  {
    ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="alert alert-danger" role="alert">
            Vous avez perdu ! Dommage ! Voulez-vous recommencer ?
          </div>
          <form method="post" action="index.php">
            <input type="submit" class="btn btn-success btn-lg btn-block" name="reset_post" value="Recommencer !">
          </form>
        </div>
      </div>
    </div>
    <?php
  }

  function vueGagne()
  {
    ?>
    </div>
    </br>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="alert alert-success" role="alert">
            Bravo vous avez gagné ! Souhaitez-vous recommencer ?
          </div>
          <form method="post" action="index.php">
            <input type="submit" class="btn btn-success btn-lg btn-block" name="reset_post" value="Recommencer !">
          </form>
        </div>
      </div>
    </div>
    <?php
  }

  function actionsJeu()
  {
    ?>
          <p>Sélectionnez une bille, puis un déplacement</p>
          <div class="btn-group">
            <input type="submit" class="btn btn-primary" name="direction" value="Haut">
            <input type="submit" class="btn btn-primary" name="direction" value="Bas">
            <input type="submit" class="btn btn-primary" name="direction" value="Gauche">
            <input type="submit" class="btn btn-primary" name="direction" value="Droite">
            <input type="submit" class="btn btn-warning" name="reset_post" value="Remettre à zéro">
          </form>
        </div>
      </div>
    <?php
  }
}
?>
