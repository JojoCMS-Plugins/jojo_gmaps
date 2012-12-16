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

class JOJO_Plugin_jojo_gmaps extends JOJO_Plugin
{
    public static function mapfilter($content)
    {
        if (strpos($content, '[[gmap:') === false) {
            return $content;
        }
        global $smarty;
        /* Find all [[gmap:map name]] tags */
        preg_match_all('/\[\[gmap:([^\]]*)\]\]/', $content, $matches);
        if ($matches[0]) {
            foreach($matches[1] as $id => $match) {

                /* Find the map in the database */
                $map = Jojo::selectRow('SELECT * FROM {map} WHERE mp_name = ? or mapid = ?', array(trim($match),trim($match)));
                if (!$map) {
                    $content = str_replace($matches[0][$id], "Map '$match' not found", $content);
                    continue;
                }
                $map['name'] = htmlspecialchars($map['mp_name'], ENT_COMPAT, 'UTF-8', false);

                $maplocations = Jojo::selectQuery('SELECT * FROM {maplocation} WHERE mapid = ? ORDER BY ml_name', $map['mapid']);
                usort($maplocations, array('JOJO_Plugin_jojo_gmaps', 'ordersort'));
                foreach ($maplocations as &$ml) {
                    $ml['name'] = htmlspecialchars($ml['ml_name'], ENT_COMPAT, 'UTF-8', false);
                    $ml['description'] = nl2br(htmlspecialchars($ml['ml_description'], ENT_COMPAT, 'UTF-8', false));
                }

                /* Create url to KML file */
                $url = _SITEURL . '/'. JOJO_Plugin_jojo_gmaps_kml::_getPrefix() . '/' . urlencode(strtolower($map['mp_name'])) . '.kml';

                $smarty->assign('kmlurl', $url);
                $map['mapunit_w'] = is_numeric($map['mp_width']) ? 'px' : '';
                $map['mapunit_h'] = is_numeric($map['mp_height']) ? 'px' : '';
                $smarty->assign('map', $map);
                $smarty->assign('mapLocations', $maplocations);
                $smarty->assign('mapid', $map['mapid']);

                /* Get the map html */
                $html = $smarty->fetch('jojo_gmap.tpl');
                $content = str_replace($matches[0][$id], $html, $content);
            }
        }
        return $content;
    }

    private static function ordersort($a, $b)
    {
         if (isset($a['displayorder'])) {
            return strnatcasecmp($a['displayorder'],$b['displayorder']);
         }
    }

}
