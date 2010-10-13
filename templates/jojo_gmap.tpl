<div class='jojo_map' id="map{$mapid}" style="width: {$map.mp_width}px; height: {$map.mp_height}px;"></div>
<script type="text/javascript">
/* <![CDATA[ */
var marker = {ldelim}{rdelim};
var infowindow = {ldelim}{rdelim};
var map{$mapid} = {ldelim}{rdelim};

function initialize() {ldelim}
     /* Set center to New Zealand if no locations are provided */
    var map{$mapid}Latlng = new google.maps.LatLng({if $mapLocations[0].ml_geoloc}{$mapLocations[0].ml_geoloc}{else}-40.900557,174.885971{/if});
    var map{$mapid}Options = {ldelim}
        zoom:{if $map.mp_zoom && $map.mp_zoom!='auto'}{$map.mp_zoom}{else}5{/if},
        center: map{$mapid}Latlng,
        draggable: {if $map.mp_dragging=='yes'}true{else}false{/if},
        scrollwheel: {if $map.mp_scroll=='yes'}true{else}false{/if},
        {if $map.mp_type=='Satellite'}mapTypeId: google.maps.MapTypeId.SATELLITE,
        {elseif  $map.mp_type=='Hybrid'}mapTypeId: google.maps.MapTypeId.HYBRID,
        {elseif  $map.mp_type=='Terrain'}mapTypeId: google.maps.MapTypeId.TERRAIN,
        {else}mapTypeId: google.maps.MapTypeId.ROADMAP,{/if}
        navigationControl: {if $map.mp_control}true{else}false{/if},
        {if $map.mp_control}navigationControlOptions: {ldelim}
            style: google.maps.NavigationControlStyle.{if $map.mp_control=='Small'}SMALL{else}DEFAULT{/if}
        {rdelim}{/if},
        mapTypeControl: {if $map.mp_typecontrol=='yes'}true{else}false{/if},
        mapTypeControlOptions: {ldelim}
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        {rdelim},
        scaleControl: {if $map.mp_scale=='yes'}true{else}false{/if}
    {rdelim}

    map{$mapid} = new google.maps.Map(document.getElementById("map{$mapid}"), map{$mapid}Options);
    var bounds = new google.maps.LatLngBounds();
{if $mapLocations}
    {foreach from=$mapLocations key=k item=m}
    var pos{$m.locationid} = new google.maps.LatLng({$m.ml_geoloc});
    marker["{$mapid}-{$m.locationid}"] = new google.maps.Marker({ldelim}
        position: pos{$m.locationid},
        map: map{$mapid},
        title: "{$m.ml_name}",
    {rdelim});
     
    bounds.extend(new google.maps.LatLng({$m.ml_geoloc}));
    infowindow["{$mapid}-{$m.locationid}"] = new google.maps.InfoWindow({ldelim}
            content: '<p class="mapinfo"><strong>{$m.ml_name|replace:"'":"\'"}</strong><br />'+
            '{$m.ml_description|nl2br|replace:"\n":""|replace:"\r":''}</p>'
    {rdelim});

    google.maps.event.addListener(marker["{$mapid}-{$m.locationid}"], 'click', function() {ldelim}
        // Close existing open info windows
        $.each(infowindow, function(k, v) {ldelim}v.close(){rdelim});

        // Open Info Window
        infowindow["{$mapid}-{$m.locationid}"].open(map{$mapid}, marker["{$mapid}-{$m.locationid}"]);
        map{$mapid}.setCenter(pos{$m.locationid});
    {rdelim});
    {/foreach}
    {if $map.mp_zoom=='auto'}
    map{$mapid}.fitBounds(bounds);
    {/if}
{/if}
{rdelim}

{literal}
function downloadUrl(url,callback) {
 var request = window.ActiveXObject ? 
 new ActiveXObject('Microsoft.XMLHTTP') : 
 new XMLHttpRequest;

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
$(document).ready(function() {
    loadGMapScript();
});

function findonmap(map, markerid) {
     map.panTo(marker[markerid].getPosition());
    if (map.getZoom() < 14) {
        map.setZoom(16);
    }
    setTimeout(function() {google.maps.event.trigger(marker[markerid], 'click');}, 800);
}

function loadGMapScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}
{/literal}/* ]]> */
</script>
{if $mapLocations}
    <div class='jojo_maplocations' id="maplocations{$mapid}"{if $OPTIONS.gmaps_locations != 'yes'} style="display:none"{/if} >
        {foreach from=$mapLocations key=k item=m}
        <div id='mapDescription{$mapid}j{$k}'>
            <h3>{$m.ml_name}</h3>
            <p>{$m.ml_description|nl2br}</p>
            {if count($mapLocations) > 1}<p class="note"><a href="#" onclick='findonmap(map{$mapid}, "{$mapid}-{$m.locationid}"); return false;'>Show on map &gt;</a><p>{/if}
        </div>
        {/foreach}
    </div>
{/if}