<?php
require_once(LIB_PATH.DS."database.php");

//Comment class extends DatabaseObject
class Comment extends DatabaseObject {
	protected static $table_name = "comments";
   public $id,
    		 $uid,
			 $pid,
			 $createdon,
			 $body;
 
	//Function to upload comment details into database
   public function addComment() {
        $this->createdon = strftime("%Y-%m-%d %H:%M:%S", time());
        global $database;
        $sql = "INSERT INTO ".self::$table_name." (uid, pid, createdon, body) VALUES(?, ?, ?, ?)";
        $stmt =& $database->query($sql);
        if(!($stmt->bind_param("iiss", $uid, $pid, $createdon, $body))){
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            return false;
        }
        $uid = $this->uid;
        $pid = $this->pid;
        $createdon = $this->createdon;
        $body = $this->body;
        if(!($stmt->execute())) {
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            return false;
        }
        $this->id = $stmt->insert_id;
        return true;
   }

	 //Function to update a comment
    public function updateComment() {
        global $database;
        $sql = "UPDATE ".self::$table_name." SET body=?, createdon=? WHERE id=?";
        $stmt =& $database->query($sql);
        if(!($stmt->bind_param("ssi", $body, $createdon, $ID))){
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            exit;
        }
        $body = $this->body;
        $createdon = strftime("%Y-%m-%d %H:%M:%S", time());
        $ID = $this->id;
        if(!($stmt->execute())) {
            echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            exit;
        }
	 }

	 public function &findCommentsOnPhoto(){
		 if(!isset($this->pid) || $this->pid == 0){
		 	return false;
		 }
		 $sql = "SELECT * FROM ".static::$table_name." WHERE pid = ".$this->pid;
		 return Parent::findAll($sql);
	 }
  
	 public function &findAllAdmin(){
         $sql = "SELECT * FROM ".static::$table_name;
         return Parent::findAll($sql);
   }
}
?>
