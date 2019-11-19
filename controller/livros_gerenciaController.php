
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
        echo json_encode($dao->saveLivros($form));
        break;
    case 'get_livro':
        $id = $_POST['id'];
        $dao = new livrosDAO();
        $result = $dao->getLivros($id);
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'del_livro':
        $id = $_POST['id'];
        $dao = new livrosDAO();
        echo json_encode($dao->delLivro($id));
        break;
    case 'get_autores':
        $dao = new livrosDAO();
        $result = $dao->getAutores();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'get_editoras':
        $dao = new livrosDAO();
        $result = $dao->getEditoras();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'get_areas':
        $dao = new livrosDAO();
        $result = $dao->getAreas();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'get_locais':
        $dao = new livrosDAO();
        $result = $dao->getLocais();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    default:
        # code...
        break;
}

