<?php
require_once(LIB_PATH.DS."database.php");
class User extends DatabaseObject {
    protected static $table_name = "users";
    public $id,
    $username,
    $password,
	 $first_name,
	 $fid,
	 $last_name,
	 $error;
    public function getFullName() {
        return $this->first_name.' '.$this->last_name;
    }
    
    public static function authenticate($username="", $password=""){
        global $database;
        $sql = "SELECT * FROM ".self::$table_name." WHERE username = ? && password = ? LIMIT 1";
        $stmt =& $database->query($sql);
        if (!($stmt->bind_param('ss', $username, $password))) {
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
        }
        $data =& $database->fetch_results($stmt);
        $result_array =& self::makeUserObjectArray ($data);
        return (!empty($result_array)) ? array_shift($result_array) : false ;
    }
    
    public function createUser() {
        global $database;
        $sql = "INSERT INTO ".self::$table_name." (username, password, first_name, last_name) VALUES(?, ?, ?, ?)";
        $stmt =& $database->query($sql);
        if(!($stmt->bind_param("ssss", $uName, $pass, $fName, $lName))){
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            return false;
        }
        $uName = $this->username;
		  $pass = $this->password;
        $fName = $this->first_name;
        $lName = $this->last_name;
		  if(!($stmt->execute())) {
			  if($stmt->errno == 1062)
			  {
				  	$this->error =  "username already exists.";
					return false;
			  }
			  $this->error =  "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			  return false;
        }
		  $this->id = $stmt->insert_id;
		  return true;
	 }

	 public function &findUsersFriends(){
	   if(!isset($this->fid) || $this->fid == 0){
         return false;
       }
       $sql = "SELECT * FROM ".static::$table_name." WHERE uid = ".$this->fid;
       return Parent::findAll($sql);
    }
    
    public function updateUser() {
        global $database;
        $sql = "UPDATE ".self::$table_name." SET username=?, password=?, first_name=?, last_name=? WHERE id=?";
        $stmt =& $database->query($sql);
        if(!($stmt->bind_param("ssssi", $uName, $pass, $fName, $lName, $ID))){
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            exit;
        }
        $uName = $this->username;
        $pass = $this->password;
        $fName = $this->first_name;
        $lName = $this->last_name;
        $ID = $this->id;
        if(!($stmt->execute())) {
            echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            exit;
        }
    }
}
?>
