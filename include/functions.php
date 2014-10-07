<?php

function getInfoByIp($ip) {
    
    $res = array();
    
    // 1.
    
    $info = iconv("windows-1251", "utf-8", cURL_getpage("http://htmlweb.ru/analiz/whois_ip.php?ip=$ip"));
    $info = cut_str($info, '<div class="box1">', '</div>');
    
    if($info) {        
        $res[] = clearData(cut_str($info, "Город:", "</b>"));
        $res[] = clearData(cut_str($info, "Страна:", "</b>"));
    }
    
    // 2.
    if(!$info) { 
        $info = iconv("windows-1251", "utf-8", cURL_getpage("http://www.ip-ping.ru/ipinfo/?ipinfo=$ip")); 
        $info = clearData(cut_str($info, 'Расположение:', '</div>'));
         
        if($info) {
            $info = explode(",", $info);
            $res[] = clearData($info[0]);
            $res[] = clearData($info[2]);
        }
    } 
        
    // 3.
    
    return $res;
}

function getPosts($user_id = 0, $cat_id = 0, $type = '', $cat_level = 'parent') {
    
    $db = new db();
    
    global $cids;
 
    foreach($cids AS $k => $v) {
        if(stripos($v, ",") !== FALSE) {
            unset($cids[$k]);
            $cids = array_unique(array_merge($cids, explode(",", $v)));
        }
    }
    
    if($user_id) {
       $sql = " user_id = $user_id ";
    } else {

        if($cat_level == 'parent') {            
            $cat_id = explode(",", $cat_id);
        } else {
            $cat_id = array($cat_id);
        }
          
        if($type == 'js') {
            $f = true; 
            
            foreach($cids AS $k => $v) {                
                if(in_array($v, $cat_id)) {
                    unset($cids[$k]);
                    $f = false;                    
                }                
            }
            
            if($f) { $cids[] = join(",", $cat_id); }
                       
            foreach($cids AS $k => $v) {
                if(stripos($v, ",") !== FALSE) {
                    unset($cids[$k]);
                    $cids = array_unique(array_merge($cids, explode(",", $v)));
                }
            }
            
            set_data('cats_id', serialize($cids));
        }   
        
        $cids2 = join(',', $cids);                
        
        if(!$cids2) { $cids2 = 0; }
        
        $cat_sql = " AND cat_id IN ($cids2) ";
        $sql = " moder = 1 AND public = 1 AND ( DATE(post_start) <= '".C_Date."' AND DATE(post_end) >= '".C_Date."' ) $cat_sql ";
    }

    $posts = $db->get_all_rows(" SELECT id, user_id, cat_id, `name`, `post`, `logo`, `visits`,  "
            . " `likes`, DATE(post_start) AS post_start, DATE(post_end) AS post_end, "
            . "  DATEDIFF(DATE(post_end), DATE(post_start)) AS last_days "
            . " FROM posts AS p "
            . " WHERE $sql ");
    
    foreach($posts AS $k => $v) {
        $posts[$k]['avatar'] = $db->getValue("SELECT avatar FROM users WHERE id = {$v['user_id']} ");
        $posts[$k]['fio'] = $db->getValue("SELECT fio FROM users WHERE id = {$v['user_id']} ");
        $posts[$k]['login'] = $db->getValue("SELECT login FROM users WHERE id = {$v['user_id']} ");
        $posts[$k]['comments_count'] = $db->getValue("SELECT COUNT(*) FROM comments WHERE post_id = {$v['id']} ");
        $posts[$k]['cats'] = $db->super_query("SELECT * FROM categories WHERE id = {$v['cat_id']}");
        
        if($posts[$k]['cats']['parent_id']) {
            $posts[$k]['cats']['parent_cat'] = $db->super_query("SELECT * FROM categories WHERE id = {$posts[$k]['cats']['parent_id']}");
        }
        
        $posts[$k]['cats_tree'] = ($posts[$k]['cats']['parent_cat']['name']) ? $posts[$k]['cats']['name'].", ".$posts[$k]['cats']['parent_cat']['name'] : $posts[$k]['cats']['name'];
    }    
            
    unset($db);
    return $posts;    
}

function Msg($msg,$InDiv = false)
{
    return '<div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                        </button>
                            '.$msg.'
                        <br />
                </div>
';
}


function Error($msg,$InDiv = false)
{
    return '<div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                        </button><strong>Ошибка!</strong>
                           '.$msg.'
                        <br />
                </div>
';
}

function Alert($msg)
{
    return '<div class="alert alert-warning fade in">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      '.$msg.' 
    </div>';
}

function activeModule($do = '') {    
    if($do == _DO) {
        echo _ACTIVE;
    }    
}

?>
