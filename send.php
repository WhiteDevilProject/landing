<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/send.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/db.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/class.inc.php';

    $db = new db;
    $db->dbConn();
    $db->setCode();

    $id = new main;
    $data = $id->get_array_first_data();

    if($_POST['send_form']){
        $captcha = "";
        if (isset($_POST["g-recaptcha-response"]))
            $captcha = $_POST["g-recaptcha-response"];

        /*if (!$captcha)
            echo "Подтвердите, что вы не робот";*/
        $secret = $data['captcha_secret'];
        /*var_dump(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]));*/

        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]), true);

        if ($response['success'] !== false) {
            echo "ok";
            new send_mail($_POST);

        } else {
            echo "Подтвердите, что вы не робот";
        }
    }

?>