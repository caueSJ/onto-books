
<?php

if(file_exists('dao/livrosDAO.php')){
    require_once 'dao/livrosDAO.php';
    require_once 'arc2SPARQL.php';
}else if(file_exists('../DAO/livrosDAO.php')){
    require_once '../DAO/livrosDAO.php';
    require_once '../arc2SPARQL.php';
}else if(file_exists('../../DAO/livrosDAO.php')){
    require_once '../../DAO/livrosDAO.php';
    require_once '../../arc2SPARQL.php';
}



switch ($_POST['action']) {
    case 'save':
        $id = $_POST['livro'];        
        $termos = json_decode($_POST['termos']);
        $onto = new Ontologia();
        $result = $onto->saveTermos($id,$termos); 
        $dao = new livrosDAO();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'importar':
        $dao = new livrosDAO();
        
        $livros = $dao->getIdsLivros();
        $termos = array();        
        foreach ($livros as $livro){
            $relate = $dao->importar($livro['idlivro']);
            $id = $livro['idlivro'];
            foreach ($relate as $relation){ 
                $termo = new stdClass();
                $termo->termo = $relation['termo'];
                $termo->relacionamento = $relation['relacionamento'];                         
                array_push($termos, $termo);
            }
            $onto = new Ontologia();
            $result = $onto->saveTermos($id,$termos);            
            echo json_encode($dao->utf8_encode_deep($id.'>>>>>>>>>>>>>>> '.$termos));
        }
        
        
        
        
        //echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'get_termos_livros':
        $id = $_POST['id'];
        $onto = new Ontologia();
        $result = $onto->getLivros($id);
        $dao = new livrosDAO();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    case 'get_termos':
        $dao = new livrosDAO();
        $result = $dao->getTermosNovo();
        echo json_encode($dao->utf8_encode_deep($result));
        break;
    default:
        # code...
        break;
}

