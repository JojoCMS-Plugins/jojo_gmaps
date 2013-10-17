<div class='jojo_map' id="map{$mapid}" style="width: {$map.mp_width}{$map.mapunit_w}; height: {$map.mp_height}{$map.mapunit_h};"></div>
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
        navigationControl: {if $map.mp_control && $map.mp_control!='None'}true{else}false{/if},
        {if $map.mp_control && $map.mp_control!='None'}navigationControlOptions: {ldelim}
            style: google.maps.NavigationControlStyle.{if $map.mp_control=='Small'}SMALL{else}DEFAULT{/if}
        {rdelim},{/if}
        streetViewControl: {if $map.mp_streetview}true{else}false{/if},
        mapTypeControl: {if $map.mp_typecontrol=='yes'}true{else}false{/if},
        mapTypeControlOptions: {ldelim}
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        {rdelim},
        scaleControl: {if $map.mp_scale=='yes'}true{else}false{/if}
    {rdelim}

    map{$mapid} = new google.maps.Map(document.getElementById("map{$mapid}"), map{$mapid}Options);
    var bounds = new google.maps.LatLngBounds();
    {if $OPTIONS.gmaps_styling}var mapstyles = [ {$OPTIONS.gmaps_styling} ];
    map{$mapid}.setOptions({ldelim}styles: mapstyles{rdelim});
    {/if}

{if $mapLocations}
    {foreach from=$mapLocations key=k item=m}
    var pos{$m.locationid} = new google.maps.LatLng({$m.ml_geoloc});
    marker["{$mapid}-{$m.locationid}"] = new google.maps.Marker({ldelim}
        position: pos{$m.locationid},{if $OPTIONS.gmaps_icon}
        icon: '{$OPTIONS.gmaps_icon}',{if $OPTIONS.gmaps_icon_offset}
        anchor : new google.maps.Point({$OPTIONS.gmaps_icon_offset}),{/if}{/if}
        map: map{$mapid},
        title: "{$m.ml_name}"
    {rdelim});

    bounds.extend(new google.maps.LatLng({$m.ml_geoloc}));
    infowindow["{$mapid}-{$m.locationid}"] = new google.maps.InfoWindow({ldelim}
            content: '<p class="mapinfo"><strong>{$m.name|replace:"'":"\'"}</strong><br />'+
            '{$m.description|replace:"\n":""|replace:"\r":''}</p>'
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
{if $OPTIONS.gmaps_location_sensor == 'yes'}
    if (Modernizr.geolocation) {ldelim}
        navigator.geolocation.getCurrentPosition(function(position){ldelim}
            var myLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var me = new google.maps.Marker({ldelim}
                position: myLocation,
                icon: '{$SITEURL}/images/my-location.png',
                anchor : new google.maps.Point(8,8),
                map: map{$mapid},
                title: 'You are here!',
                zIndex: 100
            {rdelim});
            bounds.extend(myLocation);
            map{$mapid}.fitBounds(bounds);
        {rdelim});
    {rdelim}
{/if}
{rdelim}

$(document).ready(function() {ldelim}
    loadGMapScript();
{rdelim});

function loadGMapScript() {ldelim}
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.googleapis.com/maps/api/js?{if $OPTIONS.gmapskey}key={$OPTIONS.gmapskey}&{/if}sensor={if $OPTIONS.gmaps_location_sensor == 'yes'}true{else}false{/if}&callback=initialize{if $pg_htmllang !='en'}&language={$pg_htmllang}{/if}";
    document.body.appendChild(script);
{rdelim}
/* ]]> */
</script>
{if $mapLocations}
    <div class='jojo_maplocations' id="maplocations{$mapid}"{if $OPTIONS.gmaps_locations != 'yes'} style="display:none;"{/if} >
        {foreach from=$mapLocations key=k item=m}
        <div id='mapDescription{$mapid}j{$k}'>
            <h3>{$m.ml_name}</h3>
            <p>{$m.ml_description|nl2br}</p>
            {if count($mapLocations) > 1}<p class="note"><a href="#" onclick='findonmap(map{$mapid}, "{$mapid}-{$m.locationid}"); return false;'>Show on map &gt;</a><p>{/if}
        </div>
        {/foreach}
    </div>
{/if}
