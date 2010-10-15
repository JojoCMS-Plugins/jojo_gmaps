<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.1">
<Document>
    <name>{$map.name}</name>

{foreach from=$mapLocations item=m}
    <Placemark>
        <name>{$m.name}</name>
        <description>{$m.description}</description>
        <Point>
            <coordinates>{$m.long},{$m.lat}</coordinates>
        </Point>
    </Placemark>
{/foreach}
</Document>
</kml>