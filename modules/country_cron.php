<?php

$id = 12;
$postData = getAdverts($id);

if(!$postData) { echo 'empty!'; exit; }

/*
foreach($postData AS $k => $post) {

    if(is_array($post) && !empty($post)) {
        $postData[$k] = $post;
    }
    
}
*/

$links = array(
    '0'=>'http://country.ua/user/login.php',
    '1'=>'http://country.ua/user/realt.php',
);

$post_login = array(
    'login_email'=>_SITE_LOGIN_,
    'login_pass'=>_SITE_PASS_
);

//if(!empty($postData)) {
if(!empty($postData)) {
    
    $browser = array(
       "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2"
   );
    //"Accept"=>'image/webp,*/*;q=0.8'
    $ch = curl_init();

    // login
    curl_setopt($ch, CURLOPT_URL,$links[0]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); // set referer on redirect
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); // timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 240); // timeout on response
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // stop after 10 redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $browser );
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/country_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/country_cookies.txt");

    $otvet = curl_exec($ch);

    if ($otvet === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }
  
    // rest request

    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_URL, $links[1]);
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