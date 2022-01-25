<?php
session_start();
require_once("inc/config.php");
require_once("inc/classes.php");
$page = new SinglePage;
// check if loged
if(!$page->is_loged()){
    header('Location: login.php');
}

// Check if POST
if(isset($_POST['edit']) AND $_POST['edit']=='save' AND isset($_POST['id']) AND intval(strval($_POST['id']),10)>0  AND intval(strval($_POST['id']),10) == $_GET['id']){
    $update_id = intval(strval($_POST['id']),10);
    
    $update = $page->check_post($_POST);
    // echo '<pre>';
    // var_dump($update);
    // exit;
    if(count($update)>0){
        $page->save_edit($update,$update_id);
    }
 
}

// get ID
if(isset($_GET['id']) AND intval(strval($_GET['id']),10)>0){
    $id = intval(strval($_GET['id']),10);
    //set ID
    $page->set_id($id);

    // GET data from db
    $data['page_data'] = $page->get_page();
    $data['html_title'] = 'Редактиране';
    $data['menu_active'] = 'Редактиране';
    
    //categories
    $data['categories'][] = array('id'=>0, 'name'=>'Без категория');
    $data['categories'][] = array('id'=>1, 'name'=>'Новини');
    
    //call view
    $page->load_template('header', $data);
    $page->load_template('menu',$data);
    $page->load_template('edit_view',$data);


}






