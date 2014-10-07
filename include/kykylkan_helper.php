<?php

function getAdverts($id) {
    
    global $db;
    
    $postData = array();
    
    // выбираем объявления
    $adverts = $db->get_all_rows("SELECT * FROM advert WHERE status = 1");

    if(empty($adverts)) { return false; }

    // отбираем параметры сайта 
    $sParams = $db->get_all_rows(
            "SELECT DISTINCT s.var AS svar, o.var AS ovar, o.type1, o.label, s.id AS sid "
            . "FROM siteParams AS s "
            . "INNER JOIN ourParams AS o ON s.our_id = o.id AND s.site_id IN ($id) AND s.var != ''"
            );

    if(empty($sParams)) { return false; }
    
    foreach($adverts AS $k => $advert) { $post = array();
        foreach($advert AS $k1 => $v1) {            
            foreach($sParams AS $k2 => $v2) {
                
                if($v2['type1'] && stripos($k1, "_id") !== FALSE) {                
                    
                    $v2['svalue'] = $db->getValue("SELECT `value` FROM siteParamsValue WHERE siteParam_id = {$v2['sid']} AND tableValue_id = {$v1} ");   
                    
                    if(!$v2['svalue']) {
                        $v2['svalue'] = $db->getValue("SELECT `name` FROM ".array_shift(explode("_", $v2['ovar']))." WHERE id = {$v1}");
                    }
                    
                } else {          
                    $v2['svalue'] = array_shift(explode(".", $v1));     
                }

                if($k1 == $v2['ovar'] && $v2['svalue']) {   
                    if(stripos($v2['svar'], "[]") !== FALSE && $v2['svalue']) {
                        
                        $v2['svar'] = str_replace("[]", "", $v2['svar']);  
                        $post[$v2['svar']][] = $v2['svalue'];
                        
                    } elseif(stripos($v2['svar'], "[") !== FALSE) { 
                        
                        $arIndex = cut_str($v2['svar'], "[", "]");
                        $arName = str_replace("[$arIndex]", "", $v2['svar']);                        
                        $post[$arName][$arIndex] = $v2['svalue'];
                        
                    } else {                        
                        $post[$v2['svar']] = $v2['svalue'];                        
                    }                     
                }
                
            }
            
        }

        if(is_array($post) && !empty($post)) { 
            
            $images = $db->super_query("SELECT image FROM advertImages WHERE advert_id = {$advert['id']} ", true);
            
            foreach($images AS $ik => $iv) {
                $post['image'][$ik] = _SITE_URL_FULL_._IMAGES_URL_."/".$iv;
            }
            
            $post['dt_add'] = $advert['dt_add'];
            $post['dt_update'] = $advert['dt_update'];
            $post['dt_stop'] = $advert['dt_stop'];
            $post['user_id'] = $advert['user_id'];
            
            $postData[$advert['id']] = $post;
        }
        
    }
    
    return $postData;
}

function getYRL($data = null) {
    
    if($data == null) { return false; }
    
    $yrl = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"
            ."\t<realty-feed xmlns=\"http://webmaster.yandex.ru/schemas/feed/realty/2010-06\">\n"
            ."\t\t<generation-date>"._DATE_NOW_."T"._TIME_NOW_."+02:00</generation-date>\n"
        ;
    
    foreach($data AS $k => $v) {
        if(is_array($v) && !empty($v)) {
         
            $yrl .= "\t\t<offer internal-id=\"$k\">\n";
                    
            foreach($v AS $k1 => $v1) {
                
                //images
                if(is_array($v1)) {
                    foreach($v1 AS $ik => $iv) {
                        $yrl .= "\t\t\t<$k1>$iv</$k1>\n";
                    }
                    
                    $v1 = '';
                    unset($v1);
                }
                
                // address                
                if($k1 == 'region') { 
                    $yrl .= "\t\t\t<location>\n";
                    $yrl .= "\t\t\t<country>{$v['country']}</country>\n";
                }
                
                if($k1 == 'address') { 
                    if($v['house_number']) {
                        $v1 .= ", {$v['house_number']}";
                    }                     
                }                 
                
                // price                
                if($k1 == 'currency') {
                    $yrl .= "\t\t\t<price>\n";
                    $yrl .= "\t\t\t<$k1>$v1</$k1>\n";
                    $yrl .= "\t\t\t<value>{$v['value']}</value>\n";
                    $yrl .= "\t\t\t<period>{$v['period']}</period>\n";
                    $yrl .= "\t\t\t<unit>{$v['unit']}</unit>\n";
                    $yrl .= "\t\t\t</price>\n";
                }
                
                //contacts
                if($k1 == 'phone') { $yrl .= "\t\t\t<sales-agent>\n"; }
                
                switch ($k1) {
                    case 'country':
                    case 'house_number':
                    case 'period':
                    case 'unit':
                    case 'value':
                    case 'currency':
                            $v1 = '';
                        break;

                    default:
                        break;
                }
                
                if($v1) {
                    
                    switch ($k1) {
                        case 'lot-area':
                            $unit = 'сот';
                        case 'area':
                        case 'living-space':
                        case 'kitchen-space':                        

                            if(!$unit) { $unit = 'кв.м'; }
                            $yrl .= "\t\t\t<$k1>\n\t\t\t<value>$v1</value>\n\t\t\t<unit>$unit</unit>\n\t\t\t</$k1>\n";

                            break;

                        default:
                            if($v1) { $yrl .= "\t\t\t<$k1>".@trim($v1)."</$k1>\n"; }
                            break;
                    }      
                }
                
                // address
                if($k1 == 'address') { $yrl .= "\t\t\t</location>\n"; }
                
                //contacts
                if($k1 == 'url') { $yrl .= "\t\t\t</sales-agent>\n"; }

            }            
            
            $yrl .= "\t\t</offer>\n";
            
        }
    }
    
    $yrl .= "\t</realty-feed>";
    
    return $yrl;
}

function sendEmail($params) {
    $mail = new PHPMailer(); 
    $mail->From = $params['from_email'];      // от кого 
    $mail->FromName = $params['from_pib'];   // от кого 
    $mail->AddAddress($params['to_email'],$params['to_pib']); // кому - адрес, Имя 
    $mail->IsHTML(true);        // выставляем формат письма HTML 
    $mail->Subject = $params['subject'];  // тема письма 

    $mail->Body = $params['text'];  
    
    if($params['file']) {
        $mail->AddAttachment($params['file']);
    }

    // отправляем наше письмо 
    if(@$mail->Send()) {
        unset($mail);
        return true;
    }

    unset($mail);
    return false;
}

function check_email($email) {
  return preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $email);
}

function check_email2($email) {
  global $db;

  if($db->getValue("SELECT id FROM user WHERE email = '$email'")) {
      return TRUE;
  } else {
      return FALSE;
  }
  
}

function check_phone($phone) {
  global $db;

  if($db->getValue("SELECT id FROM user WHERE phone = '$phone'")) {
      return FALSE;
  } else {
      return TRUE;
  }
  
}

function upImages($_FILES, $id, $dir) {
    if (!empty($_FILES) && $dir)
	{
            $imagesList = array_values($_FILES);          
              
            for ($i = 0; $i < count($_FILES); $i++)
                if ($imagesList[$i]['error'] != 0)
                {
                    unset($imagesList[$i]);
                }
                     
            foreach ($imagesList as $imageKey => $image)
            {

                //echo '<pre>'; echo print_r($imageList);  echo '</pre>';      
                              
                //$imagesList[$key]['name'] = 'новое значение';
              
                //echo  $imagesList[$key]['name'] ;
                 
                $imagesList[$imageKey]['name'] = namesGenerate($imagesList[$imageKey]['type'], 'n');            
                $imagesList[$imageKey]['new_name'] = $imagesList[$imageKey]['name'] . namesGenerate($imagesList[$imageKey]['type'], 'y');  

                if (($rezult == true) and validType($imagesList[$imageKey]['type']))
                    $rezult = true;
                else
                {
                    $imageError = imageErrorFormat . ' => ' . $imagesList[$imageKey]['type']; 
                    $rezult = false;
                }

                if (($rezult == true) and validSize($imagesList[$imageKey]['size']))
                    $rezult = true;
                else
                {
                    $imageError = imageErrorSize . ' => ' . $imagesList[$imageKey]['size']; 
                    $rezult = false;
                }         

            }   
            
         //      echo '<pre>'; echo print_r($imagesList);  echo '</pre>';    
	}
        
                            //ЗАГРУЖАЕМ ФОТКИ
                if (count($imagesList) > 0)
                { 
                    /*$db = new db();
                    
                    $images = $db->super_query_v2("SELECT pr_image FROM products_images WHERE product_id = $pid*/
                
                    foreach ($imagesList as $imageKey => $image)
                    {
                        if (upload_image($imagesList[$imageKey]['tmp_name'],$imagesList[$imageKey]['new_name'], $dir))
                        {
                            $rezult = true;
                            $imageError = 'Фото загрузились!';
                            return $imagesList[$imageKey]['new_name'];
                            /*
                            if($images[$imageKey]) { 
                                $db->query("DELETE FROM products_images WHERE pr_image = '{$images[$imageKey]}'");
                                @unlink(ROOT_DIR."/images/prs/{$images[$imageKey]}");
                            }
                            
                            $db->query("INSERT INTO products_images (product_id, pr_image) VALUES($pid, '{$imagesList[$imageKey]['new_name']}') ");
                            */
                            //echo '<pre>'; echo print_r($imagesList);  echo '</pre>';  
                        }
                        else
                        {
                           $rezult = false;  
                           $imageError = 'Фото не загрузились!';
                           
                           //echo '<pre>'; echo print_r($imagesList);  echo '</pre>';  
                        }
                        
                        
                    }
                 }
    //unset($db);
}


function validSize($imageSize)
{
	if ($imageSize <= 50240000)
	{
		return true;
	}
	else return false;
}

function upload_image($tmpImage, $nameOfImage,$dir = '') {     
    $res  = move_uploaded_file($tmpImage, "images/$dir/" . $nameOfImage);
        
    if ($res)
   { 
       return true;
   } 
   else
   {
       return false;
   }
}

function validType($imageType) {		
    switch ($imageType)
    {
        case	'image/gif':
                return true;
                break;	
        case	'image/png':
            return true;
                break;	
        case	'image/jpg':
                return true;
                break;	
        case	'image/jpeg':        
                return true;
                break;	
        case	'image/bmp':
            return true;
                break;	
                							
        default:		
                return false;
    }		
}

function namesGenerate($imageType, $withType) {
   if ($withType == 'y') 
   {
       switch ($imageType)
        {
            case	'image/gif': 
                    return '.gif';
                    break;
            case	'image/png':
                    return '.png';
                    break;
                      case	'image/jpg':
                    return '.jpg';
                    break;  
                case	'image/jpeg':
                    return '.jpeg';
                    break;
            case	'image/bmp':
                    return '.bmp';
                    break;
        }
   }
   elseif ($withType == 'n') 
   {
       return uniqid('ff_');
   }
    
}

function verifSome2($i, $ar2) {
       
    foreach($ar2 AS $k => $v) {
        if($v['on'] && ($i >= $v['shour'] && $i <= $v['ehour']) || ($v['invers'] &&
                (($dt == $v['dts'] && $i >= $v['shour']) || ($dt == $v['dte']) &&
                $i <= $v['ehour']))) {
            
            return $k;
            
        }
    }
    
}

function verifSome($i, $ar2) {
    
    $val = FALSE;
    
    foreach($ar2 AS $k => $v) {
        if($v['on'] && ($i >= $v['shour'] && $i < $v['ehour']) || ($v['invers'] &&
                (($dt == $v['dts'] && $i >= $v['shour']) || ($dt == $v['dte']) &&
                $i < $v['ehour']))) {
            
            $val = TRUE;
            
        }
    }
    
    return $val;
    
}

function send_sms($to, $msg, $login, $pass) {
  $u = 'http://www.websms.ru/http_in4.asp';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'Http_username='.$login.'&Http_password='.$pass.'&Phone_list='.$to.'&Message='.urlencode($msg));
  curl_setopt($ch, CURLOPT_URL, $u);
  $u = trim(curl_exec($ch));
  curl_close($ch);
  return cut_str($u,"Http_id=","Balance");
}

function formatPrice($p) {
    return round(str_replace(',', '.', $p), 3);
}

// Подключение шаблона.
function view_include($fileName, $vars = array()){
	// Установка переменных для шаблона.
	foreach ($vars as $k => $v)
	{
		$$k = $v;
	}

	// Генерация HTML в строку.
	ob_start();
	include $fileName;
	return ob_get_clean();	
}

function write_to_file($data,$filename) {
  if (!$handle = fopen($filename, 'w+'))
     {
       return false;
     }

  if (@is_writable($filename))
     {

       if (fwrite($handle, $data) === FALSE)
          {
            return false;
          }

       fclose($handle);
       return true;

     } else {
       return false;
     }
}

function write_to_file_nc($data,$filename) {
  if (!$handle = fopen($filename, 'a'))
     {
       return false;
     }

  if (@is_writable($filename))
     {

       if (fwrite($handle, $data) === FALSE)
          {
            return false;
          }

       fclose($handle);
       return true;

     } else {
       return false;
     }
}

function GetMyFileList($folder, $sf) {
    if ($handle = opendir($folder)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.html" && $file != "tags.html") {
                if ($sf==true){
                    $mas[]=$folder."/".$file;
                } else
                {$mas[]=$file;}
            }
        }
        closedir($handle);
    }
    if (@!$mas) return false;
    return $mas;
}

function formate_query($array) {
   $str = "";
   $f=0;
   foreach($array as $name=>$value)
          {
             if($f>0)
               {
                  $n='&';
               } else {
                  $n='';
               }
             $str .= $n.$name.'='.$value;
             $f++;
          }

   return $str;
}


function set_data($data,$var,$time='') {

  if($time=='') { $time = "31556926";}

  if(DATA_SAVE == 1)
    {
      if($var != '')
        {
          $_SESSION[$data] = $var;
        } else {
          unset($_SESSION[$data]);
        }
    } else {
      if($var != '') { $time = time()+$time; } else { $time = "-1"; }
      setcookie($data, $var, $time, '/');
    }
}

function get_data($var) {
  global $config;

  if($config['data_save'] == "1")
    {
      if(!isset($_SESSION[$var])) { return false; }
      return strtolower(trim($_SESSION[$var]));
    } else {
      if(!isset($_COOKIE[$var])) { return false; }
      return strtolower(trim($_COOKIE[$var]));
    }
}

//Отфильтровка данных
function clearData($data, $type = 'ss') {
    switch ($type) {
        case 'i':
            return intval(abs((int)$data));
            break;
        case 'f':
            return floatval(abs((float)$data));
            break;
        case 'ss':
            return addslashes(htmlspecialchars(trim($data)));
            break;
        case 'sf':
            return addslashes(htmlspecialchars(urlencode(strip_tags(trim($data)))));
            break;
        case 'rs':
            return trim(urldecode(html_entity_decode(stripslashes($data))));
            break;
        default:
            return false;
            break;
    }
}

// меняем ключи масива
function getArrayKeysRename($ar, $str) {
    
    $na = array();
    
    foreach ($ar as $k => $v) {
        $na[$k."_".$str] = $v;
    }
    
    return $na;     
}

// масив, поле для ключ, поля для значение
function sortBigArray($ar, $var1, $var2) {
    
    $nar = array();    
    
    foreach ($ar as $k => $v) {
        $nar[$v[$var1]] = $v[$var2];
    }
    
    arsort($nar);
    $f = array();        
      
    $i = 0;
    foreach ($nar as $k => $v) {
        
        $j = 0;
        foreach ($ar as $k2 => $v2) {
            if($k == $v2[$var1]) {                
                $f[$i] = $ar[$k2];
                break;
            }
            
            $j++;
        }

        $i++;
    }
    
    return $f;
}

function getIMDBMovieName($id) {

    /*
    $url = "http://www.imdb.com/title/$id/";        
    $s = file_get_contents($url);
    $s = cut_str($s, '<td id="overview-top">', 'infobar');        
    $s1 = cut_str($s, '<span class="title-extra" itemprop="name">', '<i>');

    if(!$s1) {
        $s1 = cut_str($s, '<span class="itemprop" itemprop="name">', '</span>');
    }*/

    return file_get_contents("http://www.sexshop.ck.ua/imdb_parse.php?id=$id");
}

function checkServerAnswer($header) {
    if(stripos($header, "HTTP/1.1 200 OK") !== FALSE) { return TRUE; } else { return FAlSE; }
}

function checkRedirect($header) {
    if(stripos($header, "Location: ") !== FALSE) { 
        $header = str_replace("\n", " ", $header);
        return trim(cut_str($header, "Location: ", " "));
    } else {
        return FALSE;
    }
}

function connect($links, $post_login = null, $post = null, $post2 = null, $site){
  
$browser = array(
       "user_agent" => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36",
       "language" => "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2"       
   );
    
$ch = curl_init();
    
// login
curl_setopt($ch, CURLOPT_URL,$links[0]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_NOBODY, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 
                array(
                "User-Agent: {$browser['user_agent']}",
                "Accept-Language: {$browser['language']}"
             )
        );
curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/{$site}_cookies.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/{$site}_cookies.txt");

if($post_login !== null) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_login);
}

$otvet = curl_exec($ch);

if ($otvet === FALSE) {
    echo "cURL Error: " . curl_error($ch);
    return false;
}

if(!checkServerAnswer($otvet)) { 
    return FALSE;
}


// rest request

curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_URL, $links[1]);
$otvet = curl_exec($ch);
  
if ($otvet === FALSE) {
    echo "cURL Error: " . curl_error($ch);
    return false;
}

if(!checkServerAnswer($otvet)) { 
    return FALSE;
}
//echo $location;
//echo $otvet; exit;
// post

if($post !== null) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
} 

curl_setopt($ch, CURLOPT_URL, $links[2]);
$otvet = curl_exec($ch);

if ($otvet === FALSE) {
    echo "cURL Error: " . curl_error($ch);
    return false;
}
echo $otvet; exit;
// если был редирект
$location = checkRedirect($otvet); 

if($location) {
    
    // #1 - грузим фото
    
    if($post2 !== null) {
        
        if($post2['need_id']) {            
            $id = trim(cut_str($location, "ad_id=", "&"));  
            $post2["photo_$id"] = $post2["image"];
            $post2['ad_id'] = $id;
        }
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post2);
    }
    
    curl_setopt($ch, CURLOPT_URL, $links[3]);
    $otvet = curl_exec($ch);

    if ($otvet === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        return false;
    }

 /*  $location = checkRedirect($otvet);
   
   if($location) {*/

       # 2
       
       curl_setopt($ch, CURLOPT_POST, 0);
       //curl_setopt($ch, CURLOPT_POSTFIELDS, $post3);
       curl_setopt($ch, CURLOPT_URL, $links[4]."?ad_id=$id" );
       
       $otvet = curl_exec($ch);

        if ($otvet === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            return false;
        }
             
    
    if(!checkServerAnswer($otvet)) { 
        return FALSE;
    }    
    
} else {
    if(!checkServerAnswer($otvet)) { 
        return FALSE;
    }
}

curl_close($ch);
return $id;
}

function connect2($link,$cookie=null,$post=null){
     //Авторизировались. Теперь можно выполнять действия от пользователя. Запросим страницу...
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $link);  //URL по которому перейдём 
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);     
    curl_setopt($ch, CURLOPT_COOKIEJAR, ROOT_DIR."/tmp/my_cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, ROOT_DIR."/tmp/my_cookies.txt");
    
    if($post !== null)
    {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $content = curl_exec($ch); 
    curl_close($ch);
    return $content;
}

function cURL_getpage($URL, $post = '', $cookies = '') {
   $name = "";
   $poststr = "";   
   $browser = array(
       "user_agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
       "language" => "en-us,en;q=0.5"
   );
   
   $ch = curl_init();
   
    // указываем url
     curl_setopt($ch, CURLOPT_URL, $URL);
     
     // нам не нужно содержание страницы
     //curl_setopt($ch, CURLOPT_NOBODY, 1);
     
     // если перенаправление разрешено
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
    //для автоматической установки поля Referer: в запросах, перенаправленных заголовком Location:.
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

    // то сохраним наши данные в cURL
    //curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
     
    // возвращаем результаты вместо вывода
     curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
     
     // нам необходимо получить HTTP заголовки
     curl_setopt($ch,CURLOPT_HEADER,1);
     
      // указываем заголовки для браузера
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "User-Agent: {$browser['user_agent']}",
        "Accept-Language: {$browser['language']}"
     ));
     
     if($cookies) {
         curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);// обнуляем куки
         curl_setopt($ch, CURLOPT_COOKIE, $cookies);
     }
     
    if(is_array($post)){ 
        
        /*$f=0;
      foreach($post as $name=>$value){
        if($f>0){ $n='&'; }else{ $n=''; }
        $poststr.=$n.$name.'='.$value;
        $f++;
      }*/
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
             
   $data = curl_exec($ch);
   curl_close($ch);

    // был ли HTTP редирект?
/*
     if (preg_match("!Location: (.*)!", $data, $matches)) {
         echo "$URL: redirects to $matches[1]\n";
     } else {
         echo "$URL: no redirection\n";

     }*/
     
   return $data;
}   
    
function Utf8Win($str,$type="w")  {
    static $conv='';

    if (!is_array($conv))  {
        $conv = array();

        for($x=128;$x<=143;$x++)  {
            $conv['u'][]=chr(209).chr($x);
            $conv['w'][]=chr($x+112);

        }

        for($x=144;$x<=191;$x++)  {
            $conv['u'][]=chr(208).chr($x);
            $conv['w'][]=chr($x+48);
        }

        $conv['u'][]=chr(208).chr(129);
        $conv['w'][]=chr(168);
        $conv['u'][]=chr(209).chr(145);
        $conv['w'][]=chr(184);
        $conv['u'][]=chr(208).chr(135);
        $conv['w'][]=chr(175);
        $conv['u'][]=chr(209).chr(151);
        $conv['w'][]=chr(191);
        $conv['u'][]=chr(208).chr(134);
        $conv['w'][]=chr(178);
        $conv['u'][]=chr(209).chr(150);
        $conv['w'][]=chr(179);
        $conv['u'][]=chr(210).chr(144);
        $conv['w'][]=chr(165);
        $conv['u'][]=chr(210).chr(145);
        $conv['w'][]=chr(180);
        $conv['u'][]=chr(208).chr(132);
        $conv['w'][]=chr(170);
        $conv['u'][]=chr(209).chr(148);
        $conv['w'][]=chr(186);
        $conv['u'][]=chr(226).chr(132).chr(150);
        $conv['w'][]=chr(185);
    }

    if ($type == 'w') {
        return str_replace($conv['u'],$conv['w'],$str);
    } elseif ($type == 'u') {
        return str_replace($conv['w'], $conv['u'],$str);
    } else {
        return $str;
    }
}
    
    
function utf8_to_cp1251($utf8) {

    $windows1251 = "";
    $chars = preg_split("//",$utf8);

    for ($i=1; $i<count($chars)-1; $i++) {
        $prefix = ord($chars[$i]);
        $suffix = ord($chars[$i+1]);

        if ($prefix==215) {
            $windows1251 .= chr($suffix+80);
            $i++;
        } elseif ($prefix==214) {
            $windows1251 .= chr($suffix+16);
            $i++;
        } else {
            $windows1251 .= $chars[$i];
        }
    }

    return $windows1251;
}
    
function getDays() {
    for($i = 1; $i <= 7; $i++) {
        $ar[$i] = getDayNameByNumber($i);
    }

    return $ar;
}
 
function getDayNumber($d = '', $m = '', $dt = '') {
    
    if(!$dt)  {
        $dt = @date("Y-m-d",mktime(date("H"), date("i"), date("s"),
                (!$m) ? date("m") : $m, (!$d) ? date("d") : $d, date("Y")));
    }
    
    return date("N", strtotime($dt));
}

function getDayNameByDayNumber($d, $m = '') {  
    return getDayNameByNumber(getDayNumber($d, $m)); 
}
    
function getMonth() {
    for($i = 1; $i <= 12; $i++) {
        $ar[$i] = getMonthNameByNumber($i);
    }

    return $ar;
}
   
function getDaysInMonth($m = 1) {
    return @date("t", mktime(0, 0, 0, $m, date("d"), date("Y")));
}

function getDMonth() {
    for($i = 1; $i <= 31; $i++) {
        $ar[$i] = $i;
    }

    return $ar;
}

function getMonthNameByNumber($num = 1) {
    switch ((int)$num) {
        case 1:
                return 'Январь';
            break;
        case 2:
                return 'Февраль';
            break;
        case 3:
                return 'Март';
            break;
        case 4:
                return 'Апрель';
            break;
        case 5:
                return 'Май';
            break;
        case 6:
                return 'Июнь';
            break;
        case 7:
                return 'Июль';
            break;
        case 8:
                return 'Август';
            break;
        case 9:
                return 'Сентябрь';
            break;
        case 10:
                return 'Октябрь';
            break;
        case 11:
                return 'Ноябрь';
            break;
        case 12:
                return 'Декабрь';
            break;

        default:
            break;
    }
}

function getDayNameByNumber($num = 1) {
    switch ((int)$num) {
        case 1:
                return 'Понедельник';
            break;
        case 2:
                return 'Вторник';
            break;
        case 3:
                return 'Среда';
            break;
        case 4:
                return 'Четверг';
            break;
        case 5:
                return 'Пятница';
            break;
        case 6:
                return 'Суббота';
            break;
        case 7:
                return 'Воскресенье';
            break;

        default:
            break;
    }
}

function getFormatTimeStats($n = 1) {
    $t = explode(".", round(($n / 60), 2));  
    $n = "{$t[0]} ч. ".round(((float)"0.$t[1]") * 60)." м.";
    return $n;
}

function getSomeParamFromDT($dt, $t = 'h') {
    $d3 = explode(" ", $dt);

    if($t == 'dt') { return $d3[0]; }

    $d = explode(":", $d3[1]); 
    $d2 = explode("-", $d3[0]); 

    switch ($t) {
        case 'h':
                $d = $d[0];
            break;
        case 'm':
                $d = $d[1];
            break;
        case 's':
                $d = $d[2];
            break;
        case 'y':
                $d = $d2[0];
            break;
        case 'mm':
                $d = $d2[1];
            break;
        case 'd':
                $d = $d2[2];
            break;

        default:
                $d = '';
            break;
    }

    return $d;        
}

function format_tel($tel, $country = 'ru') {

  /*Убираем мусор*/
  $tel = str_replace(" ","",$tel);
  $tel = str_replace("(","",$tel);
  $tel = str_replace(")","",$tel);
  $tel = str_replace("-","",$tel);

  if($tel != false && trim($tel) != "")
    {
      if($country == "ru") /*Россия*/
        {
          if(substr($tel,0,3) == "812")
            {
              $tel = "+7".$tel;
            }
          if(substr($tel,0,1) == "9")
            {
              $tel = "+7".$tel;
            }
          if(substr($tel,0,2) == "89")
            {
              $tel = "+79".substr($tel,2,strlen($tel)-2);
            }

          if(substr($tel,0,2) == "+7" && substr($tel,2,1) != "9" && substr($tel,2,1) != "4")
            {
                if(substr($tel,2,1) == "4")
                {
                   $tel = "+74".substr($tel,3,strlen($tel)-3);
                } elseif (substr($tel,2,1) == "9") {
                   $tel = "+79".substr($tel,3,strlen($tel)-3);
                }
            }
        }

      if($country == "ua") /*Украина*/
        {
          if(substr($tel,0,2) != "+3" && substr($tel,0,2) == "80")
            {
              $tel = "+3".$tel;
            }
          if(substr($tel,0,2) != "+3" && substr($tel,0,1) == "0")
            {
              $tel = "+38".$tel;
            }
        }

       return $tel;

    }
}

function cut_str($str, $left, $right) {
    $str = substr(@stristr($str, $left), strlen($left));
    $leftLen = strlen(@stristr($str, $right));
    $leftLen = $leftLen ? -($leftLen) : strlen($str);
    $str = substr($str, 0, $leftLen);
    return $str;
 }

function pre($array) {
    echo "<pre>"; echo print_r($array); echo "</pre>";
}   


function getFormatDate ($dt, $time = false) {
   if(!$time) {
       $dt = date("j F Y",strtotime($dt));
   } elseif($time) {
       $dt = date("j F Y H:i:s",strtotime($dt));
   }
   
   $dt_params = explode(" ", $dt);
   	
   
   switch ($dt_params[1]) {
       case "January":
            $dt_params[1] = "Января";
           break;
       case "February":
            $dt_params[1] = "Февраля";
           break;
       case "March":
            $dt_params[1] = "Марта";
           break;
       case "April":
            $dt_params[1] = "Апрель";
           break;
       case "May":
            $dt_params[1] = "Мая";
           break;
       case "June":
            $dt_params[1] = "Июня";
           break;
       case "July":
            $dt_params[1] = "Июля";
           break;
       case "August":
            $dt_params[1] = "Августа";
           break;
       case "September":
            $dt_params[1] = "Сентября";
           break;
       case "October":
            $dt_params[1] = "Октября";
           break;
       case "November":
            $dt_params[1] = "Ноября";
           break;
       case "December":
            $dt_params[1] = "Декабря";
           break;

       default:
           break;
   }
   
   
   if(!$time) {
       return ($dt_params[0]." ".$dt_params[1]." ".$dt_params[2]);
   } elseif($time) {
       return ($dt_params[3] . ", " .$dt_params[0]." ".$dt_params[1]." ".$dt_params[2]);
   }
   
}

?>
