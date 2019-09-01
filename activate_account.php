<?php

require_once "include/include.php";
require_once "classes/mail_templates.php";
require_once "classes/mails.php";
require_once "classes/info.php";
require_once "classes/users.php";

if(isset($_GET['account']))
	$account = escape($_GET['account']); 

else 
	// support for older link structure
	if(isset($_GET['user'])) $account = escape($_GET['user']); 

else exit(0);

if(isset($_GET['type'])) $type = escape($_GET['type']); else $type="email";

if(isset($_GET['activation'])) $activation = escape($_GET['activation']); 
else if($type!="sms") exit(0);

$account = rawurldecode($account);
$post = get_numeric("post", 0);


if(!$post) {

	$smarty = new Smarty;
	$smarty = common($smarty);
	$smarty->assign("lng",$lng);
	$smarty->assign("section","other");
}
else {
	my_session_start();
}

global $db;
global $lng;
$error=''; $info='';
$users=new users();

if($type=="sms") {
	
	if($post) {

		$ret = array("response" => 0, "info" =>"", "error" => "");

		$activation = escape($_POST['activation']);
		$activated = $users->activate_link($account, $activation);
		$ret['response'] = $activated;
		if($activated==1) $ret['info'] = $lng['users']['info']['account_activated'];
		elseif ($activated==-1)  $ret['info'] = $lng['users']['info']['awaiting_admin_verification'];
		else $ret['error'] = $users->getError();

		global $config_abs_path;
		require_once $config_abs_path."/libs/JSON.php";

		global $appearance_settings;
		if(strtolower($appearance_settings['charset'])!="utf-8") $ret = utf8_encode_all($ret);

		echo json_encode($ret);
		session_write_close();
		exit();

	} else $info=$lng['users']['info']['sms_verification'];
}
else { // email type

	$activated = $users->activate_link($account, $activation);
	if($activated==1) $info = $lng['users']['info']['account_activated'];
	elseif ($activated==-1)  $info = $lng['users']['info']['awaiting_admin_verification'];
	else $error = $users->getError();

}

if($error) $smarty->assign("error", $error[0]['error']);
$smarty->assign("info", $info);
$smarty->assign("type", $type);
$smarty->assign("account", $account);

if(!$post) {

	if($db->error!='') { $db_error = $db->getError(); $smarty->assign('db_error',$db_error); }
	$smarty->display('activate_account.html');
	close();
	
}
$db->close();
?>