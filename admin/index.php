<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");

$page = new AllPages;
// check if loged
if(!$page->is_loged()){
    header('Location: login.php');
}

$data['pages'] = $page->get_all();

//page title
$data['html_title'] = 'Страници | '.SITE_NAME;

$data['menu_active'] = 'Страници';

$page->load_template('header', $data);
$page->load_template('menu', $data);
$page->load_template('list_view', $data);
$page->load_template('footer', $data);