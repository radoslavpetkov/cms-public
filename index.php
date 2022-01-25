<?php
require_once("inc/config.php");
require_once("inc/classes.php");
$data = array();
// $page = new Page;

// $db = new DB;
// $sql = "SELECT * FROM pages WHERE id=1";
// $data['home_page'] = $db->Select($sql);


// //page title
// $data['html_title'] = 'Начало';

// $page->load_template('header', $data);
// $page->load_template('menu', $data);
// $page->load_template('home', $data);
// $page->load_template('footer', $data);

$page = new HomePage;
$data['home'] = $page->GetData();

//page title
$data['html_title'] = 'Начало';
$data['menu_active'] = 'Начало';

$page->load_template('header', $data);
$page->load_template('menu', $data);
$page->load_template('home', $data);
$page->load_template('footer', $data);