<?php

    namespace Core;

    use mysqli;
      
    class Database extends mysqli 
    {

        private $connections;
        public $last;
        public $insertId;
        private static $instance = null; 

        public function __construct() 
        {  
            $this->connections = new mysqli(SERVER, USERNAME, PASSWORD, DB);
            
            if (mysqli_connect_errno()) {
                trigger_error('Error connecting to host. ' . $this->connections->error, E_USER_ERROR);
            } 
        } 

        public static function getInstance()
        {
            if(!self::$instance) {
                self::$instance = new Database();
            }
            
            return self::$instance;
        }
    	 
        public function runQuery($queryStr) 
        {
            if (!$result = $this->connections->query($queryStr)) {
                trigger_error('Error executing query: ' . $queryStr . ' -' . $this->connections->error, E_USER_ERROR);
            } else {
                $this->last = $result;
                $this->insertId = $this->connections->insert_id;
                return true;
            }
        }

        public function runQueries($queryStr) 
        {
            $this->last = array();

            if (!$this->connections->multi_query($queryStr)) {
                trigger_error('Error executing query: ' . $queryStr . ' -' . $this->connections->error, E_USER_ERROR);
            } else {
                do {
                    if ($result = $this->connections->store_result()) {
                        $this->last[] = $result;
                        $result->free();
                    }
                } while ($this->connections->more_results() && $this->connections->next_result());
                
                return true;
            }
        }

        public function getData() 
        {
            return $this->last->fetch_array(MYSQLI_ASSOC);
        }

        public function deleteData($table, $condition, $limit) 
        {
            $limit = ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
            $delete = "DELETE FROM {$table} WHERE " . $this->cleanData($condition) . " {$limit}";
            $this->runQuery($delete);
        }

        public function numRows() 
        {
            return $this->last->num_rows;
        }
     
        public function updateData($table, $changes, $condition) 
        {
            $fields = array();
            $values = array();

            foreach ($changes as $f => $v) {
                $fields[] = $f;
                $values[] = (is_numeric($v) && (intval($v) == $v)) ? (int) $v : $this->cleanData($v);
            } 

            $changes = array_map(function($f, $v) {
                return "`{$f}`='{$v}'";
            }, $fields, $values);

            $update = "UPDATE " . $table . " SET " . implode(", ", $changes);

            if ($condition != '') {
                $update .= " WHERE " . $this->cleanData($condition);
            }

            $this->runQuery($update);

            return true;
        }

        public function insertData($table, $data) 
        {
            $fields = array();
            $values = array();
            
            foreach ($data as $f => $v) {
                $fields[] = $f;
                $values[] = (is_numeric($v) && (intval($v) == $v)) ? (int) $v : $this->cleanData($v);
            } 
            
            $insert = "INSERT INTO $table (`" . implode("`, `", $fields) . "`) VALUES('" . implode("', '", $values) . "')";
            
            return $this->runQuery($insert);
        }

        public function cleanData($value) 
        {
            if (version_compare(phpversion(), "4.3.0") == "-1") {
                $value = $this->connections->escape_string($value);
            } else {
                $value = $this->connections->real_escape_string($value);
            }

            return $value;
        }
    	 
        public function __destruct() 
        {
            $this->connections->close();
        }
    }

?>