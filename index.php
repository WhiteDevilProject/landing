<?php
    header('Content-Type: text/css; charset=utf-8');
	
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/db.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/class.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/send.inc.php';
    
    $db = new db;
    $db->dbConn();
    $db->setCode();
    
    $id = new main;
    $data = $id->get_array_first_data();
    
    switch($data['type']){
        case "zhk":
            $h1 = "Жилой комплекс";
            $h2 = "О жилом комплексе";
            //Перенести в БД
            $h3 = "квартир</br> и апартаментов";
            $h5 = "комплексе";
            $img = [
                "icon1" => "metro-icon.png",
                "icon2" => "walking-icon.png"
            ];
            $plans = $id->give_lauout_html();
        break;
        case "kp":
            $h1 = "Коттеджный поселок";
            $h2 = "О коттеджном поселке";
            //Перенести в БД
            $h3 = "домовладений";
            $h5 = "поселке";
            $img = [
                "icon1" => "location.png",
                "icon2" => "car.png"
            ];
            $plans = $id->give_project_html();
        break;
    }
    
    $coord = explode(",",$data['coord']);

    
    if(!$_GET['url']){
        $title = $data['title'];
        $desc = $data['desc'];
        $keys = $data['keys'];
        $text = $data['first_text'];
        $f_h1 = "<span>".$data['first_h1']."</span>";
        
        
    }else{
        $urlov = $id->giva_url_data($_GET['url']);
        
        $title = $urlov['title'];
        $desc = $urlov['desc'];
        $keys = $urlov['keys'];
        $text = $urlov['text'];
        $f_h1 = "<span>".$urlov['h1']."</span>";
    }
    
    $link = $id->give_me_url_html($_GET['url']);
    

    
    $id->generate_css_style();
    
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta property="og:title" content="<?php echo $title?>"/>
        <meta property="og:description" content="<?php echo $desc?>"/>
        <meta property="og:image" content="<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['fir_ground']?>)"/>
        <meta property="og:url" content= "<?php echo $_SERVER['SERVER_NAME']?>" />
        <meta property="og:type" content="website" />
        <meta property="og:video" content="https://www.youtube.com/embed/<?php echo $data['link_video']?>?rel=0&autoplay=1" />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="fonts/fonts.css"/>
        <link rel="stylesheet" type="text/css" href="css/icons.css"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery.scrollbar.css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery.formstyler.css"/>
        <link rel="stylesheet" type="text/css" href="css/animate.css"/>
        <link rel="stylesheet" type="text/css" href="css/pace.css"/>
        <link href="http://code.google.com/apis/maps/documentation/javascript/examples/standard.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/slick.css"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        
        <link rel="stylesheet" type="text/css" href="css/style_php.css"/>
        
        <link href="favicon.ico" rel="shortcut icon">
        <meta name="description" content="<?php echo $desc?>">
        <meta name="keywords" content="<?php echo $keys?>">

        <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/waypoints.min.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" src="js/jquery.scrollbar.js"></script>
        <script type="text/javascript" src="js/jquery.formstyler.js"></script>
        <script type="text/javascript" src="js/jquery.animateNumber.min.js"></script>
        <script type="text/javascript" src="js/wow.min.js"></script>
        <script type="text/javascript" src="js/pace.min.js"></script>
        <script type="text/javascript" src="js/slick.js"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjx3LWQ28f7HWH-_XxjLiKDFYRo9Mf83k&libraries=places,visualization" type="text/javascript"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/map.js"></script>

        <title><?php echo $title?></title>
        <script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
    </head>
    <body class="overflow">
        <div class="wrapper">
            <a href="javascript:void(0)" data-scroll=".wrapper" class="scroll up-link visible"></a>
            <div class="main-nav fixed-nav">
                <div class="container">
                    <div class="custom-wrap clearfix">
                        <div class="nav-bars hidden-lg hidden-md hidden-sm">
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                        </div>
                        <ul class="justify-wrap mobile-menu">
                            <li>
                                <a href="javascript:void(0)" class="scroll" data-scroll=".about">
                                    О <?php echo $h5?>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="scroll" data-scroll=".photo">
                                    Фотогалерея
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="scroll" data-scroll=".plans">
                                    Планировки
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="scroll" data-scroll=".location">
                                    Расположение
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="scroll" data-scroll=".contacts">
                                    Контакты
                                </a>
                            </li>
                            <li>
                                <a href="#order-modal"
                                   data-title="Заказать звонок"
                                   data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                                   data-btn="Заказать звонок"
                                        class="custom-modal-open order-link">
                                    <?php echo "+7 (495) ".$data['phone']?>
                                </a>
                            </li>
                        </ul>
                        <a href="#order-modal"
                           data-title="Заказать звонок"
                           data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                           data-btn="Заказать звонок"
                           class="custom-modal-open mobile-phone pull-right order-link hidden-lg hidden-md hidden-sm">
                            <?php echo "+7 (495) ".$data['phone']?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="promo section full-section" style="background-image: url(<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['fir_ground']?>)">
                <div class="container">
                    <div class="promo-content">
                        <div class="promo-title">
                            <h1>
                                <?php
                                    if(empty($_GET['url'])){
                                        echo $h1;
                                        echo $f_h1;
                                    }else{
                                        echo $f_h1;
                                    }
                                ?>
                            </h1>
                        </div>
                        <h2 class="promo-subtitle">
                            <?php echo $text?>
                        </h2>
                        <noindex>
                        <div class="actions-wrap text-center">
                            <a href="#order-modal"
                               onclick="yaCounter<?php echo $data['counter']?>.reachGoal('download'); return true;"
                               data-title="Записаться на просмотр"
                               data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                               data-btn="Записаться на просмотр"
                               class="custom-btn decor-btn custom-modal-open order-link">
                                Записаться на просмотр
                            </a>
                        </div>
                        </noindex>
                    </div>
                </div>
                <div class="main-nav">
                    <div class="container">
                        <div class="custom-wrap clearfix">
                            <div class="nav-bars hidden-lg hidden-md hidden-sm">
                                <div class="bar"></div>
                                <div class="bar"></div>
                                <div class="bar"></div>
                            </div>
                            <a href="javascript:void(0)" class="close-nav hidden-lg hidden-sm hidden-md"></a>
                            <ul class="justify-wrap mobile-menu">
                                <li>
                                    <a href="javascript:void(0)" class="scroll" data-scroll=".about">
                                        О <?php echo $h5?>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="scroll" data-scroll=".photo">
                                        Фотогалерея
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="scroll" data-scroll=".plans">
                                        Планировки
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="scroll" data-scroll=".location">
                                        Расположение
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="scroll" data-scroll=".contacts">
                                        Контакты
                                    </a>
                                </li>
                                <li>
                                    <a href="#order-modal"
                                       data-title="Заказать звонок"
                                       data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                                       data-btn="Заказать звонок"
                                       class="custom-modal-open order-link">
                                        <?php echo "+7 (495) ".$data['phone']?>
                                    </a>
                                </li>
                            </ul>
                            <a href="#order-modal"
                               data-title="Заказать звонок"
                               data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                               data-btn="Заказать звонок"
                               class="custom-modal-open mobile-phone pull-right order-link hidden-lg hidden-md hidden-sm">
                                <?php echo "+7 (495) ".$data['phone']?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info">
                <div class="container">
                    <div class="info-content">
                        <div class="custom-wrap">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-value animate-number" data-numb="<?php echo $data['param_first']?>">
                                            0
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        <?php echo $h3?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-item-img">
                                            <img src="images/elements/<?php echo $img['icon1']?>" alt="Картинка метро" ">
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        <?php echo $data['param_second']?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-item-img">
                                            <img src="images/elements/<?php echo $img['icon2']?>" alt="Общая удаленность"/>
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        <?php echo $data['param_third']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about" style="background-image: url(<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['sec_ground']?>)">
                <div class="container">
                    <div class="about-content">
                        <div class="title">
                            <h2>
                                <?php echo $h2?><br>
                                <?php echo $data['first_h1']?>
                            </h2>
                        </div>
                        <div class="custom-text">
                            <?php echo $data['sec_text']?>
                        </div>
                    </div>
                    <div class="about-img-wrap">
                        <img src="<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['sec_img_left']?>" class="about-img-1" alt="<?php echo $h2." ".$data['first_h1']?>. Общие виды. Картинка 1." />
                        <img src="<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['sec_img_center']?>" class="about-img-2" alt="<?php echo $h2." ".$data['first_h1']?>. Общие виды. Картинка 2." />
                    </div>
                    <img src="<?php echo $id->dir.$data['pos_id']?>/first/<?php echo $data['sec_img_right']?>" class="about-img-3" alt="<?php echo $h2." ".$data['first_h1']?>. Общие виды. Картинка 3." />
                </div>
            </div>

            <?php echo $plans?>
            
            <div class="photo">
                <div class="slide-nav slide-left"></div>
                <div class="slide-nav slide-right"></div>
                <div class="photo-slider">
                    <?php
                        echo $id->give_img_gallery();
                    ?>
                    <!--<div class="photo-item">
                        <img src="images/content/ph-1.jpg">
                    </div>-->
                </div>
            </div>
            <div class="info info-2">
                <div class="container">
                    <div class="info-content">
                        <div class="custom-wrap">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-value">
                                            <span class="animate-number" data-numb="13.5">0</span>%
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        ипотека
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-value">
                                            <span class="animate-number" data-numb="30">30</span> лет
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        рассрочка
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 info-item">
                                    <div class="info-item-main">
                                        <div class="info-value">
                                            <span class="animate-number" data-numb="20">20</span>%
                                        </div>
                                    </div>
                                    <div class="info-item-title">
                                        первоначальный<br>
                                        взнос
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="infra">
                <div class="infra-slider">
                    <?php echo $id->give_infrastructure(); ?>
                    
                </div>
            </div>
            <div class="location">
                <div class="location-header">
                    <div class="container">
                        <div class="title">
                            <h2><?php echo $data['header_loc']?></h2>
                        </div>
                    </div>
                </div>
                <div class="custom-map">
                    <div id="map" data-mode="card" data-x="<?php echo $coord['1']?>" data-y="<?php echo $coord['0']?>"></div>

                    <div class="map-controls">
                        <a href="javascript:void(0)" class="map-out"></a>
                        <a href="javascript:void(0)" class="map-in"></a>
                    </div>
                    <div class="map-infra">
                        <div class="map-infra-label">
                            Инфраструктура
                        </div>
                        <div class="map-infra-list">
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="school">
                                    <span class="checkbox-span">Школа / Дет. сад</span>
                                </label>
                            </div>
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="gym">
                                    <span class="checkbox-span">Спорт / Фитнес</span>
                                </label>
                            </div>
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="hospital">
                                    <span class="checkbox-span">Мед. Учреждения</span>
                                </label>
                            </div>
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="cafe">
                                    <span class="checkbox-span">Кафе</span>
                                </label>
                            </div>
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="restaurant">
                                    <span class="checkbox-span">Ресторан</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="map-loader">
                        <div class="cssload-inner cssload-one"></div>
                        <div class="cssload-inner cssload-two"></div>
                        <div class="cssload-inner cssload-three"></div>
                    </div>
                </div>
            </div>
            <?php 
                if(!empty($data['link_video'])){
                    echo "
                        <div class=\"video full-section section\" style=\"background-image: url(".$id->dir.$data['pos_id']."/first/".$data['video_back'].")\">
                            <div class=\"container\">
                                <div class=\"video-content\">
                                    <h2 class=\"custom-title\">
                                        Видеоролик про<br>
                                        ".$h1."
                                    </h2>
                                    <div class=\"actions-wrap text-center\">
                                            <a href=\"#video-modal\" data-video=\"https://www.youtube.com/embed/".$data['link_video']."?rel=0&autoplay=1\" class=\"custom-btn decor-btn video-link custom-modal-open\" onclick=\"yaCounter".$data['counter'].".reachGoal('watch_video'); return true;\">
                                            Смотреть
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";
                }
            ?>
            <div class="feedback">
                <div class="container">
                    <div class="title">
                        У вас есть вопросы?
                    </div>
                    <div class="custom-form">
                        <!--noindex-->
                        <form method="post" action="/send.php">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-field">
                                        <input type="text" name="name">
                                        <div class="form-label">
                                            Ваше имя:
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-field">
                                        <input type="text" name="phone">
                                        <div class="form-label">
                                            Телефон:
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-field">
                                        <input type="text" name="email">
                                        <input type="hidden" name="send_form" value="send">
                                        <input type="hidden" name="domen" value="<?php echo $_SERVER['SERVER_NAME']?>">
                                        <div class="form-label">
                                            Email:
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="recaptcha-wrap">
                                <div id="recaptcha_3"></div>
                            </div>
                            <!--<div class="g-recaptcha" data-sitekey="6LdkFxkUAAAAANpzjSR7I-leMTcgGI6iYKdrGbdN"></div>-->
                            <div class="form-error"></div>

                            <div class="actions-wrap text-center">
                                <input type="hidden" name="send_form" value="send">
                                <input type="hidden" name="domen" value="<?php echo $_SERVER['SERVER_NAME']?>">
                                <button type="submit" class="custom-btn decor-btn" onclick="yaCounter<?php echo $data['counter']?>.reachGoal('send_za'); return true;">
                                    Отправить
                                </button>
                            </div>

                        </form>
                        <!--/noindex-->
                    </div>
                    <div class="contacts">
                        <!--noindex-->
                        <div class="contacts-phone">
                            <a href="#order-modal"
                               data-title="Заказать звонок"
                               data-subtitle="Заполните форму и мы свяжемся с Вами в течении 15 минут"
                               data-btn="Заказать звонок" class="custom-modal-open order-link">
                                <span class="circle">495</span>
                                <?php echo $data['phone']?>
                            </a>
                        </div>
                        <!--/noindex-->
                        <div class="work-time">
                            ежедневно с 10:00 до 20:00
                        </div>
                        <div class="address-wrap">
                            <div class="contacts-address">
                                <?php echo $data['addr']?>
                            </div>
                        </div>
                        <!--noindex-->
                        <div class="contacts-email">
                            <a href="mailto:<?php echo $data['email']?>"><?php echo $data['email']?></a>
                        </div>
                        <!--/noindex-->
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="container">
                <div class="footer-nav">
                    <ul>
                        <?php echo $link;?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hidden">
            <div id="video-modal" class="custom-modal-video">
                <a href="javascript:void(0)" class="custom-modal-close"></a>
                <div class="video-modal-content">

                </div>
            </div>
            <div id="thanks-modal" class="custom-modal">
                <a href="javascript:void(0)" class="custom-modal-close"></a>
                <div class="thanks-modal-content">
                    <div class="custom-modal-title">
                        Спасибо за заявку!
                    </div>
                    <div class="custom-modal-subtitle">
                        Мы свяжемся с Вами в течении 15 минут
                    </div>
                </div>
            </div>
            <!--noindex-->
            <div id="order-modal" class="custom-modal">
                <a href="javascript:void(0)" class="custom-modal-close"></a>
                <div class="custom-modal-title">
                    Выслать все планировки?
                </div>
                <div class="custom-modal-subtitle">
                    Заполните форму и мы свяжемся с Вами в течении 15 минут
                </div>
                <div class="custom-form">
                    <form method="post" action="/send.php">
                        <div class="form-field">
                            <input type="text" name="name">
                            <div class="form-label">
                                Ваше имя:
                            </div>
                        </div>
                        <div class="form-field">
                            <input type="text" name="phone">
                            
                            <div class="form-label">
                                Телефон:
                            </div>
                        </div>
                        <div class="form-field">
                            <div class="recaptcha-wrap">
                                <div id="recaptcha_2"></div>
                            </div>
                            <div class="form-error"></div>

                           <!-- <div class="g-recaptcha" data-sitekey="6LdkFxkUAAAAANpzjSR7I-leMTcgGI6iYKdrGbdN"></div>-->
                        </div>
                        <div class="form-field">
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" checked name="agree">
                                    <span class="checkbox-span">Я согласен с <a href="javascript:void(0)">политикой конфиденциальности</a></span>
                                </label>
                            </div>
                        </div>
                        <div class="actions-wrap text-center">
                            <input type="hidden" name="send_form" value="send">
                            <input type="hidden" name="domen" value="<?php echo $_SERVER['SERVER_NAME']?>">
                            <button type="submit" class="custom-btn custom-btn-small decor-btn"  onclick="yaCounter<?php echo $data['counter']?>.reachGoal('send_za'); return true;">
                                Отправить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/noindex-->
            <!--noindex-->
            <div id="plan-modal" class="custom-modal-wide">
                <a href="javascript:void(0)" class="custom-modal-close"></a>
                <div class="custom-modal-block clearfix">
                    <div class="custom-modal-right pull-right">
                        <img src="images/content/plans/pl-1.jpg" class="img-responsive">
                    </div>
                    <div class="custom-modal-left pull-left">
                        <div class="custom-modal-info">
                            <div class="plan-rooms">
                                4-комнатная квартира
                            </div>
                            <div class="plan-table">
                                <table>
                                    <tr>
                                        <td>
                                            Площадь:
                                        </td>
                                        <td>
                                            <span class="area">110.30 м2</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Цена за м2:
                                        </td>
                                        <td>
                                            <span class="per">330 500 Р</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="plan-price">
                                Цена: от <span>27 652 210 Р</span>
                            </div>
                        </div>
                        <div class="custom-form">
                            <form method="post" action="/send.php">
                                <div class="form-field">
                                    <input type="text" name="name">
                                    <div class="form-label">
                                        Ваше имя:
                                    </div>
                                </div>
                                <div class="form-field">
                                    <input type="text" name="phone">
                                    <div class="form-label">
                                        Телефон:
                                    </div>
                                </div>
                                <div class="form-field">
                                    <div class="recaptcha-wrap">
                                        <div id="recaptcha_1"></div>
                                    </div>
                                    <div class="form-error"></div>
                                    <!--<div class="g-recaptcha" data-sitekey="6LdkFxkUAAAAANpzjSR7I-leMTcgGI6iYKdrGbdN"></div>-->
                                </div>
                                <div class="form-field">
                                    <div class="checkbox-wrap">
                                        <label>
                                            <input type="checkbox" checked name="agree">
                                            <span class="checkbox-span">Я согласен с <a href="javascript:void(0)">политикой конфиденциальности</a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="actions-wrap text-center">
                                    <input type="hidden" name="send_form" value="send">
                                    <input type="hidden" name="domen" value="<?php echo $_SERVER['SERVER_NAME']?>">
                                    <button type="submit" class="custom-btn custom-btn-small decor-btn" onclick="yaCounter<?php echo $data['counter']?>.reachGoal('send_za'); return true;">
                                        Забронировать
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/noindex-->
        </div>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter<?php echo $data['counter']?> = new Ya.Metrika({
                            id:<?php echo $data['counter']?>,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo $data['counter']?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

    </body>
</html>
