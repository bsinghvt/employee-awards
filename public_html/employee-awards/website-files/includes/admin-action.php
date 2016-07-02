<?php
require_once(LIB_PATH.DS.'database.php');
class AdminActions extends DatabaseObject {
    protected static $table_name = 'Admin_Actions';
    public $action;
    public $uid;
    public $action_id;
    public $error;
	public $admin_id;
    
	protected static $param_type = 'sii';
    protected static $insert_query = 'INSERT INTO Admin_Actions (action, admin_id, uid) VALUES(?, ?, ?)';
    protected static $select_query_all = 'SELECT * from Admin_Actions';
 
    function __construct(){
    }
    protected function insert_params(){
        return array(self::$param_type, $this->action, $this->admin_id, $this->uid);
    }
    public function findAll(){
        return parent::any_select_query(self::$select_query_all);
    }
}
?>