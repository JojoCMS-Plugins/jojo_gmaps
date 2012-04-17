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
