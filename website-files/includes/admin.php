<?php
require_once(LIB_PATH.DS."database.php");
class Admin extends DatabaseObject {
    protected static $table_name = "admin";
    public $id,
    $username,
    $password,
    $first_name,
    $last_name;
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
}
?>
