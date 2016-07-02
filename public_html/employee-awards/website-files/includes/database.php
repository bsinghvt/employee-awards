<?php
require_once(LIB_PATH.DS."config.php");

//Class for database object. Connection to database opens here 
//general querries to database done here
class MySQLDatabase {
    private $connection;
    
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
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
	 }

	 //Function to run a sql querry and return a statement object
    public function &query($sql) {
        if(!($stmt = $this->connection->prepare($sql))){
            echo "Database query failed: "  . $stmt->errno . " " . $stmt->error;
            exit;
        } 
        else {
            return $stmt;
        }
	 }

	 //FUnction to fetch result from statement object and return array of data from statement object
    public function &fetch_results(&$stmt) {
         if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            exit;
        }
        /* Fetch result to array */
        
        $data = array();
        $meta_data = $stmt->result_metadata();
        $param = array();
        while($field = $meta_data->fetch_field()) {
            $param[] = &$row[$field->name];
        }
        
        call_user_func_array(array($stmt, 'bind_result'), $param);
        while($stmt->fetch()){
            foreach($row as $key=>$val) {
                $col[$key] = $val;
            }
            $data[] = $col;
        }
        /* free result */
        $stmt->close();

        return $data;
    }
    
    public function fetch_array (&$result) {
        return $result->fetch_array();
    }
}

$database = new MySQLDatabase();
$database->open_connection();
?>
