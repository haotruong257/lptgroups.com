<?php
$db = db_connect('default');
$dbprefix = get_db_prefix();

if ($db->tableExists($dbprefix . 'evaluation_criteria_details')) {
    $db->query('DROP TABLE `'.$dbprefix .'evaluation_criteria_details`;');
}

if ($db->tableExists($dbprefix . 'evaluation_criteria')) {
    $db->query('DROP TABLE `'.$dbprefix .'evaluation_criteria`;');
}

if ($db->tableExists($dbprefix . 'evaluation_criteria_categories')) {
    $db->query('DROP TABLE `'.$dbprefix .'evaluation_criteria_categories`;');
}