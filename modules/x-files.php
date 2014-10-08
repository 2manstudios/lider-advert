<?php

if(!_LOGIN_ || base64_decode($_SESSION['uid']) != 1) { header("location: / "); exit; }

if($_SERVER['REQUEST_METHOD'] == 'POST') { 
    
    if($_POST['else']) {  
        $params['before'] = $_POST['before'];
        
        $t = array();
        
        $data = explode("<option", $_POST['before']);
                
        foreach($data AS $k => $v) {
            if($v) {   
                $t1 = strip_tags("<option$v"); 
                $t2 = cut_str($v, 'value="', '"');
                $t[] = "'$t2' => '$t1',";
            }
        }
        
        $params['after'] = join("\n", $t);
    }
   
    if($_POST['addSiteValue']) {   
        
        
        /*
         * $v[0] = параметр из формы
         * $v[1] = значения поля tableValue_id
         * $v[2] = айди записи в siteParamsValue
         * $v[3] = add OR edit
         */
        
        
        $pid = clearData($_POST['pid'], 'i'); // айди с таблицы парамсвалюе
        $oid = clearData($_POST['oid'], 'i'); // айди таблицы наших переменных
        $cpid = clearData($_POST['cpid'], 'i'); // тоже что и выше
        $parentId = clearData($_POST['parentId'], 'i'); // айди родительской записи таблицы парамсвалюэ

        //pre($_POST);exit;
        
        $table = array_shift(explode("_", $db->getValue("SELECT `var` FROM ourParams WHERE id = $oid")));
        
        if($_POST['data']) {
            
                if(stripos($_POST['data'], "<select") !== FALSE) {
                    $_POST['data'] = cut_str($_POST['data'], ">", "</select>");
                }
                
                $data = explode("<option", $_POST['data']);
                
                foreach($data AS $k => $v) {
                    if($v) {   
                        $t[0] = trim(strip_tags("<option$v")); 
                        $t[1] = trim(cut_str($v, 'value="', '"'));

                        if(stripos($t[0], " ") !== FALSE) {
                            
                            if(stripos($t[0], ".") !== FALSE) {
                                if(stripos($t[0], ".") <= stripos($t[0], " ")) {
                                    $t[2] = array_pop(explode(" ", $t[0]));
                                } else {
                                    $t[2] = array_shift(explode(" ", $t[0]));
                                }
                            } else {
                                $t[2] = array_shift(explode(" ", $t[0]));
                            }
                     
                        } else {
                            $t[2] = $t[0];
                        }
                        
                        $sql = '';
                        if($_POST['region']) {
                            $params['region'] = clearData($_POST['region'], 'i');
                            $sql = " AND region_id = {$params['region']}";
                        }                    
                        if($_POST['district']) {
                            $params['district'] = clearData($_POST['district'], 'i');
                            $sql = " AND district_id = {$params['district']}";
                        }                    
                        if($_POST['town']) {
                            $params['town'] = clearData($_POST['town'], 'i');
                            $sql = " AND town_id = {$params['town']}";
                        }                    
                        if($_POST['microDistrict']) {
                            $params['microDistrict'] = clearData($_POST['microDistrict'], 'i');
                            $sql = " AND microDistrict_id = {$params['microDistrict']}";
                        }            
                        
                        $query = "SELECT id FROM `$table` WHERE `name` LIKE '{$t[2]}%' $sql ";     
                        $tid = $db->getValue($query);
                        
                        if($tid) { 
                            
                            $vid = $db->getValue("SELECT id FROM siteParamsValue WHERE tableValue_id = $tid AND siteParam_id = $pid AND parent_id = $parentId ");
                            
                            if(!$vid) {
                                $db->query("INSERT INTO siteParamsValue SET parent_id = $parentId, tableValue_id = $tid, siteParam_id = $pid, `value` = '{$t[1]}', `name` = '{$t[0]}' ");
                            } elseif($vid) {
                                $db->query("UPDATE siteParamsValue SET parent_id = $parentId, `value` = '{$t[1]}', `name` = '{$t[0]}' WHERE id = $vid ");
                            }
     
                        }
                    }
                }                
            
        } else { //pre($_POST);
            foreach($_POST AS $k => $v) { 
                if(is_array($v) && $v[0]) { 

                    $t = array();

                    if(stripos($v[0], "|") !== FALSE) {
                        $t = explode("|", clearData($v[0], 'ss'));
                    } elseif(stripos($v[0], "<option") !== FALSE) {
                        $t[0] = strip_tags($v[0]); 
                        $t[1] = cut_str($v[0], 'value="', '"');
                    } else {
                        $t[0] = clearData($v[0], 'ss'); 
                        $t[1] = clearData($v[0], 'ss'); 
                    }          

                    if($v[3] == 'add' && $t[0] && $t[1] != '' && $v[0] && $v[0] != '-') {                    
                        $db->query("INSERT INTO siteParamsValue SET parent_id = $parentId, tableValue_id = {$v[1]}, siteParam_id = $pid, `value` = '{$t[1]}', `name` = '{$t[0]}' ");
                    } elseif($v[3] == 'edit' && $v[2] && $v[0] && $v[0] != '-' && !empty($t)) {
                        $db->query("UPDATE siteParamsValue SET parent_id = $parentId, siteParam_id = $pid, `value` = '{$t[1]}', `name` = '{$t[0]}' WHERE id = {$v[2]} ");
                    } elseif($v[3] == 'edit' && $v[2] && $v[0] == '-') {
                        $db->query("UPDATE siteParamsValue SET `value` = '', `name` = '' WHERE id = {$v[2]} ");
                    }
                }
            }
        }
    }
    
    if($_POST['site']) {       
        
        $params['cSite'] = clearData($_POST['site'], 'i');
        
        foreach($_POST AS $k => $v) {
            if(is_array($v)) { 
                if($v[3] == 'add' && $v[0]) {
                    $db->query("INSERT INTO siteParams SET our_id = {$v[1]}, site_id = {$params['cSite']}, `var` = '{$v[0]}'");
                } elseif($v[3] == 'edit' && $v[2]) {
                    $db->query("UPDATE siteParams SET `var` = '{$v[0]}' WHERE id = {$v[2]} AND site_id = {$params['cSite']}");
                }
            }
        }
    }
    
    if($_POST['our_data']) {
        
        if($_POST['del_street'] == 1 && $_POST['region']) {
            $db->query("DELETE FROM street WHERE rgion_id = ".$_POST['region']);
        } elseif($_POST['del_street'] == 2) {
            $db->query("DELETE FROM street WHERE id = ".$_POST['street']);
        }
        
        if($_POST['del_micro'] == 1 && $_POST['town']) {
            $db->query("DELETE FROM microDistrict WHERE town_id = ".$_POST['town']);
        } elseif($_POST['del_micro'] == 2) {
            $db->query("DELETE FROM microDistrict WHERE id = ".$_POST['microDistrict']);
        }
        
        if($_POST['del_town'] == 1 && $_POST['district']) {
            $db->query("DELETE FROM town WHERE district_id = ".$_POST['district']);
        } elseif($_POST['del_town'] == 2) {
            $db->query("DELETE FROM town WHERE id = ".$_POST['town']);
        }
        
        if($_POST['del_district'] == 1 && $_POST['region']) {
            $db->query("DELETE FROM district WHERE region_id = ".$_POST['region']);
        } elseif($_POST['del_district'] == 2) {
            $db->query("DELETE FROM district WHERE id = ".$_POST['district']);
        }
        
        // микрорайон
        if($_POST['town'] && $_POST['new_microDistrict']) {
            $did = clearData($_POST['town'], 'i');
            $town = explode("\n", $_POST['new_microDistrict']);
            
            foreach ($town AS $k => $v) {
                if($v) {
                    $db->query("INSERT INTO microDistrict SET town_id = $did, `name` = '$v' ");
                }
            }
        }
        
        // НП 2
        if($_POST['district'] && $_POST['new_town']) {
            $did = clearData($_POST['district'], 'i');
            $town = explode("\n", $_POST['new_town']);
            
            foreach ($town AS $k => $v) {
                if($v) {
                    $db->query("INSERT INTO town SET district_id = $did, `name` = '$v' ");
                }
            }
        }
        
        // НП 1
        if($_POST['new_district'] && $_POST['region']) {
            $did = clearData($_POST['region'], 'i');
            $town = explode("\n", $_POST['new_district']);
            
            foreach ($town AS $k => $v) {
                if($v) {
                    $db->query("INSERT INTO district SET region_id = $did, `name` = '$v' ");
                }
            }
        }
        
    }
}

switch (_WHAT_) {
    case 'site':
        
            $params['data'] = $db->get_all_rows("SELECT * FROM site");
        
        break;
    case 'data_link':
        
            $pid = $params['pid'] = clearData($_GET['pid'], 'i');
            $params['site_id'] = $site_id = $db->getValue("SELECT site_id FROM siteParams WHERE id = $pid ");
            $params['parentId'] = clearData($_POST['parentId'], 'i');
            
            if($_POST['createDataSets']) {
                $pid = $params['cpid'] = clearData($_POST['cpid'], 'i');                                      
                $params['pid'] = $pid = $db->getValue("SELECT id FROM siteParams WHERE site_id = $site_id AND our_id = $pid ");
                $params['labelParent'] = array_shift(explode("|", $_POST['parentName']));
                $params['parentId'] = clearData(array_pop(explode("|", $_POST['parentName'])), 'i');
            }
            
            if($pid) {
                $query = "SELECT DISTINCT s.var AS svar, s.our_id, o.var AS ovar, o.label "
                        . "FROM siteParams AS s "
                        . "INNER JOIN ourParams AS o ON s.our_id = o.id AND s.id = $pid ";
                $params['data'] = $db->get_row($db->query($query));
                
                if(_TYPE_ == 'auto' && $params['data']['our_id']) { 
            
                    if($_POST['region']) {
                        $params['region'] = clearData($_POST['region'], 'i');
                        $sql = " WHERE t.region_id = {$params['region']} ";
                    }                    
                    if($_POST['district']) {
                        $params['district'] = clearData($_POST['district'], 'i');
                        $sql = " WHERE t.district_id = {$params['district']}";
                    }                    
                    if($_POST['town']) {
                        $params['town'] = clearData($_POST['town'], 'i');
                        $sql = " WHERE t.town_id = {$params['town']}";
                    }                    
                    if($_POST['microDistrict']) {
                        $params['microDistrict'] = clearData($_POST['microDistrict'], 'i');
                        $sql = " WHERE t.microDistrict_id = {$params['microDistrict']}";
                    }                    
                } 
                if(!$sql) {
                    $sql2 = " LIMIT 0, 50 ";
                }
                
                if(!$params['cpid']) {
                    $query = "SELECT id, `label` FROM ourParams WHERE type1 = 1";
                    $params['datasets'] = $db->get_all_rows($query);
                }
                
                $queryData = "SELECT DISTINCT s.name AS vname, s.id AS sid, (SELECT name FROM siteParamsValue WHERE id = s.parent_id) AS parentName "
                        . "FROM siteParamsValue AS s WHERE s.id IN (SELECT DISTINCT parent_id FROM siteParamsValue WHERE siteParam_id = $pid AND parent_id > 0)";    
                $params['loadDatasets'] = $db->get_all_rows($queryData);
                
                //pre($params['loadDatasets']); exit;
                
                $query = "SELECT DISTINCT t.id, t.name, s.name AS vname, s.id AS sid, s.value "
                        . "FROM ".array_shift(explode("_", $params['data']['ovar']))." AS t "                        
                        . "LEFT JOIN siteParamsValue AS s ON t.id = s.tableValue_id AND s.siteParam_id = $pid AND parent_id = {$params['parentId']} "
                        . " $sql "
                        . "ORDER BY t.name ASC $sql2 ";
   
                $params['data']['data'] = $db->get_all_rows($query);
                
            }
            
            $query = "SELECT id, `name` FROM region WHERE country_id = 1  ORDER BY `name`";
            $params['region_data'] = $db->get_all_rows($query);
            
        break;
    
    case 'site_data':
     
        if($params['cSite']) {
            $query = "SELECT s.id AS pid, o.id AS oid, `o`.`var`, `o`.`label`, s.var AS svar, o.type2, o.min_value "
                    . "FROM ourParams AS o "
                    . "LEFT JOIN siteParams AS s ON o.id = s.our_id AND s.site_id = {$params['cSite']} ";
            
            $params['ourParams'] = $db->get_all_rows($query);
        }
        
            $query = "SELECT id, `name` FROM site";
            $params['site'] = $db->get_all_rows($query);
            
        break;
    
    case 'our_data':
            
            $query = "SELECT id, `name` FROM region WHERE country_id = 1  ORDER BY `name`";
            $params['region_data'] = $db->get_all_rows($query);

        break;

    default:
        break;
}

?>
