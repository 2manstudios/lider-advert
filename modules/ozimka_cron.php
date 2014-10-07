<?php

$url_array = array(
    'login'=>'http://www.ozimka.com/cabinet/login/',
    'profile'=>'http://www.ozimka.com/cabinet/',
    'add'=>'http://www.ozimka.com/cabinet/add/',
);

$post_login = array(
    'logemail'=>_SITE_LOGIN_,
    'logpwd'=>_SITE_PASS_,
    'sbm'=>'Войти',
    'logFrm'=>'1'
);

$post = array(
            'regFrm'=>'1',
            'posted'=>'1',
            'id_user'=>'57112',
            'id_ads_type'=>'2',
            'id_ads_cat'=>'5',
            'id_country'=>'2',
            'id_region'=>'761',
            'id_city'=>'16462',
            'id_district'=>'32047',
            'lifetime'=>'604800',
            'active'=>'1',
            'photo'=>'@'.ROOT_DIR.'/images/test.jpg',
            'photo1'=>'@'.ROOT_DIR.'/images/test.jpg',
            'photo2'=>'@'.ROOT_DIR.'/images/test.jpg',
            'photo3'=>'@'.ROOT_DIR.'/images/test.jpg',
            'description'=>iconv("utf-8", "windows-1251", 'публикация пробная')
        );

$otvet = '';

while (stripos($otvet, "http://www.ozimka.com/") === FALSE) {
    $otvet = iconv("windows-1251", "utf-8", connect($url_array, $post_login, $post, 'ozimka'));

    if(stripos($otvet, "HTTP/1.1 200 OK") !== FALSE) {   
        $otvet = trim(strip_tags(cut_str($otvet, "Адрес объявления:", "</a>")));
    } else {
        $otvet = false;
        sleep(5);
    }
}

echo $otvet;

?>