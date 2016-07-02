<?php
require_once(LIB_PATH.DS."config.php");

//Class for database object. Connection to database opens here 
//general querries to database done here
class MySQLDatabase {
    private $connection;
    public $stmt;
    public $error;
    public $affect_rows;
    
    function __construct() {
        $this->open_connection();
	 }

	 //Function to open connection
    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if(mysqli_connect_errno()) {
            die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
        }
	 }

	 //Function to close connection
    public function close_connection() {
        if(isset($this->stmt)) {
            $this->stmt->close();
            unset($this->stmt);
        }
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
	 }

	 //Function to run a sql querry and return a statement object
    public function query($sql="") {
        if(!($this->stmt = $this->connection->prepare($sql))){
            $this->error =  "Database query failed: "  . $this->connection->errno . " " . $this->connection->error;
            return false;
        } 
        return true;
    }
    
    public function execution(){
       if(!($this->stmt->execute())){
           if($this->stmt->errno == 1062){
               $this->error =  "Error: Duplicate Name or User Name.";
               return false;
           }
           $this->error =  "Execute failed: "  . $this->stmt->errno . " " . $this->stmt->error;
           return false;
        }
        $this->affect_rows = $this->stmt->affected_rows;
        return true;
    }
    
    //Function to Bind Parameters 
    public function bind_params($param_arr = array()){
        $params = array();
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $params = array();
            foreach($param_arr as $key => $value)
                $params[] = &$param_arr[$key];
        }
        
        else{
            $params = $param_arr;
        }
        call_user_func_array(array($this->stmt, 'bind_param'), $params);
        if(!$this->stmt){
            $this->error = "Binding failed: "  . $this->stmt->errno . " " . $this->stmt->error;
            return false;
        }
        return true;
    }

	 //Function to fetch result from statement object and return array of data from statement object
    public function &fetch_results() {
        /* Fetch result to array */
        $data = array();
        $meta_data = $this->stmt->result_metadata();
        $param = array();
        while($field = $meta_data->fetch_field()) {
            $param[] = &$row[$field->name];
        }
        
        call_user_func_array(array($this->stmt, 'bind_result'), $param);
        while($this->stmt->fetch()){
            foreach($row as $key=>$val) {
                $col[$key] = $val;
            }
            $data[] = $col;
        }
        return $data;
    }
    
    /*public function fetch_array (&$result) {
        return $result->fetch_array();
    }*/
}

$database = new MySQLDatabase();
?>