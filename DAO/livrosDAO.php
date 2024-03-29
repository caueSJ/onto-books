<?php
if(file_exists('config/db/config.php')){
    require_once 'config/db/config.php';
    require_once 'config/db/mysqli.php';
    require_once 'arc2SPARQL.php';
    include_once('arc2/arc2.php');
}else if(file_exists('../config/db/config.php')){
    require_once '../config/db/config.php';
    require_once '../config/db/mysqli.php';
    require_once '../arc2SPARQL.php';
    include_once('../arc2/arc2.php');
}else if(file_exists('../../config/db/config.php')){
    require_once '../../config/db/config.php';
    require_once '../../config/db/mysqli.php';
    require_once '../../arc2SPARQL.php';
    include_once('../../arc2/arc2.php');
}

class livrosDAO {

    //======    START COMPRAS
    public function getLivros($idLivros='') {
        try {
            $qry = "SELECT l.*,l.titulo as titulo_short, a.nome as autor,lo.descricao as local, e.nome as editora, ar.descricao as area FROM livros l
            INNER JOIN autores a
            ON a.id_autor = l.id_autor
            INNER JOIN editoras e
            ON e.id_editora = l.id_editora
            INNER JOIN areas ar
            ON ar.id_area = l.id_area
            INNER JOIN locais lo
            ON lo.id_local = l.id_local";
            if($idLivros !=''){
                $qry.= " WHERE l.id_livro IN ($idLivros)
                ORDER BY FIELD(l.id_livro,$idLivros) ";
            }else{
                $qry.= " ORDER BY l.titulo ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function buscaLivros($busca, $tipo) {
        try {
            $busca = str_replace(' ',' +','+'.trim($busca));
            $qry = "SELECT l.id_livro FROM livros l
            INNER JOIN autores a
            ON a.id_autor = l.id_autor
            INNER JOIN editoras e
            ON e.id_editora = l.id_editora
            INNER JOIN areas ar
            ON ar.id_area = l.id_area";
            switch ($tipo){
                case '2':
                $qry.= " where match(l.titulo) against('$busca' IN BOOLEAN MODE)";
                break;
                case '3':
                $qry.= " where match(a.nome) against('$busca' IN BOOLEAN MODE)";
                break;
                case '4':
                $qry.= " where match(e.nome) against('$busca' IN BOOLEAN MODE)";
                break;
                case '5':
                $qry.= " where match(ar.descricao) against('$busca' IN BOOLEAN MODE)";
                break;
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row['id_livro'];
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public function getTermosLivros() {
        try {
            //            $onto = new Ontologia();
            //            $livros = $onto->getLivros();
            //            $ids = implode(",", $livros);
            $qry = "SELECT * from livros order by titulo ;";

            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getAutores($id='') {
        try {
            $qry = "SELECT id_autor as id, nome as text FROM autores ";
            if($id !=''){
                $qry .= "  WHERE id_autor = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getEditoras($id='') {
        try {
            $qry = "SELECT id_editora as id, nome as text FROM editoras ";
            if($id !=''){
                $qry .= "  WHERE id_editora = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public function saveLivros($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_livro'])) {
                $id = $form['id_livro'];
                unset($form['id_livro']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('livros', $form, ' WHERE id_livro = ' . $id)) $erro = true;
                if(isset($_FILES['anexo_gerencia'])){
                    if(!$this->defaultUpload('../img/livros/',$id, 'anexo_gerencia'))$erro = true;
                }
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }

            } else {

                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO livros SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;
                if(isset($_FILES['anexo_gerencia'])){
                    if(!$this->defaultUpload('../img/livros/',$id, 'anexo_gerencia'))$erro = true;
                }
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveAutores($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_autor'])) {
                $id = $form['id_autor'];
                unset($form['id_autor']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('autores', $form, ' WHERE id_autor = ' . $id)) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {

                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO autores SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;

                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveEditoras($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_editora'])) {
                $id = $form['id_editora'];
                unset($form['id_editora']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('editoras', $form, ' WHERE id_editora = ' . $id)) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {

                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO editoras SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;

                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveAreas($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_area'])) {
                $id = $form['id_area'];
                unset($form['id_area']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('areas', $form, ' WHERE id_area = ' . $id)) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO areas SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;

                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveTermos($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_termo'])) {
                $id = $form['id_termo'];
                unset($form['id_termo']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('termos', $form, ' WHERE id_termo = ' . $id)) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO termos SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;

                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveLocais($form) {
        try {
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_local'])) {
                $id = $form['id_local'];
                unset($form['id_local']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('locais', $form, ' WHERE id_local = ' . $id)) $erro = true;
                if(isset($_FILES['anexo_gerencia'])){
                    if(!$this->defaultUpload('../img/locais/',$id, 'anexo_gerencia'))$erro = true;
                }
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO locais SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;
                if(isset($_FILES['anexo_gerencia'])){
                    if(!$this->defaultUpload('../img/locais/',$id, 'anexo_gerencia'))$erro = true;
                }
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function saveUsuario($form) {
        try {
            $login = preg_replace('/[^[:alnum:]_]/', '', isset($form['login']) ? $form['login'] : '');
            $pass = preg_replace('/[^[:alnum:]_]/', '', isset($form['senha']) ? $form['senha'] : '');
            $form['senha'] = md5($pass);
            $form['login'] = $login;
            $db = new dbConn();
            $this->utf8_decode_deep($form);
            if (isset($form['id_usuario'])) {
                $id = $form['id_usuario'];
                unset($form['id_usuario']);
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                if(!$db->update('usuarios', $form, ' WHERE id_usuario = ' . $id)) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            } else {
                $form = array_filter($form);
                $db->mysqli()->begin_transaction();
                $erro = false;
                $sql = $this->arrayToSQL($form,$db);
                $db->mysqli()->query('INSERT INTO usuarios SET '.$sql);
                $id = mysqli_insert_id($db->mysqli());
                if(!$id) $erro = true;
                if($erro){
                    $db->mysqli()->rollback();
                    $db->mysqli()->close();
                    return false;
                }else{
                    $db->mysqli()->commit();
                    $db->mysqli()->close();
                    return $id;
                }
            }

            return $id;
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    function arrayToSQL($array,$db){
        $data   = array();
        foreach ($array as $key => $value) {
            if(substr($key,0,2)=='--'){
                $data[] = substr($key,2). "=" . $value;
            }else{
                $data[] = str_replace('==', '=', $db->escape($key) . "='" . $db->escape($value) . "'");
            }
        }
        $data = implode(', ', $data);
        return $data;
    }
    public function getAreas($id='') {
        try {
            $qry = "SELECT id_area as id, descricao as text FROM areas ";
            if($id !=''){
                $qry .= "  WHERE id_area = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getLocais($id='') {
        try {
            $qry = "SELECT id_local as id, descricao as text FROM locais ";
            if($id !=''){
                $qry .= "  WHERE id_local = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getUsuarios($id='') {
        try {
            $qry = "SELECT * FROM usuarios ";
            if($id !=''){
                $qry .= "  WHERE id_usuario = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function toggleUsuario($id) {
        try {
            $qry = "UPDATE usuarios SET ativo = IF(ativo=0,1,0) where id_usuario = $id ";
            $db = new dbConn();
            $db->query($qry);
            return true;

        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getTermos($id='') {
        try {
            $qry = "SELECT id_termo as id, descricao as text FROM termos ";
            if($id !=''){
                $qry .= "  WHERE id_termo = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getTermosNovo($id='') {
        try {
            $qry = "SELECT descricao as id, descricao as text FROM termos ";
            if($id !=''){
                $qry .= "  WHERE id_termo = $id ";
            }
            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function login($usuario, $senha) {
        try {
            $qry = "select * from usuarios where login = '$usuario' AND senha ='$senha' AND ativo; ";

            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function importar($id) {
        try {
            $qry = "select * from temp_relacionamentos WHERE termo='aberta' and idlivro = 32";

            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
    public function getIdsLivros() {
        try {
            $qry = "select * from temp_relacionamentos where idlivro = 32 GROUP BY idlivro";

            $db = new dbConn();
            $result = $db->query($qry);
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $r[$i] = $row;
                    $i++;
                }
                return $r;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }


    function defaultUpload($folderPath, $fileName,$uploadName='fileToUpload'){
        if ($_FILES[$uploadName]['size'] > 0) {
            if ($_FILES[$uploadName]['size'] <= 5360000) {
                $path = $_FILES[$uploadName]['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $ext = strtolower($ext);

                //            if (($ext == "pdf")) {
                $cont = 1;
                $file =$folderPath.$fileName.'.*';
                $fileOld = $folderPath.$fileName."_old_" . $cont . ".*";
                if (!empty(glob($file))) {
                    while (!empty(glob($fileOld))) {
                        $cont = $cont + 1;
                        $fileOld = $folderPath.$fileName."_old_" . $cont . ".*";
                    }
                    $arquivo = glob($folderPath.$fileName.".*");
                    $info = pathinfo($arquivo[0]);
                    $extensao = $info["extension"];
                    rename($folderPath.$fileName. "." . $extensao, $folderPath.$fileName."_old_" . $cont . "." . $extensao);
                }
                if (move_uploaded_file($_FILES[$uploadName]['tmp_name'], $folderPath.$fileName.'.'.$ext)) {
                    return true;
                } else {
                    return false;
                }
                //            } else {
                //                return json_encode('typeerror');
                //            }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function utf8_decode_deep(&$input) {
        if (is_string($input)) {
            $input = utf8_decode($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                $this->utf8_decode_deep($value);
            }
        }
    }

    function utf8_encode_deep($dat) {
        if (is_string($dat))
        return utf8_encode($dat);
        if (!is_array($dat))
        return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
        $ret[$i] = $this->utf8_encode_deep($d);
        return $ret;
    }
}
