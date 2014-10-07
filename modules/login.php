<?php

    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
        
        $email = clearData($_POST['email'], 'ss');

        if (check_email($email) && check_email2($email)) {            
           
            $pass = md5(clearData($_POST['pass'], 'sf'));  
            $data = $db->super_query("SELECT id, dt_add FROM user WHERE email = '$email' AND pass_hex = '$pass' ", true);            
            
            if(is_array($data) && !empty($data) && $data[0] && $data[1]) { 
                set_data('ul', hash('md5', $data[0]."|".$data[1]));
                $_SESSION['uid'] = base64_encode($data[0]);
                header("location: {$_SESSION['url']}"); exit;
            }
            
        }
    }

?>
