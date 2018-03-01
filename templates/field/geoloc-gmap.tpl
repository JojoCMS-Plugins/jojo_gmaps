<script type="text/javascript" src="https://www.google.com/jsapi?key={$OPTIONS.gmapskey}"></script>
<script type="text/javascript">google.load("maps", "2",{ldelim}"other_params":"sensor=false"{rdelim});</script>

Lat: <span id="{$fieldname}_latTXT">{if $fieldvalue.0}{$fieldvalue.0}{/if}</span>
Long: <span id="{$fieldname}_longTXT">{if $fieldvalue.1}{$fieldvalue.1}{/if}</span>
<a href="#" onclick="showGmap('{$fieldname}', '{$option}'); return false;">Change / Set Location</a>
<input type="hidden" name="{$fieldname}[lat]" id="{$fieldname}_lat" value="{if $fieldvalue.0}{$fieldvalue.0}{/if}" />
<input type="hidden" name="{$fieldname}[long]" id="{$fieldname}_long" value="{if $fieldvalue.1}{$fieldvalue.1}{/if}" />
<br/>

<div id="map-wrapper" class="jpop">
    <div id="map" style="width: 600px; height: 430px;"></div>
     Click on the map to add a new location or drag an existing marker to move it, click an existing marker to delete it<br />
     <a href="" onclick="saveGmap(); $('#jpop_overlay').click(); return false;" style="text-align:right">Save New Location</a> |
    <a href="" onclick="$('#jpop_overlay').click(); return false;" style="text-align:right">Cancel</a>
    <input type="hidden" id="gmap_tmp_name" value="" />
</div>

<script type="text/javascript">{literal}

var map;
var field;
var namefield = false;
var existingMarker = false;

function showGmap(fieldname, nameformfield) {
    if (!google.maps.BrowserIsCompatible()) {
    alert("Either this browser doesn't support GMap display or you haven't supplied a valid Google Maps API key in Options");
        return;
    }

    /* Store the field name where we can access it later */
    field = {/literal}"{$fieldname}"{literal};
    if ($('#'+nameformfield).get(0)) {
        namefield = nameformfield;
    } else {
        namefield = false;
    }

    /* Show the map in the middle of the screen */
    jpop($('#map-wrapper'),600,460);

    /* Start the name */
    map = new google.maps.Map2($("#map").get(0));

    var MarkerOptions = {
        draggable: true,
        bouncy: false
    };

    if ($('#'+field+'_lat').val() != 0 && $('#'+field+'_long').val() !=0) {
        /* Have existing location */
        var point = new google.maps.LatLng($('#'+field+'_lat').val(), $('#'+field+'_long').val());
        if (namefield) {
            $('#gmap_tmp_name').val($('#'+namefield).val());
        } else {
            $('#gmap_tmp_name').val('');
        }

        existingMarker = new google.maps.Marker(point, MarkerOptions);
        map.setCenter(point, 15);
        map.addOverlay(existingMarker);
         google.maps.Event.addListener(
            map,
            "click",
            function(marker, point) {
                if (!marker && !existingMarker) {
                    /* Add marker */
                    var marker = new google.maps.Marker(point, MarkerOptions);
                    map.addOverlay(marker);
                    existingMarker = marker;
                } else if (!marker && existingMarker) {
                    /* Add marker */
                    var marker = new google.maps.Marker(point, MarkerOptions);
                    map.addOverlay(marker);
                    map.removeOverlay(existingMarker);
                    existingMarker = marker;
                } else {
                    map.removeOverlay(marker);
                    existingMarker = false;
                }
            }
        );

    } else {
        /* No existing location, allow one to be added */
        existingMarker = false;
        map.setCenter(new google.maps.LatLng(-40.900557,174.885971), 5);

        google.maps.Event.addListener(
            map,
            "click",
            function(marker, point) {
                if (!marker && !existingMarker) {
                    /* Add marker */
                    var marker = new google.maps.Marker(point, MarkerOptions);
                    map.addOverlay(marker);
                    existingMarker = marker;
                } else if (!marker && existingMarker) {
                    /* Add marker */
                    var marker = new google.maps.Marker(point, MarkerOptions);
                    map.addOverlay(marker);
                    map.removeOverlay(existingMarker);
                    existingMarker = marker;
                } else {
                     map.removeOverlay(marker);
                    existingMarker = false;
                }
            }
        );
    }
    map.addControl(new google.maps.SmallMapControl());
    map.addControl(new google.maps.MapTypeControl());
    map.enableScrollWheelZoom();
    /* create a local search control and add it to your map */
    map.enableGoogleBar();

}

function markersSet(markers) {
  // note: markers is an array of LocalResult
  existingMarker = markers[0].marker;
}

function saveGmap() {
    if (existingMarker) {
        point = existingMarker.getLatLng();
        $('#'+field + '_lat').val(point.lat());
        $('#'+field + '_long').val(point.lng());
        $('#'+field + '_latTXT').html(point.lat());
        $('#'+field + '_longTXT').html(point.lng());
    }
    if (namefield) {
        $('#'+namefield).val($('#gmap_tmp_name').val());
    }
    $("#jpop_overlay").click();
    return false;
}

{/literal}</script>