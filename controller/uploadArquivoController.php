<?php

if(file_exists('dao/livrosDAO.php')){
    require_once 'dao/livrosDAO.php';
}else if(file_exists('../DAO/livrosDAO.php')){
    require_once '../DAO/livrosDAO.php';
}else if(file_exists('../../DAO/livrosDAO.php')){
    require_once '../../DAO/livrosDAO.php';
}

if (isset($_FILES['uploadArquivo'])) {
    $arquivo_temp = $_FILES['uploadArquivo']['tmp_name'];

    // Lê arquivo e transforma em array
    $dados = file($arquivo_temp);

    /*
    Legenda dos códigos MARC21
    Titulo: 245
    Edição: 250
    Autor: 100
    Editora: 260
    */

    // Percorre arquivo procurando pelos códigos de interesse
    if(preg_match('/LIVRO/',$dados[0])){
        foreach($dados as $linha) {
            $linha = trim($linha);
            if (preg_match('/245/',$linha)){
                $titulo = explode('245 ## $a ', $linha)[1];
            } elseif (preg_match('/100/',$linha)){
                $autor = explode('100 ## $a ', $linha)[1];
            } elseif (preg_match('/250/',$linha)){
                $edicao = explode('250 ## $a ', $linha)[1];
            } elseif (preg_match('/260/',$linha)){
                $editora = explode('260 ## $a ', $linha)[1];
            }
        }

        $dao = new livrosDAO();

        $autorId = $dao->verificarSeExiste($autor, 'autores');
        $editoraId = $dao->verificarSeExiste($editora, 'editoras');

        if (is_numeric($autorId) && is_numeric($autorId)) {
            $dadosCadastrarLivro = array(
                'titulo'     => $titulo,
                'id_autor'   => $autorId,
                'id_editora' => $editoraId,
                'edicao'     => $edicao
            );

            $id = $dao->saveLivroUpload($dadosCadastrarLivro);

            if(is_numeric($id)){
                echo json_encode($id);
            } else {
                echo json_encode(false);
            }
        } elseif (!$autorId) {
            echo json_encode("Erro ao Cadastrar Autor");
        } elseif (!$editoraId) {
            echo json_encode("Erro ao Cadastrar Editora");
        }
    } else {
        echo json_encode("Não é um livro");
    }
}