<?php
require_once(LIB_PATH.DS.'database.php');
class Admin extends DatabaseObject {
    protected static $table_name = 'Admin_Account';
    public $user_email;
    public $password;
    public $admin_id;
    public $error;
    protected static $auth_query = 'SELECT admin_id FROM Admin_Account WHERE user_email = ? AND password = ? LIMIT 1';
    protected static $auth_param_type = 'ss';
	 protected static $select_query_all = 'SELECT * from Admin_Account';
    
    function __construct(){
    }
  
    protected function auth_params(){
        return array(self::$auth_param_type, $this->user_email, $this->password);
    }
    
    public function authenticate(){
        $result_array = parent::any_select_query(self::$auth_query, $this->auth_params());
        if(!empty($result_array)){
            $this->admin_id = $result_array[0]->admin_id;
            return true;
        }
        return false;
    }
	
	public function findAll(){
       return parent::any_select_query(self::$select_query_all);
    }
}
?>