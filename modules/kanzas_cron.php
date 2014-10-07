<?php

$id = 8;
$postData = getAdverts($id);

if(!$postData) { echo 'empty!'; exit; }

foreach($postData AS $k => $post) {
    
    if(is_array($post) && !empty($post)) {
        $post['add_property_form'] = '1';
        $post['phone'] = '06834552';
        $post['image'] = '@'.ROOT_DIR.'/images/test.jpg';
        //$post['img_url_string'] = '~http://www.kanzas.ua/image_storage/20140905/resized/14090511463850010.jpg';
        $post['kcaptcha_str'] = 'asdasd';
        $post['rulles'] = 'on';
        $postData[$k] = $post;
    }
    
}

$links = array(
    '0'=>'http://www.kanzas.ua/components/login/auth.php?log='._SITE_LOGIN_.'&pass='._SITE_PASS_,
    '1'=>'http://www.kanzas.ua/u22128/',
    '2'=>'http://www.kanzas.ua/components/add_property/add_property.php',
    '3'=>'http://www.kanzas.ua/thumb/save1.php',
    '4'=>'http://www.kanzas.ua/components/property_board/action.php?operation=refresh&value=',
);

if(!empty($postData)) {
    
    $browser = array(
       "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2",
   );
    //"Accept"=>'image/webp,*/*;q=0.8'
    $ch = curl_init();

    // login
    curl_setopt($ch, CURLOPT_URL,$links[0]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true); // set referer on redirect
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); // timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 240); // timeout on response
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // stop after 10 redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $browser );
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/kanzas_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/kanzas_cookies.txt");

    $otvet = curl_exec($ch);

    if ($otvet === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }
  
    // rest request

    curl_setopt($ch, CURLOPT_NOBODY, 0);
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('image'=>$v['image'],'form_ID'=>'1'));
        
        $otvet = curl_exec($ch); echo $otvet;
        pre(curl_getinfo($ch)); exit;
        
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
        
        // проверка и занос в бд
        if(stripos($otvet, "remove_me.php") !== FALSE) {
            $id = cut_str($otvet, "remove_me.php?obj=", '">');
            echo $id;
            if($id) {
                $db->query("INSERT INTO advertStatus SET advert_id = $k, onSite_id = '$id', dt_stop = '"._ADVERT_STOP_DT_."' ");
            }
        }
        
    }
    
    curl_close($ch);
    
}

exit;
?>