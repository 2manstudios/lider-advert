<?php

include ROOT_DIR."/include/site_data/fn_data.php";

$id = 2;
$postData = getAdverts($id);

if(!$postData) { echo 'empty!'; exit; }
pre($postData); exit;
foreach($postData AS $k => $post) {
         
    if(is_array($post) && !empty($post)) {
    
        if($post['property_id'] == 2) {
            $post['apricetype'] = 3;
        }
        elseif($post['property_id'] == 3) {
            if($post['costDay']) {
                $post['apricetype'] = 2;
            } elseif($post['costHour']) {
                $post['apricetype'] = 5;
            } else {
                $post['apricetype'] = 3;
            }
        }
        
      
        foreach($data AS $kk => $post1) {                        
            if(!$post['parent_id'][0]) {
                $post['parent_id'][0] = $db->getValue("SELECT `value` FROM siteParamsValue WHERE `name` = '$kk' AND tableValue_id = $post1 ");
            } else {
                foreach($data2[$post['parent_id'][0]] AS $k2 => $post2) {
                    if(!$post['parent_id'][1]) { 
                        $post['parent_id'][1] = $db->getValue("SELECT `value` FROM siteParamsValue WHERE `name` = '$post2' AND tableValue_id = {$post['property_id']} ");
                    } else {
                        foreach($data3[$post['parent_id'][1]] AS $k3 => $post3) {
                            if(!$post['parent_id'][2]) { 

                                if($db->getValue("SELECT `name` FROM district WHERE `name` LIKE '".array_shift(explode(" ", $post3))."%' AND id = {$post['district_id']} ")) {
                                    $post['parent_id'][2] = $k3;
                                }

                                if(!$post['parent_id'][2]) {
                                    if($db->getValue("SELECT `name` FROM region WHERE `name` LIKE '".array_shift(explode(" ", $post3))."%' AND id = {$post['region_id']} ")) {
                                        $post['parent_id'][2] = $k3;
                                    }
                                }
                            } else {
                                foreach($data4[$post['parent_id'][2]] AS $k4 => $post4) {
                                    if(!$post['parent_id'][3]) { 
                                        if($db->getValue("SELECT `name` FROM town WHERE `name` LIKE '".array_shift(explode(" ", $post4))."%' AND id = {$post['town_id']} ")) {
                                            $post['parent_id'][3] = $k4;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }                        
        }
        
        
        unset($post['new_build']);
        unset($post['build_type']);
        unset($post['flr']);
        unset($post['flrs']);
        
        $post['apricecur'] = 1;
        $post['apricetype'] = 3;
        $post['acomtype'] = 1;
        $post['atitle'] = '1публикация пробная33343434';
        $post['acontact'] = 'Advert';
        $post['acode1'] = '95';
        $post['aphone1'] = '0655396';
        $post['asite'] = 'ads.pricesale.com.ua/id1';
        $post['subm'] = 'Дальше';
        
        $postData[$k] = $post;
        
    }
}

pre($postData); exit;

$links = array(
    'login'=>'http://fn.ua/user/index.php',
    'profile'=>'http://fn.ua/user/',
    'postAdvert'=>'http://fn.ua/add_edit_db2.php',
    'imageUpload'=>'http://fn.ua/upload_photo.php',
    'postSuccess'=>'http://fn.ua/newad/ad.php',    
);

$postLogin = array(
    'uemail'=>_SITE_LOGIN_,
    'upass'=>_SITE_PASS_,
    'go_auth'=>'Войти'
);

$post_photo = array(
    'MAX_FILE_SIZE'=>'4000000',
    'ad_id'=>'',
    'image'=>'',
    'need_id'=>'1'
);
    
if(!empty($postData)) {
    
    $browser = array(
       "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2",
       "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
       "Connection: keep-alive"
   );
    //"Accept"=>'image/webp,*/*;q=0.8'
    $ch = curl_init();

    // login
    curl_setopt($ch, CURLOPT_URL,$links['login']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращаем результаты вместо вывода
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); // timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 240); // timeout on response
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // stop after 10 redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // если перенаправление разрешено
    curl_setopt($ch, CURLOPT_USERAGENT, $browser );
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/fn_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/fn_cookies.txt");

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
    curl_setopt($ch, CURLOPT_NOBODY, 0);
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
                        
        // post advert
        if(!empty($v)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $v);
        } 

        curl_setopt($ch, CURLOPT_URL, $links['postAdvert']);
        $otvet = curl_exec($ch);

        if ($otvet === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            continue;
        }
              
        // если был редирект
        $location = checkRedirect($otvet); 

        if($location) {
    
            $id = trim(cut_str($location, "ad_id=", "&"));  
            $post_photo['ad_id'] = $id;
            
            #1 - грузим фото
            if(!empty($v['image'])) {
                
                foreach($v['image'] AS $ki => $image) {                
                    if($post_photo['need_id']) {   
                        $post_photo["photo_$id"] = $image;                        
                    }

                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_photo);
                    curl_setopt($ch, CURLOPT_URL, $links['imageUpload']);
                    $otvet = curl_exec($ch);

                    if ($otvet === FALSE) {
                        echo "cURL Error: " . curl_error($ch);
                        return false;
                    }
                }
                
            }

            # 2 - success advert
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $links['postSuccess']."?ad_id=$id" );

            $otvet = curl_exec($ch);

             if ($otvet === FALSE) {
                 echo "cURL Error: " . curl_error($ch);
                 return false;
             }   

        }        
        
        if(!is_numeric($id)) {
            echo "not publication<br>"; continue;
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