var map;
var service;
var markers = [];
var point;
var infowindow;
var markerClusterer = null;
var clusterOptions = null;

jQuery(document).ready(function(){
    if(jQuery('.checkbox-wrap').length){
        jQuery('.checkbox-wrap input').styler();
    }

    jQuery('.close-cards').on('click', function(){
        jQuery('.custom-map').removeClass('map-blocked');
        jQuery('.map-cards').removeClass('active');
        jQuery('.map-near').removeClass('active');
    });

    jQuery('.map-out').on('click', function(){
        map.setZoom(map.getZoom() - 1);
    });

    jQuery('.map-in').on('click', function(){
        map.setZoom(map.getZoom() + 1);
    });

    jQuery('.map-infra-list input').on('change', function(){
        var _this = jQuery(this);
        var _this_name = _this.attr('name');
        service = [];
        if(_this.is(':checked')){
            service.push(_this_name);
            jQuery('.map-infra-list input').each(function(){
                if(jQuery(this).attr('name') !== _this_name){
                    jQuery(this).attr('checked', false).trigger('refresh');
                }
            });
        }

        jQuery('.map-infra').addClass('process-mode');


        jQuery('.map-loader').addClass('active');
        clearMarkers();
        if(service.length > 0){
            createServices(service);
        }else{
            jQuery('.map-loader').removeClass('active');
        }

        setTimeout(function(){
            jQuery('.map-infra').removeClass('process-mode');
        }, 500);
    });

    jQuery('.map-infra-label').on('click', function(){
        jQuery('.map-near').removeClass('active');
        jQuery('.map-infra').toggleClass('active');
    });

});

jQuery(window).load(function(){
    if(jQuery('#map').length){
        var _this = jQuery('#map');
        initMap(_this.data('mode'), _this.data('x'), _this.data('y'));
    }
});


function initMap(mode, x, y) {
    var customMapType = new google.maps.StyledMapType([{
        featureType: "all",
        elementType: "all",
        stylers: [
            { saturation: -100 }
        ]}], {
        name: 'Custom Style'
    });

    clusterOptions = {styles: [{
            height: 32,
            url: "images/elements/cluster/m1.png",
            width: 32
        },
        {
            height: 32,
            url: "images/elements/cluster/m2.png",
            width: 32
        },
        {
            height: 32,
            url: "images/elements/cluster/m3.png",
            width: 32
        },
        {
            height: 32,
            url: "images/elements/cluster/m4.png",
            width: 32
        },
        {
            height: 32,
            url: "images/elements/cluster/m5.png",
            width: 32
        }]};

    var customMapTypeId = 'custom_style';

    if(mode === 'card'){
        point = new google.maps.LatLng(x, y);
    }else{

    }

    var options = {
        scrollwheel: false,
        zoom: 15,
        center: point,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, customMapTypeId]
        },
        disableDefaultUI: true

    };
    map = new google.maps.Map(document.getElementById('map'), options);
    map.mapTypes.set(customMapTypeId, customMapType);
    map.setMapTypeId(customMapTypeId);
    infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: {
            url: 'images/elements/point.png',
            size: new google.maps.Size(28, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(14, 32)
        }
    });
}

function createServices(services) {
    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: point,
        radius: 2500,
        types: services
    }, function(results, status){
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                createMarker(results[i], services[0]);
            }

            markerClusterer = new MarkerClusterer(map, markers,clusterOptions);

            jQuery('.map-loader').removeClass('active');
        }
    });
}

function createMarker(place, type) {
    var placeLoc = place.geometry.location;
    var icon = 'images/elements/point.png';
    switch(type){
        case 'school':
            icon = 'images/elements/point-school.png';
            break;
        case 'gym':
            icon = 'images/elements/point-fit.png';
            break;
        case 'hospital':
            icon = 'images/elements/point-hospital.png';
            break;
        case 'dentist':
            icon = 'images/elements/point-hospital.png';
            break;
        case 'cafe':
            icon = 'images/elements/point-cafe.png';
            break;
        case 'bakery':
            icon = 'images/elements/point-cafe.png';
            break;
        case 'restaurant':
            icon = 'images/elements/point-rest.png';
            break;
        case 'bar':
            icon = 'images/elements/point-rest.png';
            break;
        case 'food':
            icon = 'images/elements/point-rest.png';
            break;
        case 'meal_delivery':
            icon = 'images/elements/point-rest.png';
            break;
    }

    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        icon: {
            url: icon,
            size: new google.maps.Size(28, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(14, 32)
        }
    });

    markers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}

function clearMarkers() {
    if(markers.length > 0){
        markerClusterer.clearMarkers();
        markers = [];
    }
}