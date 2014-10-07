<?php

    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                
        $email = clearData($_POST['email'], 'ss');
        $phone = clearData($_POST['phone'], 'ss');

        if (check_email($email) && !check_email2($email) && check_phone($phone)) {            
           
            $pass = clearData($_POST['pass'], 'sf');  
            $name = clearData($_POST['name'], 'ss');              
            
            $db->query("INSERT INTO user SET email = '$email', pass_hex = '".md5($pass)."', pass = '$pass', newsletter = 1, name = '$name', phone = '$phone' ");            
            $id = $db->insert_id();            
            set_data('ul', hash('md5', $id."|".$db->getValue("SELECT dt_add FROM user WHERE id = $id")));
            $_SESSION['uid'] = base64_encode($id);
            
            global $main_email, $main_pib, $email_send;    
        
            // Отправляем нам на почту
           $params = array(                
               'from_email' => _MAIN_EMAIL_,
               'from_pib' => _MAIN_PIB_,
               'to_email' => $email,
               'to_pib' => $name,
               'subject' => "Advert - Активация учетной записи!",
               'text' => "Плздравляем с регистрацией"
           );

            // отправляем наше письмо 
            sendEmail($params);
            
            header("location: {$_SESSION['url']}"); exit;
            
        }
    }
    
?>
