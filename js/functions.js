var apikey;
var sensor = "false";
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

/* Modernizr 2.6.2 (geolocation) | MIT & BSD
 * Build: http://modernizr.com/download/#-geolocation
 */
;window.Modernizr=function(a,b,c){function t(a){i.cssText=a}function u(a,b){return t(prefixes.join(a+";")+(b||""))}function v(a,b){return typeof a===b}function w(a,b){return!!~(""+a).indexOf(b)}function x(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:v(f,"function")?f.bind(d||b):f}return!1}var d="2.6.2",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l={},m={},n={},o=[],p=o.slice,q,r={}.hasOwnProperty,s;!v(r,"undefined")&&!v(r.call,"undefined")?s=function(a,b){return r.call(a,b)}:s=function(a,b){return b in a&&v(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=p.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(p.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(p.call(arguments)))};return e}),l.geolocation=function(){return"geolocation"in navigator};for(var y in l)s(l,y)&&(q=y.toLowerCase(),e[q]=l[y](),o.push((e[q]?"":"no-")+q));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)s(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},t(""),h=j=null,e._version=d,e}(this,this.document);


function initializeMap() {
    var mapid = '';
    $('.jojo_map').each( function(){
        var mapid = $(this).attr('id');
        var sensor = $(this).attr('data-sensor')=='true' ? true : false;
        var mapstyles = $('code.mapstyle').length>0 ? $.parseJSON($('code.mapstyle').html())  : '';
        var customicon = $(this).attr('data-icon') ? $(this).attr('data-icon') : false;
        var iconoffset = $(this).attr('data-icon-offset') ? $(this).attr('data-icon-offset').split(',') : false;
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
            locations.each( function(k) {
                locationid = $(this).attr('id');
                geoloc = $(this).attr('data-latlng').split(',');
                ltitle = $('h3', this).html();
                ldesc = $('p', this).html();
                pos = new google.maps.LatLng(geoloc[0],geoloc[1]);
                marker = new google.maps.Marker({
                    position: pos,
                    map: gmap,
                    icon: ( customicon ? customicon : ''),
                    //anchor : (iconoffset ? new google.maps.Point(iconoffset[0],iconoffset[1]) : ''),
                    title: ltitle
                });
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
        if (sensor == true && Modernizr.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position){
                var myLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                var me = new google.maps.Marker({
                    position: myLocation,
                    icon: '/images/my-location.png',
                    anchor : new google.maps.Point(8,8),
                    map: gmap,
                    title: 'You are here!',
                    zIndex: 100
                });
                bounds.extend(myLocation);
                gmap.fitBounds(bounds);
            });
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