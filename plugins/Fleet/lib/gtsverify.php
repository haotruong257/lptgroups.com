<?php
require_once __DIR__ .'/gtsslib.php';
global $item_purchase_code;
$license_code = strip_tags(trim($item_purchase_code));
$client_name = 'risecrm';
$lic_accounting = new FleetLic();
//$activate_response = $lic_accounting->activate_license($license_code, $client_name);
$msg = 'Code fix';
$status = true;