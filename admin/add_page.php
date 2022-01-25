<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");
$page = new SinglePage;
// check if loged
if(!$page->is_loged()){
    header('Location: login.php');
}

$data['page_data']['title'] = '';
$data['page_data']['summary'] = '';
$data['page_data']['content'] = '';
$data['page_data']['category_id'] = 1;

//if post
if(isset($_POST['addpage']) AND $_POST['addpage']=='save' ){
    
    $addpage = $page->check_post($_POST);
    // echo '<pre>';
    // var_dump($addpage);
    // die();
    if(is_array($addpage) AND count($addpage)>0){
		$addpage['creator_id'] = $_SESSION['user']['id'];
		$addpage['active'] = 1;
        $page->add_page($addpage);
    }
 
}

//check data

// Insert


//categories
$data['categories'][] = array('id'=>0, 'name'=>'Без категория');
$data['categories'][] = array('id'=>1, 'name'=>'Новини');
$data['html_title'] = 'Нова Страница';
$data['menu_active'] = 'Нова Страница';

//call view
$page->load_template('header', $data);
$page->load_template('menu',$data);
$page->load_template('add_page_view',$data);
