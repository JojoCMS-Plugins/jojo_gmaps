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

// Edit Maps
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_url = 'admin/edit/map'");
if (count($data) == 0) {
    echo "Adding <b>Edit Maps</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title = 'Edit Maps', pg_link = 'Jojo_Plugin_Admin_Edit', pg_url = 'admin/edit/map', pg_parent = ?, pg_order=10", array($_ADMIN_CONTENT_ID));
}

// Edit Map Locations
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_url = 'admin/edit/maplocation'");
if (count($data) == 0) {
    echo "Adding <b>Edit Locations</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title = 'Edit Map Locations', pg_link = 'Jojo_Plugin_Admin_Edit', pg_url = 'admin/edit/maplocation', pg_parent = ?, pg_order=11", array($_ADMIN_CONTENT_ID));
}

// Maps KML feed
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_link = 'JOJO_Plugin_Jojo_gmaps_kml'");
if (count($data) == 0) {
    echo "Adding <b>Maps GeoRSS</b> Page<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title = 'Maps KML', pg_link = 'JOJO_Plugin_Jojo_gmaps_kml', pg_url = 'maps/kml', pg_parent = ?", array($_NOT_ON_MENU_ID));
}