<?php
require_once("inc/config.php");
require_once("inc/classes.php");
$data = array();

$page = new Page;

$db = new DB;
$sql = "SELECT * FROM pages WHERE id=2";
$result = $db->Select($sql);
$data['home'] = $result[0];


//page title
$data['html_title'] = $data['menu_active'] = 'Проекти';

$page->load_template('header', $data);
$page->load_template('menu', $data);
$page->load_template('home', $data);
$page->load_template('footer', $data);