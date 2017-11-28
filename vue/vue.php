<?php
//require_once PATH_METIER."/Message.php";

class Vue
{
  function vueLogin()
  {
    header("Content-type: text/html; charset=utf-8");
    ?>
    <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
    <h1>Solitaire</h1>
    <form method="post" action="index.php">
    Entrer votre pseudo  <input type="text" name="pseudo"/>
    </br>
    Entrer votre mot de passe  <input type="text" name="passw"/>
    </br>
    <input type="submit" name="soumettre" value="envoyer"/>
    </form>
    <?php
  }

  function menu()
  {
    ?>
    <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
    <h1>Solitaire</h1>
    <h2>
      <?php
      if(isset($_SESSION["pseudo"]))
      {
        echo $_SESSION["pseudo"];
      }
      else
      {
        echo "Pas d'utilisateur connecté / Site en mode tests";
      }
      ?>
    </h2>
    <?php
  }

  function vuePlateau()
  {
    ?>
    <h3>Plateau</h3>
    <p>Le but du jeu est de retirer toutes les billes jusqu'à ce qu'il n'en reste plus qu'une.</p>
    <p>Pour "manger" une bille, sélectionnez en une pour manger celle qui se trouve à côté d'elle. Pas de diagonale possible !</p>
    <?php

    echo '<form method="post" action="index.php"> <table border="1">';
    echo '<tr> <th></th>';
    for($ix = 0; $ix < 7; $ix++)
    {
      echo '<th>'.$ix.'</th>';
    }
    echo '</tr>';

    $iy = 0;
    $ix = 0;
    foreach( $_SESSION["plateau"] as $val )
    {
      echo '<tr><td><b>'.$iy.'</b></td>';
      foreach( $val as $key )
      {
        if ($key=="o")
        {
          $pos = $ix.$iy;
          echo '<td> <input type="radio" name="casedep" id="choixcase" value="'.$pos.'"></td>';
        }
        else
        {
          echo '<td> </td>';
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
    echo '</table>';
  }

  function start()
  {
    ?>
    <p>Sélectionnez une bille à retirer pour commencer à jouer</p>
    <input type="submit" name="J'ai sélectionné ma bille de départ" value="envoyer"/>
    </form>
    <?php
  }

  function jeu()
  {
    ?>
    <p>C'est parti !</p>
    <?php
  }
}
?>
