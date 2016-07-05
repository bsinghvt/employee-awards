<?php
require_once(LIB_PATH.DS.'database.php');
class User extends DatabaseObject {
    protected static $table_name = 'User_Account';
    public $first_name;
    public $user_email;
    public $password;
    public $creation;
    public $job_title;
    public $last_name;
    public $uid;
    public $error;
    public $signature;
    public $middle_name;
	public $total_awards;
   
    protected static $param_type = 'sssssss';
	protected static $update_param_type = 'sssssssi';
    protected static $insert_query = 'INSERT INTO User_Account (user_email, password, first_name, last_name, middle_name, job_title, signature) VALUES(?, ?, ?, ?, ?, ?, ?)';
    protected static $auth_query = 'SELECT uid FROM User_Account WHERE user_email = ? AND password = ? LIMIT 1';
    protected static $auth_param_type = 'ss';
    protected static $select_query_all = 'SELECT User_Account.uid, User_Account.first_name, User_Account.user_email, User_Account.last_name, User_Account.middle_name, User_Account.creation, User_Account.job_title, CASE WHEN Award.adid IS NULL THEN 0 ELSE COUNT( Award.adid ) END AS total_awards FROM User_Account LEFT JOIN Award ON User_Account.uid = Award.uid GROUP BY User_Account.uid';
	protected static $select_query_id = 'SELECT User_Account.uid, User_Account.password, User_Account.first_name, User_Account.user_email, User_Account.last_name, User_Account.middle_name, User_Account.creation, User_Account.job_title, User_Account.signature FROM User_Account WHERE User_Account.uid = ? LIMIT 1 ';
	protected static $delete_user_query = 'DELETE FROM User_Account WHERE uid = ?';
	protected static $get_sign_query = 'SELECT signature FROM User_Account WHERE uid = ? ';
	protected static $update_query = 'UPDATE User_Account SET user_email = ?, password = ?, first_name = ?, last_name=?, middle_name=?, job_title=?, signature=? WHERE uid = ? ';
    function __construct(){
    }
    protected function insert_params(){
        return array(self::$param_type, $this->user_email, $this->password, $this->first_name, $this->last_name, $this->middle_name, $this->job_title, $this->signature);
    }
	protected function update_params(){
        return array(self::$update_param_type, $this->user_email, $this->password, $this->first_name, $this->last_name, $this->middle_name, $this->job_title, $this->signature, $this->uid);
    }
	
    public function add_new(){
        return parent::update_or_delete_or_insert_query(self::$insert_query, $this->insert_params());
    }
	public function update(){
        return parent::update_or_delete_or_insert_query(self::$update_query, $this->update_params());
    }
	public function get_sign(){
        return parent::any_select_query(self::$get_sign_query, $arr=array('i', $this->uid));
    }
	public function find_by_id(){
        return parent::any_select_query(self::$select_query_id, $arr=array('i', $this->uid));
    }
    protected function auth_params(){
        return array(self::$auth_param_type, $this->user_email, $this->password);
    }
    
    public function authenticate(){
        $result_array = parent::any_select_query(self::$auth_query, $this->auth_params());
        if(!empty($result_array)){
            $this->uid = $result_array[0]->uid;
            return true;
        }
        return false;
    }
    public function findAll(){
        return parent::any_select_query(self::$select_query_all);
    }
	
	public function delete_user(){
        return parent::update_or_delete_or_insert_query(self::$delete_user_query, $arr=array('i', $this->uid));
    }
}
?>