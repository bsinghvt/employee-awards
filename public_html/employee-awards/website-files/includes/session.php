<?php
class Session {
    private $logged_in;
    private $admin_logged_in;
    public $user_id;
    public $admin_id;
    function __construct() {
         session_start();
    }
    public function check_user_login(){
        $this->check_login();
    }
    public function check_adm_login(){
       
        $this->check_admin_login();
    }
    public function is_admin_logged_in() {
        return $this->admin_logged_in;
    }
    public function is_logged_in() {
        return $this->logged_in;
    }
    public function login($user) {
        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }
     public function login_admin($admin) {
        if($admin) {
            $this->admin_id = $_SESSION['admin_id'] = $admin->id;
            $this->admin_logged_in = true;
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }
    public function admin_logout() {
        unset($_SESSION['admin_id']);
        unset($this->admin_id);
        $this->admin_logged_in = false;
    }
    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
    
    private function check_admin_login() {
        if(isset($_SESSION['admin_id'])) {
            $this->admin_id = $_SESSION['admin_id'];
            $this->admin_logged_in = true;
        } else {
            unset($this->admin_id);
            $this->admin_logged_in = false;
        }
    }
}
$session = new Session();
?>