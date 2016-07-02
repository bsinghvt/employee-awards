<?php
require_once(LIB_PATH.DS.'database.php');
class Award extends DatabaseObject {
    protected static $table_name = 'Award';
    public $r_first_name;
    public $recepient_email;
    public $granted;
    public $award_type;
    public $r_last_name;
    public $uid;
	public $adid;
    public $error;
    public $public;
    public $r_middle_name;
   
    protected static $param_type = 'ssss';
    protected static $insert_query = 'INSERT INTO Award (recepient_email, password, r_first_name, r_last_name, r_middle_name, award_type, granted, public) VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
    protected static $select_query_all = 'SELECT * from Award';
 
    function __construct(){
    }
    protected function insert_params(){
        return array(self::$param_type, $this->recepient_email, $this->password, $this->r_first_name, $this->r_last_name, $this->r_middle_name, $this->award_type, $this->granted, $this->public);
    }
    public function findAll(){
        return parent::any_select_query(self::$select_query_all);
    }
}
?>