<?php
require_once(LIB_PATH.DS."database.php");

//Parent class for all objects using database object
class DatabaseObject {
    function __construct() {
	 }

	 //Find all rows from a table and return as array
    public function &findAll($sql="") {
        global $database;
        $stmt =& $database->query($sql);
        $data =& $database->fetch_results($stmt);
        return static::makeUserObjectArray ($data);
    }
    
    //Count the number of records;
    public function countAll($sql="") {
        global $database;
        $stmt =& $database->query($sql);
        $data =& $database->fetch_results($stmt);
        return $data[0]['COUNT(*)'];
    }

	 //Find a row by id and return as array
    public function &findById($id = 0) {
        global $database;
        $sql = "SELECT * FROM ".static::$table_name." WHERE id = ? LIMIT 1";
        $stmt =& $database->query($sql);
        if (!($stmt->bind_param('i', $id))) {
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
        }
        $data =& $database->fetch_results($stmt);
        return static::makeUserObjectArray ($data);
    }

	 //FUnction to delete a row by id
    public function deleteById($id=0) {
        global $database;
        $sql = "DELETE FROM ".static::$table_name." WHERE id = ? LIMIT 1";
        $stmt =& $database->query($sql);
        if (!($stmt->bind_param('i', $id))) {
			  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			  return false;
        }
      
        //execute query
        if(!$stmt->execute()){
			  echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			  return false;
        } 
		  $stmt->close();
		  return true;
    }

	 //Function to create array of objects
    protected static function &makeUserObjectArray ($data) {
        global $database;
        $object_array = array();
        foreach ($data as $row) {
            $object_array[] = static::makeUserObject ($row);
        }
        return $object_array;
    }

	 //Function to create a user object
    protected static function &makeUserObject ($data) {
        $class_name = get_called_class();
        $object = new  $class_name;
        foreach($data as $attribute=>$value) {
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
