<?php

define('_MAIN_EMAIL_', "kykyllkan@gmail.com", true);
define('_MAIN_PIB_', "advert", true);
define('_MAIN_FROM_', "авто публикация", true);

define('_SITE_LOGIN_', 'stalker0000@gmail.com', true);
define('_SITE_PASS_', 'ps3ps3ps3', true);

define('_UNIX_DT_NOW_', time(), true);
define('_DT_NOW_', date("Y-m-d H:i:s", _UNIX_DT_NOW_), true);
define('_ADVERT_STOP_DT_', date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d')+7, date("Y"))), true);
define('_TIME_NOW_', date("H:i:s", _UNIX_DT_NOW_), true);
define('_DATE_NOW_', date("Y-m-d", _UNIX_DT_NOW_), true);

define('_TYPE_', clearData($_GET['type'], 'sf'), true);
define('_WHAT_', clearData($_GET['what'], 'sf'), true);
define('_OPER_', clearData($_GET['o'], 'sf'), true);

if($_GET['do']) {
    define('_DO_', clearData($_GET['do'], 'sf'), true);
} else {
    define('_DO_', 'mainpage', true);      
}

define('_MAIN_TPL_', 'main.tpl.php', true);
define('_ECHO_TPL_', _TPL_DIR_."/"._DO_.".tpl.php", true);

define('_MAIN_EMAIL_', '', true);

// Кратное отображение валют
define('_UAH_', 'грн.', true);
define('_USD_', '$', true);

// СПОСОБ ХРАНЕНИЯ ДАННЫХ: 1 - сесия; 2 - куки;
define('_DATA_SAVE_', 2, true);

// Количество выводимых материалов на страницы для админки
define('_MAX_ADMIN_ON_PAGE_', 10, true);

define('_ON_PAGE_', 10, true);

define('_SITE_URL_','.',true); 
define('_SITE_URL_FULL_','http://ads.pricesale.com.ua',true); 

define('_MAIN_TPL_DIR_',ROOT_DIR.'/views',true); 
define('_MAIN_TPL_URL_','/views',true); 

define('_CSS_URL_',_SITE_URL_FULL_._MAIN_TPL_URL_.'/css',true); 
define('_JS_URL_',_SITE_URL_FULL_._MAIN_TPL_URL_.'/js',true); 

define('_TPL_DIR_',ROOT_DIR.'/views/tpl',true); 
define('_TPL_URL_','/views/tpl',true); 

define('_NO_IMAGE_DIR_',ROOT_DIR.'/images/no_img.gif',true); 
define('_NO_IMAGE_URL_','/images/no_img.gif',true); 

define('_IMAGES_URL_',_SITE_URL_FULL_.'/images',true); 
define('_IMAGES_DIR_',ROOT_DIR.'/images',true); 
define('_ADVERT_IMAGES_DIR_',ROOT_DIR.'/images/tmp',true); 

define('_SITE_SLOGAN_','автоматическая подача объявлений',true); 
define('_SITE_TITLE_','объявления.укр',true); 
define('_SITE_MDESC_','объявления',true); 
define('_SITE_MKEYS_','объявления',true);     

?>