<?php
    header("Content-Type: text/html; charset=utf-8");
class db {//Подключение к базе данных

       public $host = "localhost";       // ?????????
     public $user = "root";       //   ??????
     public $pass= "";       //    ???
     public $db = "new_sait";         //   ??????????? - ??????? ?? ?????????

    /*public $host = "localhost";       // Заполняем
     public $user = "a0130553_site";       //   данные
     public $pass = "5WdvSU9I";       //    для
     public $db = "a0130553_new_site";         //   подключения - Указаны по умолчанию
*/
      /* public function setParam($host=false, $user=false, $pass=false, $db=false) {//Устанавливаем параметры подключения

        if($host == false && $user == false && $pass == false && $db == false){
        $this->host =  "localhost";//   Данные
        $this->user = "root";//         для
        $this->pass = "";//             КОННЕКТА
        $this->db = "moto";//           к БД
        }else{
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db  =  $db;

        }
        } */

    public function dbConn() {//Подключаемся к БД
        mysql_connect($this->host, $this->user, $this->pass) or die(mysql_errno());
        mysql_select_db($this->db) or die(mysql_errno());
    }

    public function dbDest() {//Закрываем соединение с БД
        mysql_close();
    }

    public function setCode() {//Устанавливаем кодировку
        mysql_query("SET character_set_client = 'utf8'") or die(mysql_error());
        mysql_query("SET character_set_connection = 'utf8'") or die(mysql_error());
        mysql_query("SET character_set_results = 'utf8'") or die(mysql_error());
    }

}