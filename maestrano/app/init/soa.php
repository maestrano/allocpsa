<?php
//-----------------------------------------------
// Define root folder and load base
//-----------------------------------------------
if (!defined('MAESTRANO_ROOT')) {
  define("MAESTRANO_ROOT", realpath(dirname(__FILE__) . '/../../'));
}
require_once MAESTRANO_ROOT . '/app/init/base.php';

//-----------------------------------------------
// Require your app specific files here
//-----------------------------------------------
define('APP_DIR', realpath(MAESTRANO_ROOT . '/../'));

define("NO_AUTH",1); # switch to nologin
require_once APP_DIR . '/alloc.php';


//-----------------------------------------------
// Perform your custom preparation code
//-----------------------------------------------
// If you define the $opts variable then it will
// automatically be passed to the MnoSsoUser object
// for construction
// e.g:
$opts = array();
$opts['db_connection'] = new db_alloc();

MnoSoaLogger::initialize();
$current_user = &singleton("current_user",new person());
$current_user->load_current_user('1');

?>
