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
    </head>
    <body>
    <h1>Casse-tête : Le Solitaire</h1>
    <h2>
      <?php
      if(isset($_SESSION["pseudo"]))
      {
        echo "Joueur : ".$_SESSION["pseudo"];
      }
      else
      {
        echo "Pas d'utilisateur connecté / Site en mode tests";
      }
      ?>
    </h2>
    <p> toto / toto </p>
    <?php
  }

  function vueLogin()
  {
    ?>
    <form method="post" action="index.php">
    Entrer votre pseudo  <input type="text" name="pseudo"/>
    </br>
    Entrer votre mot de passe  <input type="text" name="passw"/>
    </br>
    <input type="submit" name="soumettre" value="envoyer"/>
    </form>
    <?php
  }

  function vuePlateau()
  {
    ?>
    <h3>Plateau</h3>
    <p>Le but du jeu est de retirer toutes les billes jusqu'à ce qu'il n'en reste plus qu'une.</p>
    <p>Pour "manger" une bille, il faut qu'une bille puisse sauter par dessus une autre, sous réserve que la case d'arrivée soit vide !</p>
    <p>Sélectionnez en une pour manger celle qui se trouve à côté d'elle. Pas de diagonale possible !</p>
    <?php

    echo '<form method="post" action="index.php">';
    echo '<table border="1"> <tr> <th></th>';
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
          echo '<td> <input type="radio" name="case" id="choixcase" value="'.$pos.'"></td>';
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

  function coups()
  {
    echo "<p>Nombre de coups jouables : ".$_SESSION["coups_j"]." coups.</p>";
  }

  function start()
  {
    ?>
      <p>Commencez par sélectionner n'importe quelle bille à retirer pour commencer à jouer</p>
      <input type="submit" name="start_post" value="J'ai sélectionné ma bille de départ"/>
    </form>
    <?php
  }

  function actionsJeu()
  {
    ?>
      <p>Sélectionnez une bille, puis un déplacement</p>
      <input type="submit" name="direction" value="Haut">
      <input type="submit" name="direction" value="Bas">
      <input type="submit" name="direction" value="Gauche">
      <input type="submit" name="direction" value="Droite">
    </form>
    <form method="post" action="index.php">
      <input type="submit" name="reset_post" value="Remettre à zéro">
    </form>
    <?php
  }
}
?>
