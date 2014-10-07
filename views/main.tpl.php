<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="language" content="ru" />
            <title><?php echo _SITE_SLOGAN_." - "._SITE_TITLE_; ?></title>
            <meta name="description" content="<?php echo _SITE_MDESC_; ?>">
            <meta name="keywords" content="<?php echo _SITE_MKEYS_; ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
                
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_URL_; ?>/screen.css" media="screen, projection" />
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_URL_; ?>/print.css" media="print" />
            <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_URL_; ?>/ie.css" media="screen, projection" />
            <![endif]-->
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_URL_; ?>/main.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_URL_; ?>/form.css" />
            <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
            <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300" />
            
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
            <script src="<?php echo _JS_URL_; ?>/my.js" type="text/javascript"/></script>
    </head>

    <body>   
        
        <div class="container" id="page">

            <div id="header">
                <div id="logo">                                   
                </div>
                <div style="float: right;">
                    <?php if(_LOGIN_): ?>
                    <ul>
                        <li><a href="/advert">Создать объявление</a></li>
                        <li><a href="/ads">Кабинет</a></li>
                        <li><a href="/money">Мой счёт</a></li>
                        <li><a href="/id<?php echo base64_decode($_SESSION['uid']); ?>">Мой сайт</a></li>
                        <li><a href="/profile">Профиль</a></li>
                        <li><a href="/logout">Выход</a></li>                           
                    </ul>
                    <?php else: ?>
                    <ul>
                        <li><a href="/login">Вход</a></li>
                        <li><a href="/reg">Регистрация</a></li>                          
                    </ul>
                    <?php endif; ?>
                </div>      
                <a href="./index.php"><div id="ua"></div></a>
            </div><!-- header -->

            <div id="mainmenu">
                    <ul id="yw0">
                        <li class="active"><a href="/">Главная</a></li>
                        <li><a href="/about">О сайте</a></li>
                        <li><a href="/price">Тарифы</a></li>
                        <li><a href="/feedback">Контакты</a></li>
                        <li><a href="/help">Помощь</a></li>
                        <li><a href="/blog">Новости</a></li>
                    </ul>
            </div><!-- mainmenu -->

            <div id="allcontent">
                <div id="main">                    
                    <div id="content">
                        <?php echo $content; ?>
                    </div>
                </div>
                <div id="right">
                </div>
            </div>

            <div class="clear"></div>

            <div id="footer">
                    <?php echo _SITE_TITLE_; ?> &copy; <?php echo date('Y'); ?>
            </div><!-- footer -->

        </div><!-- page -->
        
    </body>
    
</html>