<?php

class Ontologia {
    public function queryOntologia($termos, $contTermos, $lista = array()) {
        if ($contTermos < count($termos)) {
            $lista[$contTermos] = array(
                'termo' => $termos[$contTermos],
                'opcional' => 0,
                'relacionamento'=> 'RelacionamentoForte'
            );
            $this->queryOntologia($termos, $contTermos + 1, $lista);
            $lista[$contTermos] = array(
                'termo' => $termos[$contTermos],
                'opcional' => 0,
                'relacionamento'=> 'RelacionamentoMedio'
            );
            $this->queryOntologia($termos, $contTermos + 1, $lista);
            $lista[$contTermos] = array(
                'termo' => $termos[$contTermos],
                'opcional' => 0,
                'relacionamento'=> 'RelacionamentoFraco'
            );
            $this->queryOntologia($termos, $contTermos + 1, $lista);
            $lista[$contTermos] = array(
                'termo' => $termos[$contTermos],
                'opcional' => 1,
                'relacionamento'=> 'RelacionamentoFraco'
            );
            $this->queryOntologia($termos, $contTermos + 1, $lista);
        } else {
            $contOpcionais = 0;
            $where ='';
            if($GLOBALS['whereClause'] !=''){
                $where.=' UNION ';
            }
            $where .='{';
            for ($i = 0; $i < $contTermos; $i++) {
                if ($lista[$i]['opcional']) {
                    $contOpcionais++;
                   // $where .= ' OPTIONAL {?Livro book:'.$lista[$i]['relacionamento'].' book:' . $lista[$i]['termo'] . ' }. ';
                } else {
                    $where .= ' ?Livro book:'.$lista[$i]['relacionamento'].'  book:' . $lista[$i]['termo'] . '.  ';
                }
            }
            $where .=' } ';
            if ($contOpcionais < $contTermos) {
                $GLOBALS['whereClause'] .= $where;
            }
        }
        if($contTermos == 0){
            return $this->getLivros('',$GLOBALS['whereClause']);
        }
        return $GLOBALS['whereClause'];
    }

    public function executarQuery($whereClause) {
        $config = array('db_host' => '127.0.0.1',
            'db_name' => 'arc2',
            'db_user' => 'root',
            'db_pwd' => '');
        $store = ARC2::getStore($config);
        if (!$store->isSetUp())
            $store->setUp();
        if(file_exists('owl/tcc-2.0.owl')){
            $store->query('LOAD <owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }else if(file_exists('../owl/tcc-2.0.owl')){
            $store->query('LOAD <../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }else if(file_exists('../../owl/tcc-2.0.owl')){
            $store->query('LOAD <../../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }
        $query = "PREFIX book: <urn:absolute:/2017/5/tcc-2.0.0#>
                 SELECT ?Livro
                  WHERE {
                    $whereClause
                  }";
        $result = array();
        $contRows = 0;
        if ($rows = $store->query($query,'rows')) {
            foreach ($rows as $row) {
                $result[$contRows] = preg_replace('/^.*\#([^\#]+)$/', '$1', $row['Livro']);
                $contRows++;
            }
        }
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $log = ("----------------------------------------------" . PHP_EOL .
                    strftime("%H:%M |") . PHP_EOL .
                    "          Query: " .$query . PHP_EOL);

        file_put_contents('../queryLogs/log_'.strftime("%d-%B-%Y").'.txt', $log, FILE_APPEND);
        return $result;
    }

    public function getLivros($id='',$where='') {
        $config = array('db_host' => 'localhost', /* default: localhost */
            'db_name' => 'arc2',
            'db_user' => 'root',
            'db_pwd' => '');
        $store = ARC2::getStore($config);
        
        if (!$store->isSetUp()) {
            $store->setUp();
        }

        if (file_exists('owl/tcc-2.0.owl')) {
            $store->query('LOAD <owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        } else if (file_exists('../owl/tcc-2.0.owl')) {
            $store->query('LOAD <../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        } else if (file_exists('../../owl/tcc-2.0.owl')) {
            $store->query('LOAD <../../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        } else if (file_exists('../../../owl/tcc-2.0.owl')) {
            $store->query('LOAD <../../../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }
        
        $query = ' PREFIX book: <urn:absolute:/2017/5/tcc-2.0.0#>
                 SELECT ?Livro ?termo ';

        if ($where!='') {
            $query = "PREFIX book: <urn:absolute:/2017/5/tcc-2.0.0#>
                 SELECT ?Livro
                  WHERE {
                    $where
                  }";
            $result = array();
            $contRows = 0;
            $found = false;
            if ($rows = $store->query($query, 'rows')) {
                foreach ($rows as $row) {
                    $result[$contRows] = preg_replace('/^.*\#([^\#]+)$/', '$1', $row['Livro']);
                    $contRows++;
                    $found = true;
                }
            }
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $log = ("----------------------------------------------" . PHP_EOL .
                        strftime("%H:%M |") . PHP_EOL .
                        "          Query: " .$query . PHP_EOL);

            file_put_contents('../queryLogs/log_'.strftime("%d-%B-%Y").'.txt', $log, FILE_APPEND);
            if ($found) {
                return $result;
            }
            return false;
        } else if ($id!='') {
            $query = ' PREFIX book: <urn:absolute:/2017/5/tcc-2.0.0#>
                 SELECT  ?termo ';
            $forte =$query." where{
                    {book:$id book:RelacionamentoForte ?termo.}}";
            $result = array();
            $contRows = 0;
            if ($rows = $store->query($forte,'rows')) {
                foreach ($rows as $row) {
                    //echo '.............'.$row['termo'].'.................';
                    $livro = array('termo'=>preg_replace('/^.*\#([^\#]+)$/', '$1', $row['termo']),
                                    'relacionamento'=>'forte');
                    $result[$contRows] = $livro;
                    $contRows++;
                }
            }


            $medio =$query." where{
                    {book:$id book:RelacionamentoMedio ?termo.}}";
            if ($rows = $store->query($medio,'rows')) {
                foreach ($rows as $row) {
                    $livro = array('termo'=>preg_replace('/^.*\#([^\#]+)$/', '$1', $row['termo']),
                                    'relacionamento'=>'medio');
                    $result[$contRows] = $livro;
                    $contRows++;
                }
            }
            $fraco =$query." where{
                    {book:$id book:RelacionamentoFraco ?termo.}}";
            if ($rows = $store->query($fraco,'rows')) {
                foreach ($rows as $row) {
                    $livro = array('termo'=>preg_replace('/^.*\#([^\#]+)$/', '$1', $row['termo']),
                                    'relacionamento'=>'fraco');
                    $result[$contRows] = $livro;
                    $contRows++;
                }
            }
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $log = ("----------------------------------------------" . PHP_EOL .
                        strftime("%H:%M |") . PHP_EOL .
                        "          Query: forte :  " .$forte . PHP_EOL." medio :  " .$medio . PHP_EOL." fraco :  " .$fraco . PHP_EOL);

            file_put_contents('../queryLogs/log_'.strftime("%d-%B-%Y").'.txt', $log, FILE_APPEND);
            return $result;
        }else{
            $query .=" where{
                    {?Livro book:RelacionamentoForte ?termo.}
                    UNION

                    {?Livro book:RelacionamentoMedio ?termo.}
                    UNION

                    {?Livro book:RelacionamentoFraco  ?termo.}}";
        }
        $result = array();
        $contRows = 0;
        if ($rows = $store->query($query,'rows')) {
            foreach ($rows as $row) {
                $result[$contRows] = preg_replace('/^.*\#([^\#]+)$/', '$1', $row['Livro']);
                $contRows++;
            }
        }
        return $result;
    }

    public function saveTermos($id,$termos) {
        $config = array('db_host' => '127.0.0.1', /* default: localhost */
            'db_name' => 'arc2',
            'db_user' => 'root',
            'db_pwd' => '');
        $store = ARC2::getStore($config);
        if (!$store->isSetUp())
            $store->setUp();
        if(file_exists('owl/tcc-2.0.owl')){
            $store->query('LOAD <owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }else if(file_exists('../owl/tcc-2.0.owl')){
            $store->query('LOAD <../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }else if(file_exists('../../owl/tcc-2.0.owl')){
            $store->query('LOAD <../../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }else if(file_exists('../../../owl/tcc-2.0.owl')){
            $store->query('LOAD <../../../owl/tcc-2.0.owl>'); //$store = ARC2::getRemoteStore($config);
        }

        $query = 'DELETE  {   <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoForte> ?termo }';
        $store->query($query);
        $query = 'DELETE  {   <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoMedio> ?termo }';
        $store->query($query);
        $query = 'DELETE  {   <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoFraco> ?termo }';
        $store->query($query);

        if ($errs = $store->getErrors()) {
            echo '------D------';
            print_r($errs);
            echo '------D------';
        }



        foreach ($termos as $termo){
            $termoNovo = $termo->termo;
            switch ($termo->relacionamento){
                case 'forte':
                    $query = 'INSERT INTO  <urn:absolute:/2017/5/tcc-2.0.0#>{
                               <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoForte> <urn:absolute:/2017/5/tcc-2.0.0#'.$termoNovo.'>  .
                                }';
                    $store->query($query);
                    if ($errs = $store->getErrors()) {
                        echo '-----I-------';
                        print_r($errs);
                        echo '----I--------';
                    }
                    break;
                case 'medio':
                    $query = 'INSERT INTO  <urn:absolute:/2017/5/tcc-2.0.0#>{
                               <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoMedio> <urn:absolute:/2017/5/tcc-2.0.0#'.$termoNovo.'>  .
                                }';
                    $store->query($query);
                    if ($errs = $store->getErrors()) {
                        echo '-----I-------';
                        print_r($errs);
                        echo '----I--------';
                    }
                    break;
                case 'fraco':
                    $query = 'INSERT INTO  <urn:absolute:/2017/5/tcc-2.0.0#>{
                               <urn:absolute:/2017/5/tcc-2.0.0#'.$id.'> <urn:absolute:/2017/5/tcc-2.0.0#RelacionamentoFraco> <urn:absolute:/2017/5/tcc-2.0.0#'.$termoNovo.'>  .
                                }';
                    $store->query($query);
                    if ($errs = $store->getErrors()) {
                        echo '-----I-------';
                        print_r($errs);
                        echo '----I--------';
                    }
                    break;
            }
        }
        return true;
    }

}
