<?php

$id = 7;
$postData = getAdverts($id);

if(!$postData) { echo 'empty!'; exit; }

foreach($postData AS $k => $post) {
    
    if(is_array($post) && !empty($post)) {
        $post['agreement'] = '1';
        $post['name'] = '@'.ROOT_DIR.'/images/test.jpg';
        $post['characteristic[443]'] = '442';
        
        $postData[$k] = $post;
    }
    
}

//pre($postData); exit;

$links = array(
    'login'=>'http://dom.ria.com/?target=login',
    'profile'=>'http://dom.ria.com/ru/mypage/',
    '2'=>'http://dom.ria.com/realty_add.html',
    '3'=>'http://dom.ria.com/uploader',
    '4'=>'http://dom.ria.com/ru/default/realty/addsuccess/?id='
);

$postLogin = array(
    'email'=>_SITE_LOGIN_,
    'password'=>_SITE_PASS_,
    'remember_me'=>'0',
    'remember_me'=>'1',
    'SignIn'=>'Вход',
    'action'=>'enter',
    'from_url'=>''
);

if(!empty($postData)) {
    
    $browser = array(
       "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2",
       "Connection: keep-alive",
       "Content-Type: application/x-www-form-urlencoded",
       "Host: dom.ria.com",
       "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
       "Origin: http://dom.ria.com"
   );

    $ch = curl_init();

    // login
    curl_setopt($ch, CURLOPT_URL,$links['login']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); // set referer on redirect
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 120); // timeout on response
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // stop after 10 redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $browser );
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/domria_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/domria_cookies.txt");

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
    
    // advert publication
    
    foreach($postData AS $k => $v) {

        if(stripos($otvet, _SITE_LOGIN_) === FALSE) {
            echo "not login<br>"; continue;
        }
        
        // post image
         /*        
        curl_setopt($ch, CURLOPT_URL, $links[3]);                
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('name'=>$v['name']));
        
        $otvet = curl_exec($ch); echo $otvet;
        pre(curl_getinfo($ch)); exit;
        */
        
        // post advert

        if(!empty($v)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $v);
        } 

        curl_setopt($ch, CURLOPT_URL, $links[2]);
        $otvet = curl_exec($ch);

        if ($otvet === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            continue;
        }
              
        if(stripos($otvet, "Добавление объявления: публикация") === FALSE) {
            echo "not publication<br>"; continue;
        }
        
        echo $otvet; exit;
        $id = cut_str($otvet, "publish/", '/');
        
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, "http://dom.ria.com/ru/default/realty/addsuccess/?id=$id&from_publish=1&republish=1&publish_period=1");
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