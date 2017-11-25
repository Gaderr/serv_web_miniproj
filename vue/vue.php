<?php
//require_once PATH_METIER."/Message.php";

class Vue
{

  function vueLogin()
  {
    header("Content-type: text/html; charset=utf-8");
    ?>
    <html>
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

  function vuePlateau()
  {
    ?>
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
    <h3>Plateau</h3>
    <?php
    $plt = $_SESSION["plateau"];
    echo '<table border="1">';
    //echo '<tr><th>Movies</th><th>Genre</th><th>Director</th></tr>';
    foreach( $plt as $val )
    {
      echo '<tr>';
      foreach( $val as $key )
      {
        echo '<td>'.$key.'</td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  }

    /*function afficheMessages($messages)
    {
      if(isset($_SESSION["auth"]))
      {
        echo '<h1>'.$_COOKIE['pseudo_auth'].'</h1>'.'</br>';
      }
      foreach ($messages as $message)
      {
        echo "[$message->pseudo] $message->message<br />\n";
      }
      ?>
      </br>
      <form method="post" action="index.php">
      Votre message ? <input type="text" name="message"/>
      </br>
      </br>
      <input type="submit" name="soumettre" value="envoyer"/>
      <?php
    }*/
}
?>
