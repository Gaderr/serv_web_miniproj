<?php

session_start();
$_SESSION["auth"] = false;

require "config/config.php";
require PATH_CONTROLEUR."/Routeur.php";

$routeur=new Routeur();
$routeur->routerRequete();
?>
