<?php

    header("Content-Type: text/html; charset=utf-8");

class main{
    public $dir = "http://cleangov.ru/new_site/images/";
    
    //Получаем ID поселка из файла
    public function get_txt_id(){
        $id = file('id.txt');
        return $id[0];
    }
    
    //Готовим массив данных для главной страницы
    public function get_array_first_data(){
        $sql = mysql_query("SELECT * FROM `first_config` WHERE `pos_id`='".$this->get_txt_id()."' LIMIT 1");
        
        if((bool) mysql_num_rows($sql) == true){
            return mysql_fetch_assoc($sql);
        }
    }
    
    public function give_alt_title(){
        $id = $this->get_txt_id();
        
        $sql = mysql_query("SELECT `first_h1` FROM `first_config` WHERE `pos_id`='".$id."'");
        
        return mysql_fetch_assoc($sql);
    }
    
    public function give_img_gallery(){
        $h1 = $this->give_alt_title();
        $url = $this->dir."read_dir.php";
        //$url_ch = $this->dir.$this->get_txt_id()."/galereya/";
        $url_ch = "../../new_site/images/".$this->get_txt_id()."/galereya/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "url=".$url_ch);

        $data = curl_exec($ch);

        $i = 1;

        foreach(json_decode($data) as $key){
            $gal .= "
                <div class=\"photo-item\">
                    <img src=\"".$this->dir.$this->get_txt_id()."/galereya/".$key."\" alt=\"Галерея жилого комплекса ".$h1['first_h1'].", фотография ".$i."\">
                </div>";
            $i++;
        }
        curl_close($ch);

        return $gal;
    }
    
    public function give_infrastructure(){
        $id = $this->get_txt_id();
        $sql = mysql_query("SELECT * FROM `infrastructure_".$id."`");
        
        while($row = mysql_fetch_assoc($sql)){
            $inf .= "
                <div class=\"infra-item full-section\" style=\"background-image: url(".$this->dir.$id."/infrastructure/".$row['photo'].")\">
                        <div class=\"container\">
                            <div class=\"infra-item-content active\">
                                <div class=\"title\">
                                    <h2>
                                        Инфраструктура
                                    </h2>
                                </div>
                                <div class=\"infra-item-title\">
                                    ".$row['h1']."
                                </div>
                                <div class=\"infra-item-descr\">
                                    ".$row['text']."
                                </div>
                            </div>
                        </div>
                    </div>
                ";
        }
        
        return $inf;
        
    }
   
    public function give_layout_array(){
        $id = $this->get_txt_id();
        
        $sql = mysql_query("SELECT * FROM `layout_".$id."` ORDER BY  `room` ASC");
        
        while($row = mysql_fetch_assoc($sql)){
            $layout["room"][] = $row['room'];
            $layout["db"][] = array(
                    "id" => $row['id'],
                    "room" => $row['room'],
                    "price" => $row['price'],
                    "area" => $row['area'],
                    "photo" => $row['photo'],
                    "name" => $row['name']
                    );
        }
        
        return $layout;
    }

    public function give_project_html(){
        $layout = $this->give_layout_array();

        foreach($layout['db'] as $k){
            $dir = $this->dir.$this->get_txt_id()."/layout/".$k['photo'];
            $price = number_format($k['price'],0,'',' ');

            $plans_slider .= "
                
                            <div class=\"plans-main-item\">
                                <img src=\"".$dir."\">
                                <div class=\"plans-main-title\">
                                    ".$k['name']."
                                </div>
                                <div class=\"plans-main-content\">
                                    <div class=\"plans-main-block\">
                                        <div class=\"plans-main-info\">
                                            площадь ".$k['area']." кв.м.
                                        </div>
                                        <div class=\"plans-main-info\">
                                            стоимость от ~".$price." рублей
                                        </div>
                                        <div class=\"actions-wrap text-center\">
                                            <a href=\"#plan-modal\"
                                               data-title=\"".$k['name']."\"
                                               data-area=\"".$k['area']." кв.м.\"
                                               data-per=\"".number_format(ceil($k['price']/$k['area']),0,'',' ')." P\"
                                               data-price=\"".$price."\"
                                               data-img=\"images/content/plans/pl-1.jpg\"
                                               class=\"custom-modal-open custom-btn custom-btn-small plans-link\">
                                                Прислать планировку
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                ";


        }

        $str = "
                <div class=\"plans\">
                    <div class=\"container\">
                        <div class=\"title\">
                            <h2>Проекты коттеджей</h2>
                        </div>
                        <div class=\"plans-content\">
                            <div class=\"plans-slider-wrap\">
                                <div class=\"slide-nav slide-left\"></div>
                                <div class=\"slide-nav slide-right\"></div>
                                    <div class=\"plans-slider\">
                                        ".$plans_slider."
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        ";

        return $str;
    }

    public function give_lauout_html(){
        $h1 = $this->give_alt_title();
        $layout = $this->give_layout_array();
        $data = $this->get_array_first_data();
        
        foreach(array_unique($layout['room']) as $key){
            $room_filter .= "<a href=\"javascript:void(0)\" data-switch=\"".$key."\" class=\"room-switch\">
                                        ".$key."
                                    </a>";
        }
        
        
        
        foreach($layout['db'] as $k){
            $dir = $this->dir.$this->get_txt_id()."/layout/".$k['photo'];
            $price = number_format($k['price'],0,'',' ');
            $plan_prevs .= "<div data-id=\"".$k['id']."\" data-rooms=\"".$k['room']."\" class=\"active col-lg-4 col-md-4 col-sm-2 col-xs-2 plans-item-block\">
                                <div class=\"plans-item\">
                                    <img src=\"".$dir."\" class=\"img-responsive\">
                                </div>
                            </div>";
            
            $plans_slider .= "
                <div data-id=\"".$k['id']."\" class=\"plans-main-item\" data-rooms=\"".$k['room']."\">
                                            <img src=\"".$dir."\" alt=\"Планировки в жилом комплексе ".$h1['first_h1'].".\" />
                                            <div class=\"plans-main-content\">
                                                <div class=\"plans-main-block\">
                                                    <div class=\"plans-main-info\">
                                                        ".$k['room']."-комнатная квартира
                                                    </div>
                                                    <div class=\"plans-main-info\">
                                                        площадь ".$k['area']." кв.м.
                                                    </div>
                                                    <div class=\"plans-main-info\">
                                                        стоимость от ".$price." рублей
                                                    </div>
                                                    <noindex>
                                                    <div class=\"actions-wrap text-center\">
                                                        <a href=\"#plan-modal\"
                                                           onclick=\"yaCounter".$data['counter'].".reachGoal('send_layout'); return true;\"
                                                           data-title=\"".$k['room']."-комнатная квартира\"
                                                           data-area=\"".$k['area']." кв.м.\"
                                                           data-per=\"".number_format(ceil($k['price']/$k['area']),0,'',' ')." P\"
                                                           data-price=\"".$price." P\"
                                                           data-img=\"".$dir."\"
                                                           class=\"custom-modal-open custom-btn custom-btn-small plans-link\">
                                                            Прислать планировку
                                                        </a>
                                                    </div>
                                                    </noindex>
                                                </div>
                                            </div>
                                        </div>
                ";
            
            
        }

        $str = "
            <div class=\"plans\">
                <div class=\"container\">
                    <div class=\"title\">
                        <h2>".$data['header_lay']."</h2>
                    </div>
                    <div class=\"plans-content\">
                        <div class=\"row\">
                            <div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">
                                <div class=\"rooms-filter clearfix\">
                                   ".$room_filter."
                                </div>
                                <div class=\"plan-prevs\">
                                    <div class=\"row\">
                                        ".$plan_prevs."
                                    </div>
                                </div>
                                <noindex>
                                <div class=\"actions-wrap\">
                                    <a href=\"#order-modal\"
                                       onclick=\"yaCounter".$data['counter'].".reachGoal('show_all'); return true;\"
                                       data-title=\"Оставьте заявку на просмотр\"
                                       data-subtitle=\"Заполните форму и мы свяжемся с Вами в течении 15 минут\"
                                       data-btn=\"Отправить\"
                                       class=\"custom-btn custom-modal-open order-link decor-btn trigger-plans\">
                                        Заявка на просмотр
                                    </a>
                                </div>
                                </noindex>

                            </div>
                            <div class=\"col-lg-8 col-md-8 col-sm-12 col-xs-12\">
                                <div class=\"plans-slider-wrap\">
                                    <div class=\"slide-nav slide-left\"></div>
                                    <div class=\"slide-nav slide-right\"></div>
                                    <div class=\"plans-slider\">
                                        ".$plans_slider."
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        ";

        return $str;
    }
    
    public function giva_url_data($url){

        $id = $this->get_txt_id();
        $sql = mysql_query("SELECT * FROM `translinking_".$id."` WHERE `url`='/".$url."'") or die(mysql_error());
        $row = mysql_fetch_assoc($sql);
        $data = array(
            "title" => $row['title'],
            "desc" => $row['desc'],
            "keys" => $row['keys'],
            "h1" => $row['h1'],
            "text" => $row['text']
        );
        return $data;
    }
    
    public function give_me_url_html($url){
        $id = $this->get_txt_id();
        if(empty($url)){
            $sql = mysql_query("SELECT * FROM `translinking_".$id."` LIMIT 3");
            
            while($row = mysql_fetch_assoc($sql)){
                $link .= " <li>
                            <a href=\"".$row['url']."\" target=\"_blank\">".$row['h1']."</a>
                        </li>";
            }
        }else{
            $sqlq = mysql_query("SELECT * FROM `translinking_".$id."` WHERE `id` > (SELECT `id` FROM `translinking_".$id."` WHERE `url`='/".$url."') ORDER BY `id` ASC LIMIT 3") or die(mysql_error());
            
            while($row = mysql_fetch_assoc($sqlq)){
                
                $link .= " <li>
                            <a href=\"".$row['url']."\" target=\"_blank\">".$row['h1']."</a>
                        </li>";
            }
        }
        return $link;
    }
    
    public function give_style_css(){
        $id = file('id.txt');
        
        $sql = mysql_query("SELECT `color`,`color_rgb` FROM `first_config` WHERE `pos_id`='".$id[0]."'") or die(mysql_error());
        $row = mysql_fetch_assoc($sql);
        $style = array(
            "color" => $row['color'],
            "color_rgb" => $row['color_rgb']
        );
        
        return $style;
    }
    
    public function generate_css_style(){
        
        unlink("css/style_php.css");
        
        $file = "css/color-theme.css"; 
        $style = $this->give_style_css();
        $array = file($file);
        $str = "";
        
        /*foreach($array as $key => $value){
            if((bool)strpos($value,"color_theme") === true){
                $str .= str_replace("color_theme", $style['color'], $value); 
            }elseif((bool)strpos($value,"color_link") === true){
                $str .= str_replace("color_link", $style['color_rgb'], $value); 
            }else{
                $str .= $value;
            }
            
        }*/
        
        foreach($array as $key => $value){
                $str .= str_replace("color_link", $style['color_rgb'], str_replace("color_theme", $style['color'], $value));    
        }
        
        file_put_contents("css/style_php.css",$str, FILE_APPEND);
        
    }
    
}