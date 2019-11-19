
<?php

if(file_exists('dao/livrosDAO.php')){
    require_once 'dao/livrosDAO.php';
}else if(file_exists('../DAO/livrosDAO.php')){
    require_once '../DAO/livrosDAO.php';
}else if(file_exists('../../DAO/livrosDAO.php')){
    require_once '../../DAO/livrosDAO.php';
}

switch ($_POST['action']) {
    case 'save':
        $_post = $_POST['form'];        
        parse_str($_post, $form);
        $dao = new livrosDAO();
        echo json_encode($dao->saveAreas($form));        
        break;
    case 'get_areas':
        $id = $_POST['id'];
        $dao = new livrosDAO();
        $result = $dao->getAreas($id);
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'del_area':
        $id = $_POST['id'];
        $dao = new livrosDAO();
        echo json_encode($dao->delArea($id));
        break;
    default:
        # code...
        break;
}

