
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
        echo json_encode($dao->saveLocais($form));        
        break;
    case 'get_locais':
        $id = $_POST['id'];
        $dao = new livrosDAO();
        $result = $dao->getLocais($id);
        echo json_encode($dao->utf8_encode_deep($result));        
        break;
    default:
        # code...
        break;
}

