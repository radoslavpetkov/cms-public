<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");
$page = new Upload;
// check if loged
if(!$page->is_loged()){
    header('Location: login.php');
}

//if $_FILES
if(isset($_POST['upload']) AND isset($_FILES['fileToUpload']['name']) AND strlen($_FILES['fileToUpload']['name'])>4){
    if($page->upload_file($_FILES['fileToUpload'])){
        $_SESSION['success'][] = 'Файлът е качен успешно!';
    }
}

// GET FILES

$data['files'] = $page->get_files();

// Lolad view

$data['html_title'] = 'Файлове';
$data['menu_active'] = 'Файлове';

$page->load_template('header', $data);
$page->load_template('menu',$data);
$page->load_template('upload_view',$data);