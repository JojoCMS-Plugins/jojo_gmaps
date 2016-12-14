<?php
/**
 *
 * Copyright 2007 Michael Cochrane <code@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

$_provides['pluginClasses'] = array(
        'JOJO_Plugin_Jojo_gmaps' => 'GMaps',
        'JOJO_Plugin_Jojo_gmaps_kml' => 'GMaps - KML publishing'
        );

/* Register URI patterns */
$prefix = JOJO_Plugin_Jojo_gmaps_kml::_getPrefix();
Jojo::registerURI("$prefix/[mapname:[^\\.]+].kml", 'jojo_plugin_jojo_gmaps_kml'); // "maps/kml/mapname.kml"

/* XML Sitemap */
Jojo::addFilter('jojo_xml_sitemap', 'xmlsitemap', 'jojo_gmaps_kml');


$_provides['fieldTypes'] = array(
        'geolocgmap' => 'Geo Location - Google Maps',
        );

$_options[] = array(
    'id' => 'gmapskey',
    'category' => 'Maps',
    'label' => 'Google Maps 3 API key',
    'description' => 'Google API key - details here https://developers.google.com/maps/documentation/javascript/tutorial#api_key',
    'type' => 'text',
    'default' => '',
    'options' => ''
);

$_options[] = array(
    'id'          => 'gmaps_location_sensor',
    'category'    => 'Maps',
    'label'       => 'Sense location',
    'description' => 'Enable the location sensor to show the users location (if permitted) relative to the map location(s)',
    'type'        => 'radio',
    'default'     => 'no',
    'options'     => 'yes,no',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_locations',
    'category'    => 'Maps',
    'label'       => 'Show locations',
    'description' => 'Show a list of location details with panTo links if more than one',
    'type'        => 'radio',
    'default'     => 'no',
    'options'     => 'yes,no',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_filter',
    'category'    => 'Maps',
    'label'       => 'Filter for maps in',
    'description' => 'The plugin can check for the filter text in templates or body content, or run twice to check both. (force refresh to update the api.txt after changing this option)',
    'type'        => 'radio',
    'default'     => 'both',
    'options'     => 'content,template,both',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_icon',
    'category'    => 'Maps',
    'label'       => 'Custom Marker Icon',
    'description' => 'relative url for a custom map marker png',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_icon_offset',
    'category'    => 'Maps',
    'label'       => 'Custom Icon Offset',
    'description' => 'Offset from top left to pointer tip (if not center bottom). eg 10,30',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_icon_size',
    'category'    => 'Maps',
    'label'       => 'Custom Icon Size',
    'description' => 'Display size of the icon (can be scaled as half actual for retina display)- width,height in pixels eg 10,30',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_gmaps'
);

$_options[] = array(
    'id'          => 'gmaps_styling',
    'category'    => 'Maps',
    'label'       => 'Map styling',
    'description' => 'Paste in styling overrides here as a json array eg [{featureType:"all",stylers: [{hue:"#c1b8cd" },{ saturation: -60 }]}] or use the code from a place like snazzymaps.com',
    'type'        => 'textarea',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_gmaps'
);

$gmaps_filter = Jojo::getOption('gmaps_filter');
/* Map filter */
if (!$gmaps_filter || $gmaps_filter=='content' || $gmaps_filter=='both') Jojo::addFilter('content', 'mapfilter', 'jojo_gmaps');
if (!$gmaps_filter || $gmaps_filter=='template' || $gmaps_filter=='both') Jojo::addFilter('output', 'mapfilter', 'jojo_gmaps');
