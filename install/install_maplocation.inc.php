<?php

$table = 'maplocation';
$query = "
CREATE TABLE {maplocation} (
      `locationid` bigint(20) NOT NULL auto_increment,
      `mapid` int(11) NOT NULL,
      `ml_geoloc` text,
      `ml_name` varchar(255) NOT NULL,
      `ml_description` text NOT NULL,
      PRIMARY KEY  (`locationid`),
      KEY `mapid` (`mapid`)
    ) TYPE=MyISAM;";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) {
    foreach ($result['different'] as $col => $v) {
        echo sprintf("<div class='error'><font color='red'>Table <b>%s</b> column <b>%s</b> exists but is different to expected - resolve this manually.</font></div>", $table, $col);
        echo sprintf("&nbsp;&nbsp;&nbsp;&nbsp;Found: %s<br/>&nbsp;&nbsp;&nbsp;&nbsp;Expected: %s<br/>", $v['found'], $v['expected']);
    }
}