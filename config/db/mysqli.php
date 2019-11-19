<?php

if (!class_exists('dbConn')):
	
    class dbConn {
    
		private $select, $update, $delete, $result;
		public $charset = 'ANSI';
         public function mysqli(){
            return $this->db_connect;
        }      
        // CONNECT
        public function conn() {
			$this->db_connect = new mysqli($this->DBHOST, $this->DBUSER, $this->DBPASS, $this->DBNAME,$this->DBPORT);
			if ($this->db_connect->connect_error) {
				die("Failed connect to MySQL!". mysqli_error());
				return;
			}
			return $this->db_connect;
		}

        // SELECT
		public function select($select, $from, $where = '') {
			$this->result = null;
			$this->charset();
			if ($this->select = $this->db_connect->query("SELECT {$select} FROM {$from} {$where}")) {
				$this->result = $this->select->fetch_assoc();
				$this->num_rows = $this->select->num_rows;
				$this->select->close();
				unset($select, $from, $where);
			}
			return $this->result;
		}
		public function selectDebug($select, $from, $where = '') {

                        return "SELECT {$select} FROM {$from} {$where}";
		}        
        // SELECT GROUP
		public function selectGroup($select, $from, $where = '') {
			$this->result = null;
			$this->charset();
			$this->result = $this->db_connect->query("SELECT {$select} FROM {$from} {$where}");
			unset($select, $from, $where);
			return $this->result;
		}
        
        // INSERT
		public function insert($into, $array) {
                   
			$return = 0;
			$data   = array();
			foreach ($array as $key => $value) {
                            $data[] = str_replace('==', '=', $this->escape($key) . "='" . $this->escape($value) . "'");
                            
			}
			$data = implode(', ', $data);
                        //echo "echo ".$into." mysqli --- ".$data;
			$this->charset();
			if ($resultado = $this->db_connect->query("INSERT INTO {$into} SET {$data}")) {
				$return =  (string) $this->db_connect->insert_id;
				unset($into, $array, $data);
				//$return = $this->insert_id();
			}
                        //echo $resultado." <<< resultado";
			return $return;
		}
                
         // INSERT PESSOA
		
         //DEBUG
            public function InsertDebug($into, $array) {
			$return = 0;
			$data   = array();
			foreach ($array as $key => $value) {
				$data[] = str_replace('==', '=', $this->escape($key) . "='" . $this->escape($value) . "'");
			}
			$data = implode(', ', $data);
                        
                        $return = "INSERT INTO {$into} SET {$data}";
			return $return;
		}       
        // UPDATE
		public function update($table, $array, $where = '') {
			$return = 0;
			$data   = array();
			foreach ($array as $key => $value) {
				$data[] = str_replace('==', '=', $this->escape($key) . "='" . $this->escape($value) . "'");
			}
			$data = implode(', ', $data);
			$this->charset();
                        if ($this->update = $this->db_connect->query("UPDATE {$table} SET {$data} {$where}")) {
                            unset($table, $array, $where, $data);
                            $return = 1;
                        }
                        return $return;
		}
        // DEBUG
        		public function updateDebug($table, $array, $where = '') {
			$return = 0;
			$data   = array();
			foreach ($array as $key => $value) {
				$data[] = str_replace('==', '=', $this->escape($key) . "='" . $this->escape($value) . "'");
			}
			$data = implode(', ', $data);
			$this->charset();
                        return (("UPDATE {$table} SET {$data} {$where}"));

		}
        // DELETE
		public function delete($from, $where = '') {
			$return = 0;
			if ($this->delete = $this->db_connect->query("DELETE FROM {$from} {$where}")) {
				unset($from, $where);
				$return = 1;
			}
			return $return;
		}
        
        // FREE QUERY EXECUTE
		public function query($query) {
			try {
				return $this->db_connect->query($query);
			} catch (mysqli_sql_exception $e) {
				return $e->errorMessage();
			}                    
		}
        
        // LIST TABLES
        public function listTables() {
            return array_column(mysqli_fetch_all($this->db_connect->query('SHOW TABLES')), 0);
        }
        
        // LIST FIELDS
        public function listFields($from) {
            $a = array();
            if ($b = $this->db_connect->query("select * from {$from}")) {
                $field = mysqli_fetch_fields($b);
                $c = 0;
                while ($property = mysqli_fetch_field($b)) {
                    $a[$c]['name'] = $property->name;
                    $type_name = "?";
                    if ($property->type == 3) { $type_name = "INTEGER"; };
                    if ($property->type == 246) { $type_name = "NUMERIC"; };
                    if ($property->type == 10) { $type_name = "DATE"; };
                    if ($property->type == 12) { $type_name = "DATETIME"; };
                    if ($property->type == 7) { $type_name = "TIMESTAMP"; };
                    if ($property->type == 11) { $type_name = "TIME"; };
                    if ($property->type == 13) { $type_name = "YEAR"; };
                    if ($property->type == 254) { $type_name = "CHAR"; };
                    if ($property->type == 253) { $type_name = "VARCHAR"; };
                    if ($property->type == 252) { $type_name = "TEXT"; };
                    $a[$c]['type'] = $type_name;
                    $a[$c]['code'] = $property->type;
                    $a[$c]['size'] = $property->max_length;
                    $c ++;    
                }                
                mysqli_free_result($b);
            }
            return $a;
        }
        
        // CLOSE CONNECTION
        public function close() {
			$this->reset();
			unset($this->db_connect, $this->select, $this->num_rows, $this->insert, $this->update, $this->delete, $this->insert_id, $this->charset, $this->insert_ids, $this->result);
			$this->conn()->close();
		}
              
        // CLASS CONSTRUCTOR
		function __construct() {
            $a = func_get_args();
            $i = func_num_args();
            if ($i == 4) {
                // FROM RECEIVED ARGUMENTS
                $this->DBHOST = $a[0]; $this->DBUSER = $a[1]; $this->DBPASS = $a[2]; $this->DBNAME = $a[3];
            } else {
                // FROM PRE-DEFINED CONSTANTS
                $this->DBHOST = DBHOST; $this->DBUSER = DBUSER; $this->DBPASS = DBPASS; $this->DBNAME = DBNAME; $this->DBPORT = DBPORT;            
            }
            $this->reset();
            unset($this->num_rows);
            return;
		}
        
        // AUXILIARY FUNCTIONS
        public function escape($data) { return $this->db_connect->real_escape_string($data); }
		public function insert_id() { return $this->insert_id; }         
		protected function reset() { unset($this->conn()->affected_rows, $this->conn()->connect_errno, $this->conn()->connect_error, $this->conn()->error_list, $this->conn()->field_count, $this->conn()->insert_id, $this->conn()->warning_count); } 
        protected function charset() { $this->db_connect->query("SET NAMES '" . $this->charset . "'"); $this->db_connect->query("SET CHARACTER SET " . $this->charset); }         
        
	}
    
endif;