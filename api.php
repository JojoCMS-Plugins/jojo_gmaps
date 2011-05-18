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
    'label' => 'Google Maps API key',
    'description' => 'Google Maps API key received after applying here: http://www.google.com/apis/maps/signup.html',
    'type' => 'text',
    'default' => '',
    'options' => ''
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


$gmaps_filter = Jojo::getOption('gmaps_filter');
/* Map filter */
if (!$gmaps_filter || $gmaps_filter=='content' || $gmaps_filter=='both') Jojo::addFilter('content', 'mapfilter', 'jojo_gmaps');
if (!$gmaps_filter || $gmaps_filter=='template' || $gmaps_filter=='both') Jojo::addFilter('output', 'mapfilter', 'jojo_gmaps');
