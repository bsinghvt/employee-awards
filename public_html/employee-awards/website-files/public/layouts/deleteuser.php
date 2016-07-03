<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once(__DIR__.'/../../initialize.php');
$session->check_adm_login();
if(!$session->is_admin_logged_in()){
    redirect_to('index.php');
} ?>
<?php
$GLOBALS['msg'] = "";
$success = 'not';
    if(isset($_GET["uid"])){
        $uid = $_GET["uid"];
    
        if(trim($uid) != ""){
            $user = new User();
			$user->uid = $uid;
            if($user->delete_user()){
                $GLOBALS['msg'] = '<p style="color:green; text-align: center;"><b>User is deleted Successfully.</b></p>';
                $success = 'yes';
            }
            else{
                $GLOBALS['msg'] = '<p style="color:red; text-align: center;"><b>Data base error. Try Again.</b></p>';
            }
        }
        else{
            $GLOBALS['msg'] = '<p style="color:red; text-align: center;"><b>Error Occured.</b></p>';
        }
    }
header('Content-Type: application/json');
$arr = array("msg"=>$GLOBALS['msg'], 'success'=>$success);
echo json_encode($arr);
?>