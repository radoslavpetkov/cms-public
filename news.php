<?php
require_once("inc/config.php");
require_once("inc/classes.php");
$data = array();
$page = new NewsPage;

// if news to show - show single news
if(isset($_GET['id']) and intval(strval($_GET['id']),10)>0){
    $id = intval(strval($_GET['id']),10);
    $data['singe_news'] = $page->GetOne($id);


}else{
    // else show last 10
    $data['last_news'] = $page->GetLast(10);
    $id = false;


}





//page title
$data['html_title'] = $data['menu_active'] = 'Новини';

$page->load_template('header', $data);
$page->load_template('menu', $data);
if($id !== false){
    $page->load_template('news_view', $data);
}else{
    $page->load_template('news_blog_view', $data);
}

$page->load_template('footer', $data);