<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");
$page = new SinglePage;
// check if loged
if(!$page->is_loged()){
    header('Location: login.php');
}

