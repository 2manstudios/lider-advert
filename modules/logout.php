<?php

set_data('ul', '');
unset($_SESSION['uid']);
header("location: {$_SESSION['url']}"); exit;

?>