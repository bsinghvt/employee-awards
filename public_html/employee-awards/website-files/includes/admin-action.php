<?php
require_once(LIB_PATH.DS.'database.php');
class AdminActions extends DatabaseObject {
    protected static $table_name = 'Admin_Actions';
    public $action;
    public $action_id;
    public $error;
	public $admin_id;
	public $action_timestamp;
    
	protected static $param_type = 'si';
    protected static $insert_query = 'INSERT INTO Admin_Actions (action, admin_id) VALUES(?, ?)';
    protected static $select_query_all = 'SELECT * from Admin_Actions';
	protected static $select_query_admin = 'SELECT * from Admin_Actions WHERE admin_id = ?';
 
    function __construct(){
    }
    protected function insert_params(){
        return array(self::$param_type, $this->action, $this->admin_id);
    }
	public function add_new(){
        return parent::update_or_delete_or_insert_query(self::$insert_query, $this->insert_params());
    }
    public function findAll(){
        return parent::any_select_query(self::$select_query_all);
    }
	
	public function find_by_admin_id(){
		return parent::any_select_query(self::$select_query_admin, Array('i', $this->admin_id));
    }
}
?>