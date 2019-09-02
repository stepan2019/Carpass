<?php

ini_set('display_errors', '1');
require_once "include/include.php";
require_once "setting/config.php";
global $lng;
if (isset($_GET['account']))
    $account = escape($_GET['account']);

else
    // support for older link structure
    if (isset($_GET['user'])) $account = escape($_GET['user']);

    else exit(0);

if (isset($_GET['activation'])) $activation = escape($_GET['activation']);
else if ($type != "sms") exit(0);

$account = rawurldecode($account);
$post = get_numeric("post", 0);

if (!$post) {

    $smarty = new Smarty;
    $smarty = common($smarty);
    $smarty->assign("lng", $lng);
    $smarty->assign("section", "other");
    $info = 'Failed Activation';
} else {
    my_session_start();
    $comResult = $config->compareActivationCode($_GET['user'], $_GET['activation']);
    if($comResult->num_rows){
        $config->setActivation($_GET['user'], $_GET['activation']);
    }
    $info = 'Successfully Activation';
}


if ($error) $smarty->assign("error", $error[0]['error']);
$smarty->assign("info", $info);
$smarty->assign("type", 'email');
$smarty->assign("account", $account);

if (!$post) {

    if ($db->error != '') {
        $db_error = $db->getError();
        $smarty->assign('db_error', $db_error);
    }
    $smarty->display('activate_account.html');
    close();

}
$db->close();

