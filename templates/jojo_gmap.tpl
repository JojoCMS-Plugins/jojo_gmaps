<a name="map{$mapid}anchor"></a>
<div class='jojo_map' id="map{$mapid}" style="width: {$map.mp_width}{$map.mapunit_w}; height: {$map.mp_height}{$map.mapunit_h};" data-apikey="{$OPTIONS.gmapskey}"{if $OPTIONS.gmaps_location_sensor == 'yes'} data-sensor="true"{/if} data-maptype="{$map.mp_type}" data-zoom="{if $map.mp_zoom}{$map.mp_zoom}{else}5{/if}"{if $map.mp_dragging=='yes'} data-draggable="true"{/if}{if $map.mp_scroll=='yes'} data-scroll="true"{/if}{if $map.mp_control && $map.mp_control!='None'} data-nav="true" data-navstyle="{if $map.mp_control=='Small'}SMALL{else}DEFAULT{/if}"{/if}{if $map.mp_streetview} data-streetview="true"{/if}{if $map.mp_typecontrol=='yes'} data-typecontrol="true"{/if}{if $map.mp_scale=='yes'} data-scale="true"{/if}{if $OPTIONS.gmaps_icon} data-icon="{$OPTIONS.gmaps_icon}"{/if}{if $OPTIONS.gmaps_icon_offset} data-icon-offset="{$OPTIONS.gmaps_icon_offset}"{/if}></div>
{if $mapLocations}
<div class='jojo_maplocations' id="maplocationsmap{$mapid}"{if $OPTIONS.gmaps_locations != 'yes'} style="display:none;"{/if} >
    {foreach from=$mapLocations key=k item=m}
    <div id='mapDescription{$mapid}-{$k}' data-mid="{$k}" data-mapid="map{$mapid}" data-latlng="{$m.ml_geoloc}">
        <h3>{$m.ml_name}</h3>
        <p>{$m.ml_description|nl2br}</p>
        {if count($mapLocations) > 1}<p class="note"><a href="#" onclick="return false;">Show on map &gt;</a><p>{/if}
    </div>
    {/foreach}
</div>
{/if}
{if $OPTIONS.gmaps_styling}<code class="mapstyle" style="display:none;">{$OPTIONS.gmaps_styling}</code>{/if}
