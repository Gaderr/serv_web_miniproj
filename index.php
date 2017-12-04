<?php

session_start();
$_SESSION["auth"] = false;

require "config/config.php";
require PATH_CONTROLEUR."/routeur.php";

$routeur=new Routeur();
$routeur->routerRequete();
?>
