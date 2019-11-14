<?php

if(file_exists('arc2SPARQL.php')){
    require_once 'arc2SPARQL.php';
    include_once('arc2/arc2.php');
    require_once 'dao/livrosDAO.php';
}else if(file_exists('../arc2SPARQL.php')){
    require_once '../arc2SPARQL.php';
    include_once('../arc2/arc2.php');
    require_once '../dao/livrosDAO.php';
}else if(file_exists('../../arc2SPARQL.php')){
    require_once '../../arc2SPARQL.php';
    include_once('../../arc2/arc2.php');
    require_once '../../dao/livrosDAO.php';
}

switch ($_POST['tipo']){
    case '1':
        $termos = preg_split('/[\s,]+/', $_POST['busca']);
        $whereClause = '';
        $ontologia = new Ontologia();
        $result = $ontologia->queryOntologia($termos,0);
        //Recebendo false do queryOntologia
        $response = array();
        $cont = 0;
        if($result){
            foreach($result as $id ){
                $found = false;
                foreach($response as $idIn ){
                    if($id == $idIn){
                        $found = true;
                    }
                }
                if(!$found){
                    $response[$cont] = $id;
                    $cont++;
                }
            }
            echo json_encode($response);
        }else{
            //Estou caindo aqui
            echo json_encode(false);
        }    
        break;
    default:
        $dao = new livrosDAO();
        $result = $dao->buscaLivros($_POST['busca'],$_POST['tipo']);
        if($result){
           echo json_encode(array_unique($result)); 
        }else{
            echo json_encode($result);
        }
        
        break;
}