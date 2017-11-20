<?php
//require_once PATH_METIER."/Message.php";

class Vue
{

  function demandeLogin()
  {
    header("Content-type: text/html; charset=utf-8");
?>
    <html>
    <body>
    <br/>
    <br/>
    <form method="post" action="index.php">
      Entrer votre pseudo  <input type="text" name="pseudo"/>
    </br>
      Entrer votre mot de passe  <input type="text" name="passw"/>
      </br>
      <input type="submit" name="soumettre" value="envoyer"/>
      </form>
<?php
  }

  function afficheMessages($messages)
  {
    if(isset($_COOKIE['pseudo_auth']))
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
  }
}
?>
