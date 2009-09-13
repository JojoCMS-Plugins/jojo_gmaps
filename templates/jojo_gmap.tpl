<script type="text/javascript" src="http://www.google.com/jsapi?key={$OPTIONS.gmapskey}"></script>
<div class='jojo_map' id="map{$mapid}" style="width: {$map.mp_width}px; height: {$map.mp_height}px;"></div>

<script type="text/javascript">/* <![CDATA[ */{literal}
    google.load("maps", "2", {"other_params":"sensor=false"});

    function initialize() {{/literal}
        /* Start the map */
        var map{$mapid} = new google.maps.Map2(document.getElementById("map{$mapid}"));
        /* Set center to New Zealand if no locations are provided */
        map{$mapid}.setCenter(new google.maps.LatLng(-40.900557,174.885971), 5);
        map{$mapid}.addControl(new google.maps.{$map.mp_control}MapControl());

        {if $map.mp_typecontrol=='yes'}
            map{$mapid}.addControl(new google.maps.HierarchicalMapTypeControl());
            map{$mapid}.addMapType(G_PHYSICAL_MAP)
        {/if}

        {if $map.mp_type=='Satellite'}
            map{$mapid}.setMapType(G_SATELLITE_MAP);
        {elseif  $map.mp_type=='Hybrid'}
            map{$mapid}.setMapType(G_HYBRID_MAP);
        {elseif  $map.mp_type=='Terrain'}
            map{$mapid}.setMapType(G_PHYSICAL_MAP);
        {/if}
        {if $map.mp_scale=='yes'}
            map{$mapid}.addControl(new google.maps.ScaleControl());
        {/if}
        {if $map.mp_scroll=='yes'}
            map{$mapid}.enableScrollWheelZoom();
        {/if}
        {if $map.mp_dragging=='no'}
            map{$mapid}.disableDragging();
        {/if}

        /* Include the KML file */
        var geoxml = new google.maps.GeoXml("{$kmlurl}");
        map{$mapid}.addOverlay(geoxml);

        /* Manually parse the KML file to get the bounds for zoom and center */
        GDownloadUrl("{$kmlurl}", function(doc) {literal}{
            var bounds = new google.maps.LatLngBounds();
            var xmlDoc = google.maps.Xml.parse(doc);
            var placemarks = xmlDoc.documentElement.getElementsByTagName("Placemark");
            for (var i = 0; i < placemarks.length; i++) {
                var coords=google.maps.Xml.value(placemarks[i].getElementsByTagName("coordinates")[0]);
                var bits = coords.split(",");
                var point = new google.maps.LatLng(parseFloat(bits[1]),parseFloat(bits[0]));
                bounds.extend(point);
            }{/literal}

            /* Set the zoom level and map center */
            {if $map.mp_zoom=='auto'}
                map{$mapid}.setZoom(map{$mapid}.getBoundsZoomLevel(bounds));
            {else}
                map{$mapid}.setZoom({$map.mp_zoom});
            {/if}
            {if $mapLocations}
                map{$mapid}.setCenter(bounds.getCenter());
            {/if}
{literal}
        });
    }
    google.setOnLoadCallback(initialize);
{/literal}/* ]]> */</script>
{if $mapLocations}
    <div style='display: none'>
        {foreach from=$mapLocations key=k item=m}
        <span id='mapDescription{$mapid}j{$k}'>
            <strong>{$m.ml_name}</strong><br/>
            {$m.ml_description|nl2br}
        </span>
        {/foreach}
    </div>
{/if}