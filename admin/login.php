<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");

$page = new User;
if($page->is_loged()){
    header('Location: index.php');
}
//page title
$data['html_title'] = 'Вход | '.SITE_NAME;

//if POST
if(isset($_POST['submit']) AND $_POST['submit'] == 'login' AND isset($_POST['protect']) AND $_POST['protect'] == $_SESSION['protect']){
    //reset protect
    $_SESSION['protect'] = 'xxx';

    //check username
    if(isset($_POST['username']) AND strlen(trim($_POST['username']))>0){
        $username = trim($_POST['username']);
    }else{
        $_SESSION['errors'][] = 'Потребителското име е задължително!';
    }

    // check password
    if(isset($_POST['password']) AND strlen(trim($_POST['password']))>0){
        $password = trim($_POST['password']);
    }else{
        $_SESSION['errors'][] = 'Не сте въвели парола!';
    }

    if(!isset($_SESSION['errors']) OR (isset($_SESSION['errors']) AND count($_SESSION['errors']) == 0)){
        if($page->check_user($username,$password)){
          header('Location: index.php');
          //exit;  
        }else{
            $_SESSION['errors'][] = 'Неправилно Име/Парола';
        }

        
    }
}



// PRotect
//$protect = md5(rand(1548, 939999).date('Ymdhis'));
$_SESSION['protect'] = $data['protect'] = md5(rand(1548, 939999).date('Ymdhis'));



//errors

//$data['menu_active'] = 'Начало';

$page->load_template('header', $data);
//$page->load_template('menu', $data);
$page->load_template('login_view', $data);
//$page->load_template('footer', $data);
