<?php

$table = 'map';
$query = "
CREATE TABLE {map} (
      `mapid` int(11) NOT NULL auto_increment,
      `mp_name` varchar(255) NOT NULL,
      `mp_width` varchar(11) NOT NULL,
      `mp_height` varchar(11) NOT NULL,
      `mp_publish` enum('yes','no') NOT NULL,
      `mp_control` enum('Small','Large','None') NOT NULL,
      `mp_streetview` tinyint(1) default '1',
      `mp_zoom` enum('auto','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16') NOT NULL,
      `mp_scale` enum('yes','no') NOT NULL,
      `mp_typecontrol` enum('yes','no') NOT NULL,
      `mp_type` enum('Map','Satellite','Hybrid','Terrain') NOT NULL,
      `mp_scroll` enum('yes','no') NOT NULL,
      `mp_dragging` enum('yes','no') NOT NULL,
      PRIMARY KEY  (`mapid`)
    ) TYPE=MyISAM;";

/* Check table structure */
$result = JOJO::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);
