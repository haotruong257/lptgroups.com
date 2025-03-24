<?php
$db = db_connect('default');
$dbprefix = get_db_prefix();

if ($db->tableExists($dbprefix . 'fleet_vehicles')) {
    $db->query('DROP TABLE `'.$dbprefix .'fleet_vehicles`;');
}