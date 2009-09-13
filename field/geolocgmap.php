<?php
/**
 *
 * Copyright 2007 Michael Holt <code@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

class Jojo_Field_geolocgmap extends Jojo_Field
{
    var $index;
    
    function __construct($fielddata = array())
    {
        parent::__construct($fielddata);
    }

    function setValue($newvalue)
    {
        $this->value = implode(',', array($newvalue['lat'], $newvalue['long']));
        return true;
    }

    function displayedit()
    {
        global $smarty;

        $geoloc = explode(',', $this->value);

        if ( ($this->index == 0) and ($this->index == '0') and ($this->index != '') ) {$suffix = "_".$this->index;} else {$suffix = "";}
        $displayvalue = $this->value == 0 ? '' : $this->value;

        $smarty->assign('fieldname', "fm_" . $this->fd_field . $suffix);
        $smarty->assign('option', "fm_" . $this->fd_options . $suffix);
        $smarty->assign('fieldvalue', $geoloc);
        return $smarty->fetch('field/geoloc-gmap.tpl');
    }
}