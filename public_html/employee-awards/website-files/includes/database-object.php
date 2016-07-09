<?php
require_once(LIB_PATH.DS."database.php");

//Parent class for all objects using database object
class DatabaseObject {
    function __construct() {
	 }
    //Function to general select query
    protected function any_select_query($sql='', $params=array()){
        global $database;
        if(!$database->query($sql)){
            $this->error = $database->error;
            return false;
        }
        if(!empty($params)){
            if(!$database->bind_params($params)){
                $this->error = $database->error;
                return false;
            }
        }
        if(!$database->execution()) {
            $this->error = $database->error;
            return false;
        }
        $data =& $database->fetch_results();
        return static::makeUserObjectArray($data);
    }
    
    //Function to general query
    protected function update_or_delete_or_insert_query($sql='', $params=array()){
        global $database;
        if(!$database->query($sql)){
            $this->error = $database->error;
            return false;
        }
        if(!empty($params)){
            if(!$database->bind_params($params)){
                $this->error = $database->error;
                return false;
            }
        }
        
        if(!$database->execution()) {
            $this->error = $database->error;
            return false;
        }
        if($database->affect_rows == 0){
			$this->error = $database->error;
            return false;
        }
        return true;
    }
    
    //Count the number of records;
    protected function count_query($sql="", $params=array()) {
         if(!$database->query($sql)){
            $this->error = $database->error;
            return false;
        }
        if(!empty($params)){
            $param = static::refValues(static::insert_params());
            if(!$database->bind_params($param)){
                $this->error = $database->error;
                return false;
            }
        }
        
        if(!$database->execution()) {
            $this->error = $database->error;
            return false;
        }
        $data =& $database->fetch_results();
        return $data[0]['COUNT(*)'];
    }
	 //Function to create array of objects
    protected static function &makeUserObjectArray ($data){
        global $database;
        $object_array = array();
        foreach ($data as $row) {
            $object_array[] = static::makeUserObject ($row);
        }
        return $object_array;
    }

	 //Function to create a object
    protected static function &makeUserObject ($data){
        $class_name = get_called_class();
        $object = new  $class_name;
        foreach($data as $attribute=>$value){
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
	 }

	 //FUnction to check if the object has attribute
    protected function has_attribute($attribute) {
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }
}
?>
