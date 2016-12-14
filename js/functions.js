var apikey;
var marker;
var infoWindows = [];

$(document).ready(function() {
    if ($('.jojo_map').length>0) {
        var lang = $('html').attr('lang');
        var apikey = $('.jojo_map').attr('data-apikey');
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://maps.googleapis.com/maps/api/js?" + ( apikey ? "key=" + apikey : "" ) + "&callback=initializeMap&language=" + lang;
        document.body.appendChild(script);
    }
});

function downloadUrl(url,callback) {
 var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };
 request.open('GET', url, true);
 request.send(null);
}

function doNothing() {}

function findonmap(map, markerid) {
     map.panTo(marker[markerid].getPosition());
    if (map.getZoom() < 14) {
        map.setZoom(16);
    }
    setTimeout(function() {google.maps.event.trigger(marker[markerid], 'click');}, 800);
}

function initializeMap() {
    var mapid = '';
    $('.jojo_map').each( function(){
        var mapid = $(this).attr('id');
        var mapstyles = $('code.mapstyle').length>0 ? $.parseJSON($('code.mapstyle').html())  : '';
        var locations = $('#maplocations' + mapid + ' > div');
        var mzoom = ( $(this).attr('data-zoom') && $(this).attr('data-zoom')!='auto') ? $(this).attr('data-zoom') : 5 ;
       /* Set center to New Zealand if no locations are provided */
       if (locations) {
            latlng = locations.first().attr('data-latlng').split(',');
            middle = new google.maps.LatLng(latlng[0],latlng[1]);
        } else {
            middle = new google.maps.LatLng(-40.900557,174.885971);
        }
        if ($(this).attr('data-maptype')=='Satellite') {
                mapType = google.maps.MapTypeId.SATELLITE;
        } else if ($(this).attr('data-maptype')=='Hybrid') {
                mapType = google.maps.MapTypeId.HYBRID;
        } else if ($(this).attr('data-maptype')=='Terrain') {
                mapType = google.maps.MapTypeId.TERRAIN;
        } else {
                mapType = google.maps.MapTypeId.ROADMAP;
        }
        mapOptions = { 
            center : middle,
            zoom : (mzoom ? parseInt(mzoom) : 5 ),
            scaleControl : ( $(this).attr('data-scale') ? true : false ),
            draggable: ( $(this).attr('data-draggable') ? true : false ),
            scrollwheel: ( $(this).attr('data-scroll') ? true : false ),
            mapTypeId : mapType,
            navigationControl: ( $(this).attr('data-nav') ? true : false ),
            navigationControlOptions: {
                style: ( $(this).attr('data-navstyle') ? google.maps.NavigationControlStyle.SMALL : google.maps.NavigationControlStyle.DEFAULT )
            },
            streetViewControl: ( $(this).attr('data-streetview') ? true : false ),
            mapTypeControl: ( $(this).attr('data-typecontrol') ? true : false ),
            mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU },
            styles: mapstyles
       
        };
        gmap = new google.maps.Map(document.getElementById(mapid), mapOptions);
        bounds = new google.maps.LatLngBounds();
        if (locations) {
            var markerimage = false;
            if ($(this).data('icon')) {
                var iconoffset = $(this).data('icon-offset') ? $(this).data('icon-offset').split(',') : false;
                iconoffset = (iconoffset ? new google.maps.Point(iconoffset[0],iconoffset[1]) : '');
                var iconsize = $(this).data('icon-size') ? $(this).data('icon-size').split(',') : false;
                iconsize = (iconsize ? new google.maps.Size(iconsize[0],iconsize[1]) : '');
                markerimage = new google.maps.MarkerImage(
                    $(this).data('icon'),
                    null,
                    null,
                    iconoffset,
                    iconsize
                );
            }
            locations.each( function(k) {
                locationid = $(this).attr('id');
                geoloc = $(this).attr('data-latlng').split(',');
                ltitle = $('h3', this).html();
                ldesc = $('p', this).html();
                pos = new google.maps.LatLng(geoloc[0],geoloc[1]);
                if (markerimage) {
                    marker = new google.maps.Marker({
                        position: pos,
                        map: gmap,
                        icon: markerimage,
                        title: ltitle
                    });
                } else {
                    marker = new google.maps.Marker({
                        position: pos,
                        map: gmap,
                        title: ltitle
                    });
                }
                bounds.extend(new google.maps.LatLng(geoloc[0],geoloc[1]));
                infowindow = new google.maps.InfoWindow({
                        content: ''
                });
                infoWindows.push(infowindow); 
                description = '<p class="mapinfo"><strong>' + ltitle +'</strong>' + ( ldesc ? '<br />' + ldesc : '') + '</p>';
                bindInfoWindow(marker, gmap, infowindow, description);
                bindInfoLink(locationid, marker, pos, gmap, infowindow, description, mapid);
            });
           if ($(this).attr('data-zoom')=='auto') {
                gmap.fitBounds(bounds);
            }
        }
    });
}

function bindInfoWindow(marker, map, infowindow, strDescription) {
    google.maps.event.addListener(marker, 'click', function() {
        closeAllInfoWindows();
        infowindow.setContent(strDescription);
        infowindow.open(map, marker);
    });
}

function bindInfoLink(locationid, marker, pos, map, infowindow, strDescription, mapid) {
    $('#' + locationid + ' a').click(function() {
        location.hash = "#" +  mapid + "anchor";
        closeAllInfoWindows();
        map.panTo(pos);
        infowindow.setContent(strDescription);
        infowindow.open(map, marker);
    });
}

function closeAllInfoWindows() {
  for (var i=0;i<infoWindows.length;i++) {
     infoWindows[i].close();
  }
}