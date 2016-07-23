<?php
require_once(LIB_PATH.DS.'database.php');
class Admin extends DatabaseObject {
    protected static $table_name = 'Admin_Account';
    public $user_email;
    public $password;
    public $admin_id;
	public $total_actions;
    public $error;
    protected static $auth_query = 'SELECT admin_id, password FROM Admin_Account WHERE user_email = ?  LIMIT 1';
    protected static $auth_param_type = 's';
	protected static $select_query_all = 'SELECT Admin_Account.admin_id, Admin_Account.user_email, CASE WHEN Admin_Actions.action_id IS NULL THEN 0 ELSE COUNT( Admin_Actions.action_id ) END AS total_actions from Admin_Account left join Admin_Actions on Admin_Actions.admin_id = Admin_Account.admin_id group by Admin_Account.admin_id';
	protected static $param_type = 'ss';
	protected static $update_param_type = 'ssi';
    protected static $insert_query = 'INSERT INTO Admin_Account (user_email, password) VALUES(?, ?)';
	protected static $select_query_id = 'SELECT * FROM Admin_Account WHERE admin_id = ? LIMIT 1 ';
	protected static $update_query = 'UPDATE Admin_Account SET user_email = ?, password = ? WHERE admin_id = ? ';
	protected static $delete_query = 'DELETE FROM Admin_Account WHERE admin_id = ? ';
    
    function __construct(){
    }
	protected function insert_params(){
        return array(self::$param_type, $this->user_email, $this->password);
    }
	protected function update_params(){
        return array(self::$update_param_type, $this->user_email, $this->password, $this->admin_id);
    }
	public function add_new(){
		return parent::update_or_delete_or_insert_query(self::$insert_query, $this->insert_params());
    }
    protected function auth_params(){
        return array(self::$auth_param_type, $this->user_email);
    }
    public function authenticate($pwd=""){
        $result_array = parent::any_select_query(self::$auth_query, $this->auth_params());
        if(!empty($result_array)){
			if (password_verify($pwd, $result_array[0]->password)){
				$this->admin_id = $result_array[0]->admin_id;
				return true;
			}
            return false;
        }
        return false;
    }
	
	public function findAll(){
       return parent::any_select_query(self::$select_query_all);
    }
	
	public function find_by_id(){
        return parent::any_select_query(self::$select_query_id, $arr=array('i', $this->admin_id));
    }
	
	public function update(){
        return parent::update_or_delete_or_insert_query(self::$update_query, $this->update_params());
    }
	public function delete_admin(){
        return parent::update_or_delete_or_insert_query(self::$delete_query, $arr=array('i', $this->admin_id));
    }
}
?>