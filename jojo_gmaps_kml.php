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

class JOJO_Plugin_jojo_gmaps_kml extends JOJO_Plugin
{
    public function _getContent()
    {
        global $smarty;
        $content = array();

        /* Find the map in the database */
        $res = Jojo::selectQuery('SELECT * FROM {map} WHERE mp_publish = "yes" AND LOWER(mp_name) = ?', Util::getFormData('mapname'));
        if (!isset($res[0])) {
            $content['content'] = "Map not found or not published.";
            return $content;
        }
        $map = $res[0];

        /* Get points on the map */
        $mapLocations = Jojo::selectQuery('SELECT * FROM {maplocation} WHERE mapid = ?', $map['mapid']);
        foreach($mapLocations as $k => $v) {
            $parts = explode(',', $v['ml_geoloc']);
            $mapLocations[$k]['lat'] = $parts[0];
            $mapLocations[$k]['long'] = $parts[1];
            $mapLocations[$k]['description'] = $this->_rssEscape(nl2br($v['ml_description']));
        }
        $smarty->assign('map', $map);
        $smarty->assign('mapid', $map['mapid']);
        $smarty->assign('mapLocations', $mapLocations);

        /* Get the georss xml */
        $xml = $smarty->fetch('jojo_gmaps_kml.tpl');

        /* Output xml */
        header('Content-type: application/xml');
        echo $xml;
        exit;
    }

    /**
     * Get the url prefix for a particular part of this plugin
     */
    public static function _getPrefix($for = 'georss') {
        static $_cache;

        if (!isset($_cache[$for])) {
            $query = 'SELECT pg_url FROM {page} WHERE pg_link = ?;';
            $values = false;
            if ($for == 'georss') {
                $values = array('JOJO_Plugin_Jojo_gmaps_kml');
            }

            if ($values) {
                $res = Jojo::selectQuery($query, $values);
                if (isset($res[0])) {
                    $_cache[$for] = $res[0]['pg_url'];
                    return $_cache[$for];
                }
            }
            $_cache[$for] = '';
        }

        return $_cache[$for];
    }

    /**
     * Return the url we expect this page to be
     */
    public function getCorrectUrl()
    {
        /* Act like a file, not a folder */
        $url = parent::getCorrectUrl() . urlencode(Util::getFormData('mapname')) . '.kml';
        return $url;
    }

    /**
     * XML Sitemap filter
     *
     * Receives existing sitemap and adds article pages
     */
    public static function xmlsitemap($sitemap)
    {
        /* Get maps from database */
        $maps = Jojo::selectQuery('SELECT * FROM {map} WHERE mp_publish = "yes"');

        /* Add maps to sitemap */
        foreach($maps as $m) {
            $url = _SITEURL . '/'. JOJO_Plugin_jojo_gmaps_kml::_getPrefix() . '/' . urlencode(strtolower($m['mp_name'])) . '.kml';
            $priority = 0.6;
            $sitemap[$url] = array($url, time(), 'weekly', $priority);
        }

        /* Return sitemap */
        return $sitemap;
    }

    /**
     * Escape a string so it's RSS feed friendly
     */
    private static function _rssEscape($data) {
        return str_replace('<', '&lt;', str_replace('>', '&gt;', str_replace('"', '&quot;', str_replace('&', '&amp;', $data))));
    }
}