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
	public $min_date;
	public $max_date;
	public $user_email;
	public $first_name;
	public $last_name;
	public $middle_name;
	public $job_title;
   
    protected static $param_type = 'ssssssii';
    protected static $insert_query = 'INSERT INTO Award (recepient_email, r_first_name, r_last_name, r_middle_name, award_type, granted, public, uid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
    protected static $select_query_all = 'SELECT Award.award_type, Award.recepient_email, Award.r_first_name, Award.r_middle_name, Award.r_last_name, Award.granted, User_Account.user_email, User_Account.first_name, User_Account.last_name, User_Account.middle_name, User_Account.job_title from Award left join User_Account on User_Account.uid = Award.uid Where Award.granted >= ? and Award.granted <= ?';
 
    function __construct(){
    }
    protected function insert_params(){
        return array(self::$param_type, $this->recepient_email, $this->r_first_name, $this->r_last_name, $this->r_middle_name, $this->award_type, $this->granted, $this->public, $this->uid);
    }
    public function findAll(){
        return parent::any_select_query(self::$select_query_all, $arr=array('ss', $this->min_date, $this->max_date));
    }
	
	public function r_full_name(){
		if(!isset($this->r_middle_name)){
			$this->r_middle_name = "";
		}
		if(!isset($this->r_first_name)){
			$this->r_first_name = "";
		}
		if(!isset($this->r_last_name)){
			$this->r_last_name = "";
		}
		return $this->r_first_name.' '.$this->r_middle_name.' '.$this->r_last_name;
	}
	
	public function g_full_name(){
		if(!isset($this->middle_name)){
			$this->middle_name = "";
		}
		if(!isset($this->first_name)){
			$this->first_name = "";
		}
		if(!isset($this->last_name)){
			$this->last_name = "";
		}
		return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
	}
}
?>