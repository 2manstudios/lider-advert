<?php

@session_start();
date_default_timezone_set("Europe/Kiev");
define("_ENVIRONMENT_", "dev", true);
define ("ROOT_DIR", dirname ( __FILE__ ) );
    
// Настройки сервера
switch (_ENVIRONMENT_) {
    case "dev":
        set_time_limit (30);
        @error_reporting ( E_ALL ^ E_NOTICE );
        @ini_set ( 'display_errors', true );
        @ini_set ( 'html_errors', false );
        @ini_set ( 'error_reporting', E_ALL ^ E_NOTICE );
        break;
    case "prod":
        set_time_limit (60);
        @error_reporting(null);
        @ini_set ( 'display_errors', false );
        @ini_set ( 'html_errors', false );
        @ini_set ( 'error_reporting', null );
        break;
    default:
        break;
}

$cur_domain2 = explode(".",$_SERVER['SERVER_NAME']);
$cur_domain = $cur_domain2[count($cur_domain2)-1];
if(strripos($_SERVER['HTTP_HOST'], 'www.') !== FALSE) { 
    header("location: http://{$cur_domain2[count($cur_domain2)-2]}.{$cur_domain2[count($cur_domain2)-1]}"); exit;
}

//подключаем библиотеки
include (ROOT_DIR."/include/functions.php");
include (ROOT_DIR."/include/kykylkan_helper.php");
include (ROOT_DIR."/include/mysql.class.php");
include (ROOT_DIR."/include/dbconfig.php");
include (ROOT_DIR."/include/rules.php");
include (ROOT_DIR."/include/config.php");
include (ROOT_DIR."/include/php_mailer/class.phpmailer.php");
   
/*
$data = cURL_getpage("http://maplos.com/streets/kiev");
$data = preg_match_all("|href=\"/kiev/адрес.+?</a>|", $data, $matches);
$data = array();

foreach($matches[0] AS $k => $v) {
    $data[] = strip_tags("<a $v");
}

$data = array_unique($data);

foreach($data AS $k => $v) {
    $db->query("INSERT INTO street SET `name` = '$v', region_id = 16");
}

exit;
*/

/*
if(_DO_) {
    include (ROOT_DIR."/include/php_mailer/class.phpmailer.php");
}

if(_DO_) { 
    include (ROOT_DIR."/include/pagination/Manager.php");
    include (ROOT_DIR."/include/pagination/Helper.php");    
}
*/

if(!in_array(_DO_, $notToRedirect)) {
    $_SESSION['url'] = "http://".clearData($_SERVER['SERVER_NAME']).clearData($_SERVER['REQUEST_URI']);
} else{
    if(!$_SESSION['url']) {
        $_SESSION['url'] = "http://".clearData($_SERVER['SERVER_NAME']);
    }
}

// login
if(!get_data('ul') || !$_SESSION['uid']) {
    
    define("_LOGIN_", 0, true);
    
} elseif(get_data('ul') && $_SESSION['uid']) {       
    
    $data = $db->getValue("SELECT dt_add FROM user WHERE id = ".base64_decode($_SESSION['uid']));
    
    if(get_data('ul') == hash('md5', base64_decode($_SESSION['uid'])."|".$data)) {
        define("_LOGIN_", 1, true);        
    } else {
        define("_LOGIN_", 0, true);
    }
} else {
    define("_LOGIN_", 0, true);
}

if(!_LOGIN_ && in_array(_DO_, $moduleAccess)) { header("location: /login "); exit; }

// modules

$ifile = ROOT_DIR."/modules/"._DO_.".php";    

if(@file_exists($ifile)) {
    $params = array();
    include $ifile;      

    if(!_WHAT_) {
        $page = view_include(_TPL_DIR_."/"._DO_.".tpl.php", $params);     
    } elseif(_DO_ == 'x-files' && _WHAT_) {
        $page = view_include(_TPL_DIR_."/"._WHAT_.".tpl.php", $params);    
    }
    
    echo view_include(_MAIN_TPL_DIR_."/main.tpl.php", array('content'=>$page, 'msg'=>$params['msg'], 'error'=>$params['error'])); 

} else {
    
}    

?>