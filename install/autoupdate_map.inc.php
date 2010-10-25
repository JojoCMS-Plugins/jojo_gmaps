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



$table = 'map';
$default_td[$table]['td_displayname'] = 'Maps';
$default_td[$table]['td_displayfield'] = 'mp_name';
$default_td[$table]['td_orderbyfields'] = 'mp_name';
$default_td[$table]['td_topsubmit'] = 'yes';
$default_td[$table]['td_deleteoption'] = 'yes';
$default_td[$table]['td_menutype'] = 'list';
$default_td[$table]['td_defaultpermissions'] = "everyone.show=1\neveryone.view=1\nadmin.add=1\nadmin.edit=1\nadmin.delete=1";

$o = 1;
$field = 'mapid';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_name'] = 'Map ID';
$default_fd[$table][$field]['fd_type'] = 'readonly';
$default_fd[$table][$field]['fd_help'] = 'A unique ID for this map - automatically assigned by the system';
$default_fd[$table][$field]['fd_mode'] = 'standard';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_name';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'text';
$default_fd[$table][$field]['fd_size'] = '';
$default_fd[$table][$field]['fd_name'] = 'Map Name';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'A unique name for this map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_width';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'integer';
$default_fd[$table][$field]['fd_default'] = 500;
$default_fd[$table][$field]['fd_units'] = 'pixels';
$default_fd[$table][$field]['fd_name'] = 'Map Width';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'The width of this map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_height';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'integer';
$default_fd[$table][$field]['fd_default'] = 500;
$default_fd[$table][$field]['fd_units'] = 'pixels';
$default_fd[$table][$field]['fd_name'] = 'Map Height';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'The height of this map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_control';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'Small';
$default_fd[$table][$field]['fd_name'] = 'Map Control';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Use a Small or a Large map navigation control';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_streetview';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'yesno';
$default_fd[$table][$field]['fd_default'] = '1';
$default_fd[$table][$field]['fd_name'] = 'StreetView Control';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Add a StreetView control';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_zoom';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'auto';
$default_fd[$table][$field]['fd_name'] = 'Map Zoom Level';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Automatically define a zoom level based on locations or set a level';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_scale';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'no';
$default_fd[$table][$field]['fd_name'] = 'Map Scale';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Display a Scale on the map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_typecontrol';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'yes';
$default_fd[$table][$field]['fd_name'] = 'Map Type Control';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Display buttons to change the map type on the map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_type';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'Map';
$default_fd[$table][$field]['fd_name'] = 'Map Type';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Default map type';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_scroll';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'yes';
$default_fd[$table][$field]['fd_name'] = 'Mouse Scroll to Zoom';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Enable a mouse scroll-wheel to control the maps zoom';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_dragging';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'yes';
$default_fd[$table][$field]['fd_name'] = 'Mouse Drag to Pan';
$default_fd[$table][$field]['fd_required'] = 'yes';
$default_fd[$table][$field]['fd_help'] = 'Enable mouse-dragging to pan the map';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'Map';

$field = 'mp_publish';
$default_fd[$table][$field]['fd_order'] = $o++;
$default_fd[$table][$field]['fd_type'] = 'radio';
$default_fd[$table][$field]['fd_default'] = 'yes';
$default_fd[$table][$field]['fd_name'] = 'Publish';
$default_fd[$table][$field]['fd_required'] = 'no';
$default_fd[$table][$field]['fd_help'] = 'Should this map be published so search engines can find it?';
$default_fd[$table][$field]['fd_mode'] = 'basic';
$default_fd[$table][$field]['fd_tabname'] = 'SEO';