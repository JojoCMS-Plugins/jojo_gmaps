<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007 Harvey Kane <code@ragepank.com>
 * Copyright 2007 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */



$table = 'maplocation';
$default_td[$table]['td_displayname'] = 'Map Location';
$default_td[$table]['td_displayfield'] = 'ml_name';
$default_td[$table]['td_orderbyfields'] = 'displayorder, ml_name';
$default_td[$table]['td_categorytable'] = 'map';
$default_td[$table]['td_categoryfield'] = 'mapid';
$default_td[$table]['td_primarykey'] = 'locationid';
$default_td[$table]['td_topsubmit'] = 'yes';
$default_td[$table]['td_deleteoption'] = 'yes';
$default_td[$table]['td_menutype'] = 'tree';
$default_td[$table]['td_defaultpermissions'] = "everyone.show=1\neveryone.view=1\nadmin.add=1\nadmin.edit=1\nadmin.delete=1";

$o = 1;
$field = 'locationid';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_name'] = 'Location ID';
$default_fd[$table][$field]['fd_type'] = 'readonly';
$default_fd[$table][$field]['fd_help'] = 'A unique ID for this map location - automatically assigned by the system';
$default_fd[$table][$field]['fd_mode'] = 'standard';
$default_fd[$table][$field]['fd_tabname'] = 'Location';

$field = 'mapid';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'dblist';
$default_fd[$table][$field]['fd_options'] = 'map';
$default_fd[$table][$field]['fd_name'] = 'Display on Map';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Which map this will be displayed on.';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Location';

$field = 'ml_geoloc';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'geolocgmap';
$default_fd[$table][$field]['fd_options'] = 'ml_name';
$default_fd[$table][$field]['fd_name'] = 'Location';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Lat/Long of this location';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Location';

$field = 'ml_name';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'text';
$default_fd[$table][$field]['fd_size'] = '';
$default_fd[$table][$field]['fd_name'] = 'Name';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Name of this location';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Location';

$field = 'ml_description';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'textarea';
$default_fd[$table][$field]['fd_size'] = '';
$default_fd[$table][$field]['fd_name'] = 'Description';
$default_fd[$table][$field]['fd_required'] = 'no';
$default_fd[$table][$field]['fd_help'] = 'Description or Address of this location';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Location';

$field = 'displayorder';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'integer';
$default_fd[$table][$field]['fd_size'] = '';
$default_fd[$table][$field]['fd_name'] = 'Display Order';
$default_fd[$table][$field]['fd_required'] = 'no';
$default_fd[$table][$field]['fd_help'] = '';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Location';