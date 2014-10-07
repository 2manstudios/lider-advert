<?php

$id = "13";
$postData = getAdverts($id);

if(!$postData) { echo 'empty!'; exit; }

$advertUserId = $db->super_query("SELECT DISTINCT user_id FROM advert WHERE status = 1", true);
$userData = $db->get_all_rows("SELECT id, `name`, phone FROM user WHERE id IN (".join(",", $advertUserId).")");

foreach($userData AS $k => $v) {
    unset($userData[$k]);    
    $userData[$v['id']] = $v;
}

foreach($postData AS $k => $post) {
    
    if(is_array($post) && !empty($post)) {
        $post['property-type'] = 'жилая';
        $post['manually-added'] = '1';
        $post['country'] = 'Украина';        
        $post['period'] = 'month';        
        $post['phone'] = $userData[$post['user_id']]['phone'];
        $post['name'] = $userData[$post['user_id']]['name'];
        $post['organization'] = "КЦ ЛИДЕР - быстрая публикация объявлений на 20 сайтах за 5 минут! ";
        $post['url'] = "http://baza-lider.info/adverts/estate/$k";
        
        if($post['dt_add'] != '0000-00-00 00:00:00') {
            $dt = explode(" ", $post['dt_add']);
            $post['creation-date'] = $dt[0].'T'.$dt[1].'+02:00'; 
        }
        
        if($post['dt_update'] != '0000-00-00 00:00:00') {
            $dt = explode(" ", $post['dt_update']);
            $post['last-update-date'] = $dt[0].'T'.$dt[1].'+02:00';
        }
        
        if($post['dt_stop'] != '0000-00-00 00:00:00') {
            $dt = explode(" ", $post['dt_stop']);
            $post['expire-date'] = $dt[0].'T'.$dt[1].'+02:00';        
        }
        
        unset($post['dt_add']);
        unset($post['dt_update']);
        unset($post['dt_stop']);
        unset($post['user_id']);
        
        $postData[$k] = $post;
    }
    
}

//pre($postData); exit;

$yrl = getYRL($postData);
//echo $yrl;

write_to_file($yrl, ROOT_DIR."/tmp/adverts.yrl");           
header ("Content-Type: application/octet-stream");
header ("Accept-Ranges: bytes");
header ("Content-Length: ".filesize(ROOT_DIR."/tmp/adverts.yrl"));
header ("Content-Disposition: attachment; filename=adverts.yrl");  
readfile(ROOT_DIR."/tmp/adverts.yrl"); 
@unlink(ROOT_DIR."/tmp/adverts.yrl");

exit;


?>