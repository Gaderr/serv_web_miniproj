<?php

session_start();
$_SESSION["auth"] = false;

require "config/config.php";
require PATH_CONTROLEUR."/Routeur.php";
//require PATH_BOOTSTRAP."/css/bootstrap.min.css";
//require PATH_BOOTSTRAP."/js/bootstrap.min.js";
//require "jquery-3.2.1.min.js";

$routeur=new Routeur();
$routeur->routerRequete();
?>
