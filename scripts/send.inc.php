<?php
    class send_mail{

    public $addr = array(
        "pagrudinin@yandex.ru",//Грудинин
        //"be.like.no.other@mail.ru", //Булык
        "1200432@gmail.com", //Киреев
        "avsdos@yandex.ru", //Балашов
        "office@angel-estate.ru"//Офисная почта
        //"eltsova@angel-estate.ru", //Ельцова
        //"8109532@mail.ru",//Ярослав
        //"kolmakova@angel-estate.ru", //Колмакова
        //"ov_larina@mail.ru", //Ларина
        //"filippova@angel-estate.ru", //Филиппова
        //"flora@angel-estate.ru",//Флора
        //"zabolotskih@angel-estate.ru",//Заболотских Влад
        //"vinogradova.z@angel-estate.ru",//Виноградова Жанна
        //"polyakova.a@angel-estate.ru",//Полякова Анна
        //"dk@angel-estate.ru" //Карайя
        );
    public $FROM = 'landing@angel-estate.ru';  //  e-mail ??????????? (?????? ????????? ??????? ??????????? ??????????? e-mail)
    public $REPLY = 'noreplay@angel-estate.ru';   //  e-mail ??? ?????? 
    public $PRIORITY = false; 
    public $data;
    public $url_crm = "http://194.58.93.233/modules/m_angel.php";
   

    public function stripinput($_sText) {
        if (ini_get('magic_quotes_gpc'))
            $_sText = stripslashes($_sText);
        $search = array("\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
        $replace = array("&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
        $_sText = str_replace($search, $replace, $_sText);
        return $_sText;
    }

    public function sendmail($_sSubject, $_sMessage, $_sEmail, $_sFrom, $_sReply, $_bPriority = false) {
        $subject = "=?utf-8?b?" . base64_encode($_sSubject) . "?=";
        $headers = "From: $_sFrom\r\n";
        $headers .= "Reply-To: $_sReply\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        if ($_bPriority) {
            $headers .= "X-Priority: 1 (Highest)\n";
            $headers .= "X-MSMail-Priority: High\n";
            $headers .= "Importance: High\n";
        }
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        
        return mail($_sEmail, $subject, $_sMessage, $headers);
    }

    public function get_new($post) {
        
       $this->data['table'] = "
                <table> 
                    <tr>
                        <th>Дата</th>
                        <th>Сайт</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Email</th>
                    </tr>
                    <tr>
                        <td>".  date("d-m-Y", time())."</td>
                        <td>".$post['domen']."</td>
                        <td>".$post['name']."</td>
                        <td>".$post['phone']."</td>
                        <td>".$post['email']."</td>
                    </tr>
                </table>
           ";
       
        $this->data['data'] = array(
                    "ct_source" => "site.landing.zayavka",
                    "site" => $post['domen'],
                    "type" => "Заявка с сайта",
                    "name" => $post['name'],
                    "tel" => $post['phone'],
                    "email" => $post['email']
                );
        
    }
    
    public function send_crm_data(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url_crm);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data['data']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);  
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //$server_output = curl_exec ($ch);
        $output = curl_exec($ch);   
        /*if ($output === FALSE) {      
            echo "cURL Error: " . curl_error($ch);    
            return;    
        }    
        print_r($output);  */
        curl_close($ch);  
    }
    
    
    public function render($_sBody) {
        return '<html>
        <head>
        <style type="text/css">
        body {margin:10px;background:#ffffff;color:#000000;font-size:10pt;font-family:Tahoma}
        div {font-size:10pt;font-family:Tahoma}
        .header {padding-bottom:20px}
        a {color: #003399!important;text-decoration:underline;}
        </style>
        </head>
        <body>
        ' . $_sBody . '
        </body>
        </html>';
    }
    
   
    public function __construct($post) {
            $this->get_new($post);
            $this->send_crm_data();
            
            foreach ($this->addr as $k => $v) {
                $this->sendmail("Заявка с сайта - ".$post['domen']."!", $this->render($this->data['table']), $v, $this->FROM, $this->REPLAY);
                sleep(1);
            }
    }
    
    

}