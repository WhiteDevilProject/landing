var map;
var filtered = false;

jQuery(document).ready(function(){
    var w_h = $(window).height();
    $('.full-section').css('height', w_h + "px");

    $('.scroll').on('click', function(){
        var anchor = $(this).data('scroll');
        $('.mobile-menu, .close-nav').removeClass('active');
        var anchor_link = $(anchor).offset().top;
        $('html, body').stop().animate({
            scrollTop : anchor_link - 65 +  "px"
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

    $('.nav-bars').on('click', function(){
       $('.mobile-menu, .close-nav').addClass('active');
    });

    $('.close-nav').on('click', function(){
        $('.mobile-menu, .close-nav').removeClass('active');
    });

    $(".plan-prevs .row").randomize(".plans-item-block.active");
    $(".plans-item-block:gt(8)").removeClass('active');


    if($('.photo-slider').length){
        $('.photo-slider').slick({
            dots: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 5000,
            infinite: true,
            centerMode: true,
            pauseOnHover: false,
            pauseOnFocus: false,
            variableWidth: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        variableWidth: false,
                        centerPadding: '48px'
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        variableWidth: false,
                        centerPadding: '25px'
                    }
                }
            ]
        });
    }

    if($('.infra-slider').length){
        $('.infra-slider').slick({
            dots: true,
            fade: true,
            arrows: false,
            infinite: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        variableWidth: false
                    }
                }
            ]
        });
    }

    $('.infra-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        $('.infra-item-content').removeClass('active');
    });

    $('.infra-slider').on('afterChange', function(event, slick, currentSlide){
        $('.infra-item-content').addClass('active');
    });

    $('.photo .slide-nav').on('click', function(){
        if($(this).hasClass('slide-left')){
            $('.photo-slider').slick('slickPrev');
        }else{
            $('.photo-slider').slick('slickNext');
        }
    });

    $('.plans-item').on('click', function(){
        var parent = $(this).closest('.plans-item-block');
        var id = parent.data('id');

        var index = 0;
        $('.plans-main-item').each(function () {
            if($(this).data('id') === id){

                if(!$(this).hasClass('slick-cloned')){
                    return false;
                }
            }else{
                if(!$(this).hasClass('slick-cloned')){
                    index++;
                }
            }


        });
        console.log(index);
        $('.plans-slider').slick('slickGoTo', index);
    });

    if($('.plans-slider').length){
        $('.plans-slider').slick({
            dots: false,
            arrows: false,
            infinite: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        variableWidth: false
                    }
                }
            ]
        });
    }

    $('.plans .slide-nav').on('click', function(){
        if($(this).hasClass('slide-left')){
            $('.plans-slider').slick('slickPrev');
        }else{
            $('.plans-slider').slick('slickNext');
        }
    });

    $('.nav-bar').on('click', function(){
        $('.mobile-nav').addClass('active');
    });

    $('.close-nav').on('click', function(){
        $('.mobile-nav').removeClass('active');
    });

    if($('.select-wrap').length){
        $('.select-wrap select').styler();
    }

    $('.decor-btn').each(function(){
        var $this = $(this);
        $this.css('overflow', 'hidden');
        var ink, d, x, y;

        setInterval(function() {
            if($this.find(".ink").length === 0){
                $this.prepend("<span class='ink'></span>");
            }

            ink = $this.find(".ink");
            ink.removeClass("decor");

            if(!ink.height() && !ink.width()){
                d = Math.max($this.outerWidth(), $this.outerHeight());
                ink.css({height: d, width: d});
            }

            x = Math.round(Math.random()*ink.width() - ink.width()/2);
            y = Math.round(Math.random()*ink.height() - ink.height()/2);

            ink.css({top: y+'px', left: x+'px'}).addClass("decor");
        }, 3000)
    });


    $('.room-switch').on('click', function(){
        var filter_str = '';
        $('.plans-item-block').removeClass('active');

        $(this).toggleClass('active');
        $('.room-switch').each(function(){
            if($(this).hasClass('active')){
                if(filter_str !== ''){
                    filter_str += ', [data-rooms="' + $(this).data('switch') + '"]';
                }else{
                    filter_str += '[data-rooms="' + $(this).data('switch') + '"]';
                }
                $('.plans-item-block[data-rooms="' + $(this).data('switch') + '"]').addClass('active');
            }
        });

    /*    $(".plan-prevs .row").randomize(".plans-item-block.active");
        $(".plans-item-block:gt(8)").removeClass('active');*/

        if(filter_str === ''){
            $('.plans-item-block').addClass('active');
            $(".plan-prevs .row").randomize(".plans-item-block.active");
            $(".plans-item-block:gt(8)").removeClass('active');
        }else{
            $(".plan-prevs .row").randomize(".plans-item-block.active");
            if($('.plans-item-block.active').length > 8){
                $(".plans-item-block.active:gt(8)").removeClass('active');
            }
        }

        setTimeout(function(){
            if(filter_str === ''){
                $('.plans-slider').slick('slickUnfilter');
            }else{
                $('.plans-slider').slick('slickUnfilter');
                setTimeout(function(){
                    $('.plans-slider').slick('slickFilter', filter_str);
                }, 100);
            }
        }, 300);



    });

    $('.animate-number').each(function(){
        $(this).waypoint(function() {
            $(this).animateNumber(
                {
                    number: $(this).data('numb')
                },
                1000
            );
        },{
            triggerOnce: true,
            offset: '70%'
        });
    });

    $('[name="phone"]').keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode == 67 && e.ctrlKey === true) ||
            (e.keyCode == 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });



    var wow = new WOW(
        {
            animateClass: 'animated',
            mobile:       false,
            offset:       200,
            callback:     function(box) {
                console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        }
    );
    wow.init();

    Pace.on('hide', function(){
        $('body').removeClass('overflow');
    });

    $('form').submit(function() {
        $(this).isCorrectRequest();
        return false;
    });

    $('.custom-modal-open').fancybox({
        autoSize: true,
        type: 'inline',
        closeBtn: false,
        padding: 0,
        scrolling: 'visible',
        fixed: false,
        autoCenter: false,
        beforeShow: function() {
            $('input').removeClass('incorrect');
            $('input[type="text"]').val('');
            $('textarea').val('');

            if(this.element.hasClass('video-link')){
                var video_link = this.element.data('video');
                $('#video-modal .video-modal-content').html('<iframe src="' + video_link + '"frameborder="0" allowfullscreen></iframe>');
            }

            if(this.element.hasClass('plans-link')){
                $('#plan-modal .plan-rooms').html(this.element.data('title'));
                $('#plan-modal .area').text(this.element.data('area'));
                $('#plan-modal .per').text(this.element.data('per'));
                $('#plan-modal .plan-price span').text(this.element.data('price'));
                $('#plan-modal .custom-modal-right img').attr('src', this.element.data('img'));
            }

            if(this.element.hasClass('order-link')){
                $('#order-modal .custom-modal-title').html(this.element.data('title'));
                $('#order-modal .custom-modal-subtitle').html(this.element.data('subtitle'));
                $('#order-modal button').html(this.element.data('btn'));
            }

            $(".fancybox-skin").css("background-color", "transparent");

        },
        afterShow: function(){

        },
        beforeClose: function(){

        },
        afterClose: function() {
            $('#order-modal input[type="text"]').val('');
            $('#order-modal textarea').val('');
            $('#video-modal .video-modal-content').html('');
        }
    }).click(function() {
        if (typeof($(this).data('from')) !== 'undefined') {

        }
    });

    $('.modal-close, .custom-modal-close').click(function() {
        $.fancybox.close();
        return false;
    });


});

var recaptcha1;
var recaptcha2;
var recaptcha3;
var myCallBack = function() {
    //Render the recaptcha1 on the element with ID "recaptcha_1"
    recaptcha1 = grecaptcha.render('recaptcha_1', {
        'sitekey' : '6LcD3BsUAAAAAJW6tNdroBMcEZ441J3k_46tPvZS'
    });

    //Render the recaptcha2 on the element with ID "recaptcha_2"
    recaptcha2 = grecaptcha.render('recaptcha_2', {
        'sitekey' : '6LcD3BsUAAAAAJW6tNdroBMcEZ441J3k_46tPvZS'
    });

    //Render the recaptcha2 on the element with ID "recaptcha_3"
    recaptcha3 = grecaptcha.render('recaptcha_3', {
        'sitekey' : '6LcD3BsUAAAAAJW6tNdroBMcEZ441J3k_46tPvZS'
    });
};

jQuery(window).resize(function(){
    var w_h = $(window).height();
    $('.full-section').css('height', w_h + "px");
});

jQuery(window).scroll(function(e){
    var y = jQuery(window).scrollTop();
    if(y > $('.info').offset().top){
        $('.main-nav.fixed-nav').addClass('active');
    }else{
        $('.main-nav.fixed-nav').removeClass('active');
    }

    if(y > 600){
        jQuery('.up-link').addClass('visible');
    }else{
        jQuery('.up-link').removeClass('visible');
    }
});

jQuery(window).load(function(){
    var w_h = $(window).height();
    $('.full-section').css('height', w_h + "px");

    if($('#map').length){
        var type = $('#map').data('type');
        var zoom = parseInt($('#map').data('zoom'));
        var lat = $('#map').data('lat');
        var lng = $('#map').data('lng');
        initMap(type, lat, lng, zoom, 'map');
    }

    if($('.map').length){

        $('.map').each(function(){
            var type = $(this).find('.map-container').data('type');
            var zoom = parseInt($(this).find('.map-container').data('zoom'));
            var lat = $(this).find('.map-container').data('lat');
            var lng = $(this).find('.map-container').data('lng');
            var mid = $(this).find('.map-container').attr('id');

            initMap(type, lat, lng, zoom, mid);
        });
    }
});

function initMap(type, lat, lng, zoom, mid) {

    var myLatlngC = new google.maps.LatLng(lat, lng);

    var myOptions = {
        scrollwheel: false,
        zoom: zoom,
        center: myLatlngC,
        zoomControl: false,
        scaleControl: false,
        draggable: true,
        mapTypeControl: false,
        navigationControl: false,
        streetViewControl: false
    };

    switch(type){
        case 'contacts':
            var map_cont = new google.maps.Map(document.getElementById(mid), myOptions);

            var marker = new google.maps.Marker({
                map: map_cont,
                position: myLatlngC
            });
            break;
    }
}

(function($) {
    $.fn.isCorrectRequest = function() {
        $(this).find('input[type=text]').removeClass('correct incorrect shake');

        var nameInput = $(this).find('[name = name]');
        var telephoneInput = $(this).find('[name = phone]');
        var emailInput = $(this).find('[name = email]');

        nameInput.val($.trim(nameInput.val()));
        telephoneInput.val($.trim(telephoneInput.val()));

        if(nameInput.val() != undefined){
            if(nameInput.val().length === 0)
            {
                nameInput.addClass('incorrect');
                nameInput.focus();
                return false;
            }
        }

        if(telephoneInput.val() != undefined){
            if(telephoneInput.val().length === 0)
            {
                telephoneInput.addClass('incorrect');
                telephoneInput.focus();
                return false;
            }
        }

        if(emailInput.val() != undefined){
            if(emailInput.val().length === 0)
            {
                emailInput.addClass('incorrect');
                emailInput.focus();
                return false;
            }else{
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test(emailInput.val())){
                    emailInput.addClass('incorrect');
                    emailInput.focus();
                    return false;
                }
            }
        }

        var form = $(this);
        var formData = new FormData($(this)[0]);
        var url = form.attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            success: function(data)
            {
                if(data === 'ok'){
                    $('input').removeClass('incorrect');
                    $('input[type="text"]').val('');
                    $('textarea').val('');
                    $('.form-error').slideUp();
                    $.fancybox("#thanks-modal", {
                        autoSize: true,
                        type: 'inline',
                        closeBtn: false,
                        padding: 0,
                        scrolling: 'visible',
                        fixed: false,
                        autoCenter: false
                    });

                    setTimeout(function(){
                        $.fancybox.close();
                    }, 3000);
                }else{
                    form.find('.form-error').text(data).slideDown();
                }


            },
            error: function(answer)
            {
                alert('Ошибка отправки. Попробуйте еще раз.');
            }
        });
    };
})(jQuery);

function shuffle(array) {
    var currentIndex = array.length
        , temporaryValue
        , randomIndex
        ;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

(function ($) {
    $.fn.randomize = function (childElem) {
        return this.each(function () {
            var $this = $(this);
            var elems = shuffle($(childElem));
            $this.remove(childElem);
            for (var i = 0; i < elems.length; i++)
                $this.append(elems[i]);
        });
    }
})(jQuery)