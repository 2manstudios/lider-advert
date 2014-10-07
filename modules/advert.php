<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') { 
    
    $ar = array();
    
    foreach($_POST AS $k => $v) {
        $ar[] = "$k = '$v'";
    }
    
    $db->query("INSERT INTO advert SET ".join(", ", $ar).", user_id = ".base64_decode($_SESSION['uid']));
}

$params['data'] = $db->get_all_rows("SELECT * FROM ourParams");

foreach($params['data'] AS $k => $v) {
    if($v['type1'] == 1) {
        $params['data'][$k]['data'] = $db->get_all_rows("SELECT * FROM ".array_shift(explode("_", $v['var'])));
    }
}

?>