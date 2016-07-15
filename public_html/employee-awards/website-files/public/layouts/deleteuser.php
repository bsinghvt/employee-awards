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
    if(isset($_POST["uid"]) && isset($_POST["sig"])){
        $uid = $_POST["uid"];
		$sig = $_POST["sig"];
        if(trim($uid) != "" && trim($sig) != ""){
            $user = new User();
			$user->uid = $uid;
			$target_path= SIG_IMAGES.DS.$sig;
            if($user->delete_user()){
                $GLOBALS['msg'] = '<p style="color:green; text-align: center;"><b>User is deleted Successfully.</b></p>';
                $success = 'yes';
				$admin_action = new AdminActions();
				$admin_action->admin_id = $session->admin_id;
				$admin_action->action = 'Admin '.$session->admin_username.' deleted '.$_POST["name"];
				$admin_action->add_new();
				if(file_exists($target_path)){
					unlink($target_path);
				}
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