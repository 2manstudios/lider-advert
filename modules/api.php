<?php

switch (_TYPE_) {
    case "district":
            $id = clearData($_GET['id'], 'i');
            $data = $db->get_all_rows("SELECT id, name FROM district WHERE region_id = $id ORDER BY `name`");
                        
            foreach($data AS $k => $v) {
                $option .= "<option value=\"{$v['id']}\">{$v['name']}</option>";
            }
            
            if($option) {
                $option = "<option value=\"0\">-Выберите-</option>".$option;
            } else {
                $option = "<option value=\"0\">-Нету-</option>";
            }
            
            echo $option;
        break;
        
    case "street":
            $id = clearData($_GET['id'], 'i');
            $data = $db->get_all_rows("SELECT id, name FROM street WHERE region_id = $id ORDER BY `name`");
                        
            foreach($data AS $k => $v) {
                $option .= "<option value=\"{$v['id']}\">{$v['name']}</option>";
            }
            
            if($option) {
                $option = "<option value=\"0\">-Выберите-</option>".$option;
            } else {
                $option = "<option value=\"0\">-Нету-</option>";
            }
            
            echo $option;
        break;
        
    case "micro":
            $id = clearData($_GET['id'], 'i');
            $data = $db->get_all_rows("SELECT id, name FROM microDistrict WHERE town_id = $id ORDER BY `name`");
                        
            foreach($data AS $k => $v) {
                $option .= "<option value=\"{$v['id']}\">{$v['name']}</option>";
            }
            
            if($option) {
                $option = "<option value=\"0\">-Выберите-</option>".$option;
            } else {
                $option = "<option value=\"0\">-Нету-</option>";
            }
            
            echo $option;
        break;       
        
    case "town":
            $id = clearData($_GET['id'], 'i');
            $data = $db->get_all_rows("SELECT id, name FROM town WHERE district_id = $id ORDER BY `name`");
                        
            foreach($data AS $k => $v) {
                $option .= "<option value=\"{$v['id']}\">{$v['name']}</option>";
            }
            
            if($option) {
                $option = "<option value=\"0\">-Выберите-</option>".$option;
            } else {
                $option = "<option value=\"0\">-Нету-</option>";
            }
            
            echo $option;
        break;       

    default:
        echo '';
        break;
}

exit;

?>