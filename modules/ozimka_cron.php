<?php

$links = array(
    'login'=>'http://www.ozimka.com/cabinet/login/',
    'profile'=>'http://www.ozimka.com/cabinet/',
    'add'=>'http://www.ozimka.com/cabinet/add/',
);

$postLogin = array(
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


//if(!empty($postData)) {
if(true) {
    
    $browser = array(
       "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2",
       "Connection: keep-alive",
       "Content-Type: application/x-www-form-urlencoded",
       "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8"
   );
    //"Accept"=>'image/webp,*/*;q=0.8'
    $ch = curl_init();

    // login
    curl_setopt($ch, CURLOPT_URL,$links['login']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); // set referer on redirect
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); // timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 240); // timeout on response
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // stop after 10 redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $browser );
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/ozimka_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/ozimka_cookies.txt");

    if(is_array($postLogin)){       
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $postLogin);
    }
    
    $otvet = curl_exec($ch);

    if ($otvet === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }
  
    // rest request

    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_URL, $links['profile']);
    $otvet = curl_exec($ch);

    if ($otvet === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }

    echo $otvet; exit;
    
    // advert publication
    
    foreach($postData AS $k => $v) {

        // post image
                 
        curl_setopt($ch, CURLOPT_URL, $links[3]);                
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('name'=>$v['name']));
        
        $otvet = curl_exec($ch); /*echo $otvet;
        pre(curl_getinfo($ch)); exit;*/
        
        // post advert

        if($v !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $v);
        } 

        curl_setopt($ch, CURLOPT_URL, $links[2]);
        $otvet = curl_exec($ch);

        if ($otvet === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            continue;
        }
        
        $location = checkRedirect($otvet);
        $id = cut_str($otvet, "publish/", '/');
        
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, $links[4]."$id");
        $otvet = curl_exec($ch);
        
        if ($otvet === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            continue;
        }
        
        // проверка и занос в бд
        if($id) {                        
            $db->query("INSERT INTO advertStatus SET advert_id = $k, onSite_id = '$id', dt_stop = '"._ADVERT_STOP_DT_."' ");            
        }
        
    }
    
    curl_close($ch);
    
}

exit;

?>