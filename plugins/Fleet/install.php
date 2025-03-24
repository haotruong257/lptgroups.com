<?php
$db = db_connect('default');
$dbprefix = get_db_prefix();

/**
 * Add setting
 *
 * @since  Version 1.0.0
 *
 * @param string  $name      Option name (required|unique)
 * @param string  $value     Option value
 *
 */

if (!function_exists('add_setting')) {

  function add_setting($name, $value = '')
  {
      if (!setting_exists($name)) {
        $db = db_connect('default');
        $db_builder = $db->table(get_db_prefix() . 'settings');
        $newData = [
                'setting_name'  => $name,
                'setting_value' => $value,
            ];

        $db_builder->insert($newData);

        $insert_id = $db->insertID();

        if ($insert_id) {
            return true;
        }

        return false;
      }

      return false;
  }
}

/**
 * @since  1.0.0
 * Check whether an setting exists
 *
 * @param  string $name setting name
 *
 * @return boolean
 */
if (!function_exists('setting_exists')) {

  function setting_exists($name)
  { 
   
    $db = db_connect('default');
    $db_builder = $db->table(get_db_prefix() . 'settings');

    $count = $db_builder->where('setting_name', $name)->countAllResults();

    return $count > 0;
  }
}

if (!$db->tableExists($dbprefix . 'fleet_vehicle_groups')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_vehicle_groups (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_vehicle_types')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_vehicle_types (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_vehicles')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_vehicles (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `vehicle_type_id` int(11) NULL,
      `vehicle_group_id` int(11) NULL,
      `status` TEXT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('fleet_is_driver' ,$dbprefix . 'users')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "users`
    ADD COLUMN `fleet_is_driver` INT(11) NULL DEFAULT 0;");
}


if (!$db->fieldExists('model' ,$dbprefix . 'fleet_vehicles')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_vehicles`
    ADD COLUMN `model` TEXT NULL,
    ADD COLUMN `year` TEXT NULL;
    ");
}

if (!$db->fieldExists('width' ,$dbprefix . 'fleet_vehicles')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_vehicles`
    ADD COLUMN `width` TEXT NULL,
    ADD COLUMN `height` TEXT NULL,
    ADD COLUMN `length` TEXT NULL,
    ADD COLUMN `interior_volume` TEXT NULL,
    ADD COLUMN `passenger_volume` TEXT NULL,
    ADD COLUMN `cargo_volume` TEXT NULL,
    ADD COLUMN `ground_clearance` TEXT NULL,
    ADD COLUMN `bed_length` TEXT NULL,
    ADD COLUMN `curb_weight` TEXT NULL,
    ADD COLUMN `gross_vehicle_weight_rating` TEXT NULL,
    ADD COLUMN `towing_capacity` TEXT NULL,
    ADD COLUMN `max_payload` TEXT NULL,
    ADD COLUMN `epa_city` TEXT NULL,
    ADD COLUMN `epa_highway` TEXT NULL,
    ADD COLUMN `epa_combined` TEXT NULL,
    ADD COLUMN `oil_capacity` TEXT NULL;
    ");
}

if (!$db->fieldExists('in_service_date' ,$dbprefix . 'fleet_vehicles')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_vehicles`
    ADD COLUMN `in_service_date` DATE NULL,
    ADD COLUMN `in_service_odometer` INT(11) NULL,
    ADD COLUMN `estimated_service_life_in_months` TEXT NULL,
    ADD COLUMN `estimated_service_life_in_meter` TEXT NULL,
    ADD COLUMN `estimated_resale_value` TEXT NULL,
    ADD COLUMN `out_of_service_date` DATE NULL,
    ADD COLUMN `out_of_service_odometer` INT(11) NULL;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_driver_documents')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_driver_documents (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `driver_id` int(11) NOT NULL DEFAULT 0,
      `subject` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_vehicle_assignments')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_vehicle_assignments (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `driver_id` int(11) NOT NULL,
      `vehicle_id` int(11) NOT NULL,
      `start_time` DATETIME NULL,
      `starting_odometer` FLOAT NULL,
      `end_time` DATETIME NULL,
      `ending_odometer` FLOAT NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}


if (!$db->tableExists($dbprefix . 'fleet_maintenances')) {
  $db->query('CREATE TABLE ' . $dbprefix .'fleet_maintenances (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `vehicle_id` INT(11) NULL,
    `supplier_id` INT(11) NULL,
    `maintenance_type` varchar(30) NULL,
    `title` varchar(250) NULL,
    `warranty_improvement` INT(11) NOT NULL DEFAULT 0,
    `start_date` DATE NULL,
    `completion_date` DATE NULL,
    `cost` DECIMAL(15,2) NULL,
    `notes` text NULL,
    `date_creator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`));');
}

if (!$db->tableExists($dbprefix . 'fleet_garages')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_garages (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `country` TEXT NULL,
      `city` varchar(100) NULL,
      `zip` varchar(15) NULL,
      `state` varchar(50) NULL,
      `address` TEXT NULL,
      `notes` TEXT NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_fuel_history')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_fuel_history (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `vehicle_id` INT(11) NULL,
      `vendor_id` INT(11) NULL,
      `fuel_time` DATETIME NOT NULL,
      `odometer` INT(11) NULL,
      `gallons` TEXT NULL,
      `price` DECIMAL(15,2) NULL,
      `fuel_type` TEXT NULL,
      `reference` TEXT NULL,
      `notes` TEXT NULL,
      `addedfrom` INT(11) NULL,
      `datecreated` DATETIME NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_inspection_forms')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspection_forms (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `color` TEXT NULL,
      `description` TEXT NULL,
      `addedfrom` INT(11) NULL,
      `datecreated` DATETIME NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('slug' ,$dbprefix . 'fleet_inspection_forms')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_inspection_forms`
    ADD COLUMN `slug` TEXT NULL,
    ADD COLUMN `hash` TEXT NULL;
    ");
}


if (!$db->tableExists($dbprefix . 'fleet_inspection_question_forms')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspection_question_forms (
      `questionid` int(11) NOT NULL AUTO_INCREMENT,
      `rel_id` int(11) NOT NULL,
      `rel_type` varchar(20) DEFAULT NULL,
      `question` mediumtext NOT NULL,
      `required` tinyint(1) NOT NULL DEFAULT '0',
      `question_order` int(11) NOT NULL,
      PRIMARY KEY (`questionid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_inspection_question_box')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspection_question_box (
      `boxid` int(11) NOT NULL AUTO_INCREMENT,
      `boxtype` varchar(10) NOT NULL,
      `questionid` int(11) NOT NULL,
      PRIMARY KEY (`boxid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_inspection_question_box_description')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspection_question_box_description (
      `questionboxdescriptionid` int(11) NOT NULL AUTO_INCREMENT,
      `description` mediumtext NOT NULL,
      `boxid` mediumtext NOT NULL,
      `questionid` int(11) NOT NULL,
      PRIMARY KEY (`questionboxdescriptionid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}


if (!$db->tableExists($dbprefix . 'fleet_inspections')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspections (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `vehicle_id` INT(11) NULL,
      `inspection_form_id` INT(11) NULL,
      `status` INT(11) NULL,
      `addedfrom` INT(11) NULL,
      `datecreated` DATETIME NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_inspection_results')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_inspection_results (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `inspection_id` INT(11) NULL,
      `boxid` INT(11) NULL,
      `boxdescriptionid` INT(11) NULL,
      `questionid` INT(11) NULL,
      `answer` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('commodity_group_code', $dbprefix.'item_categories')) {
  $db->query('ALTER TABLE `' . $dbprefix . "item_categories`
    ADD COLUMN `commodity_group_code` varchar(100) NULL,
    ADD COLUMN `order` int(10) NULL,
    ADD COLUMN  `display` int(1)  NULL DEFAULT '1',
    ADD COLUMN  `note` text NULL
    ;");
}

$i = count($db->query('Select * from ' . $dbprefix . 'item_categories where title = "Fleet: Parts" and commodity_group_code = "FLEET_PARTS"')->getResultArray());
if ($i == 0) {
  $db->query("INSERT INTO `" . $dbprefix . "item_categories` (`title`, `commodity_group_code`, `display`, `order`, `note`) VALUES ('Fleet: Parts', 'FLEET_PARTS', '1', '10', '');");
}

$i = count($db->query('Select * from ' . $dbprefix . 'roles where title = "Fleet: Driver"')->getResultArray());
if ($i == 0) {
  $db->query("INSERT INTO `" . $dbprefix . "roles` (`title`) VALUES ('Fleet: Driver');");
}


if (!$db->fieldExists('vin' ,$dbprefix . 'fleet_vehicles')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_vehicles`
    ADD COLUMN `vin` TEXT NULL,
    ADD COLUMN `license_plate` TEXT NULL,
    ADD COLUMN `make` TEXT NULL,
    ADD COLUMN `trim` TEXT NULL,
    ADD COLUMN `registration_state` TEXT NULL,
    ADD COLUMN `ownership` TEXT NULL,
    ADD COLUMN `color` TEXT NULL,
    ADD COLUMN `body_type` TEXT NULL,
    ADD COLUMN `body_subtype` TEXT NULL,
    ADD COLUMN `msrp` TEXT NULL,
    ADD COLUMN `purchase_vendor` INT(11) NULL,
    ADD COLUMN `purchase_date` DATE NULL,
    ADD COLUMN `purchase_price` DECIMAL(15,2) NULL,
    ADD COLUMN `odometer` INT(11) NULL,
    ADD COLUMN `notes` TEXT NULL,
    ADD COLUMN `expiration_date` DATE NULL,
    ADD COLUMN `max_meter_value` TEXT NULL,
    ADD COLUMN `engine_summary` TEXT NULL,
    ADD COLUMN `engine_brand` TEXT NULL,
    ADD COLUMN `aspiration` TEXT NULL,
    ADD COLUMN `block_type` TEXT NULL,
    ADD COLUMN `bore` TEXT NULL,
    ADD COLUMN `cam_type` TEXT NULL,
    ADD COLUMN `compression` TEXT NULL,
    ADD COLUMN `cylinders` TEXT NULL,
    ADD COLUMN `displacement` TEXT NULL,
    ADD COLUMN `fuel_induction` TEXT NULL,
    ADD COLUMN `max_hp` TEXT NULL,
    ADD COLUMN `max_torque` TEXT NULL,
    ADD COLUMN `redline_rpm` TEXT NULL,
    ADD COLUMN `stroke` TEXT NULL,
    ADD COLUMN `valves` TEXT NULL,
    ADD COLUMN `transmission_summary` TEXT NULL,
    ADD COLUMN `transmission_brand` TEXT NULL,
    ADD COLUMN `transmission_type` TEXT NULL,
    ADD COLUMN `transmission_gears` TEXT NULL,
    ADD COLUMN `drive_type` TEXT NULL,
    ADD COLUMN `brake_system` TEXT NULL,
    ADD COLUMN `front_track_width` TEXT NULL,
    ADD COLUMN `rear_track_width` TEXT NULL,
    ADD COLUMN `wheelbase` TEXT NULL,
    ADD COLUMN `front_wheel_diameter` TEXT NULL,
    ADD COLUMN `rear_wheel_diameter` TEXT NULL,
    ADD COLUMN `rear_axle` TEXT NULL,
    ADD COLUMN `front_tire_type` TEXT NULL,
    ADD COLUMN `front_tire_psi` TEXT NULL,
    ADD COLUMN `rear_tire_type` TEXT NULL,
    ADD COLUMN `rear_tire_psi` TEXT NULL,
    ADD COLUMN `fuel_type` TEXT NULL,
    ADD COLUMN `fuel_quality` TEXT NULL,
    ADD COLUMN `fuel_tank_1_capacity` TEXT NULL,
    ADD COLUMN `fuel_tank_2_capacity` TEXT NULL;
    ");

}

if (!$db->tableExists($dbprefix . 'fleet_benefit_and_penalty')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_benefit_and_penalty (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `subject` TEXT NULL,
      `criteria_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `type` TEXT NULL,
      `date` DATE NULL,
      `benefit_formality` TEXT NULL,
      `reward` DECIMAL(15,2) NULL,
      `penalty_formality` TEXT NULL,
      `amount_of_damage` DECIMAL(15,2) NULL,
      `amount_of_compensation` DECIMAL(15,2) NULL,
      `notes` TEXT NULL,
      `addedfrom` INT(11) NULL,
      `datecreated` DATETIME NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_criterias')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_criterias (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_bookings')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_bookings (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `subject` TEXT NOT NULL,
      `contactid` INT(11) NULL,
      `userid` INT(11) NULL,
      `approved` INT(11) NOT NULL DEFAULT '0',
      `status` VARCHAR(45) NOT NULL DEFAULT 'new',
      `delivery_date` DATE NULL,
      `phone` TEXT NOT NULL,
      `receipt_address` TEXT NOT NULL,
      `delivery_address` TEXT NOT NULL,
      `note` TEXT NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('invoice_id' ,$dbprefix . 'fleet_bookings')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_bookings`
    ADD COLUMN `invoice_id` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('admin_note' ,$dbprefix . 'fleet_bookings')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_bookings`
    ADD COLUMN `admin_note` TEXT NULL;
    ");
}

if (!$db->fieldExists('number' ,$dbprefix . 'fleet_bookings')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_bookings`
    ADD COLUMN `number` TEXT NULL,
    ADD COLUMN `amount` DECIMAL(15,2) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('invoice_hash' ,$dbprefix . 'fleet_bookings')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_bookings`
    ADD COLUMN `invoice_hash` TEXT NULL;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_maintenance_teams')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_maintenance_teams (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `staffid` INT(11) NULL,
      `garage_id` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('garage_id' ,$dbprefix . 'fleet_maintenances')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_maintenances`
    ADD COLUMN `garage_id` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_logbooks')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_logbooks (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `vehicle_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `booking_id` INT(11) NULL,
      `odometer` INT(11) NULL,
      `status` VARCHAR(45) NOT NULL DEFAULT 'new',
      `date` DATE NULL,
      `description` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('name' ,$dbprefix . 'fleet_logbooks')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_logbooks`
    ADD COLUMN `name` TEXT NOT NULL;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_time_cards')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_time_cards (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `logbook_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `start_time` TEXT NOT NULL,
      `end_time` TEXT NOT NULL,
      `notes` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_insurances')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_insurances (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `vehicle_id` INT(11) NULL,
      `insurance_category_id` INT(11) NULL,
      `insurance_type_id` INT(11) NULL,
      `name` TEXT NULL,
      `status` TEXT NULL,
      `start_date` DATE NOT NULL,
      `end_date` DATE NOT NULL,
      `description` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('amount' ,$dbprefix . 'fleet_insurances')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_insurances`
    ADD COLUMN `amount` DECIMAL(15,2) NOT NULL;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_insurance_categories')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_insurance_categories (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_insurance_types')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_insurance_types (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_events')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_events (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `subject` TEXT NOT NULL,
      `vehicle_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `event_type` TEXT NOT NULL,
      `event_time` DATETIME NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_work_orders')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_work_orders (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `subject` TEXT NOT NULL,
      `number` TEXT NULL,
      `vehicle_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `vendor_id` INT(11) NULL,
      `invoice_id` INT(11) NULL,
      `purchase_order_id` INT(11) NULL,
      `status` VARCHAR(45) NOT NULL DEFAULT 'open',
      `issue_date` DATE NULL,
      `start_date` DATE NULL,
      `complete_date` DATE NULL,
      `odometer_in` INT(11) NULL,
      `odometer_out` INT(11) NULL,
      `total` DECIMAL(15,2) NULL,
      `work_requested` TEXT NULL,
      `notes` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}


if (!$db->tableExists($dbprefix . 'fleet_work_order_details')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_work_order_details (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `work_order_id` INT(11) NULL,
      `part_id` INT(11) NULL,
      `item_name` TEXT NULL,
      `qty` INT(11) NULL,
      `price` DECIMAL(15,2) NULL,
      `total` DECIMAL(15,2) NULL,
      `description` TEXT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('parts' ,$dbprefix . 'fleet_maintenances')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_maintenances`
    ADD COLUMN `parts` TEXT NULL;
    ");
}

if (!$db->fieldExists('from_fleet' ,$dbprefix . 'invoices')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "invoices`
    ADD COLUMN `from_fleet` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('from_fleet' ,$dbprefix . 'expenses')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "expenses`
    ADD COLUMN `from_fleet` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('rating' ,$dbprefix . 'fleet_bookings')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_bookings`
    ADD COLUMN `rating` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `comments` TEXT NULL;
    ");
}

if (!$db->fieldExists('expense_id' ,$dbprefix . 'fleet_work_orders')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_work_orders`
    ADD COLUMN `expense_id` INT(11) NOT NULL DEFAULT 0;
    ");
}

$i = count($db->query('Select * from ' . $dbprefix . 'expense_categories where title = "Fleet: Work Order"')->getResultArray());
if ($i == 0) {
  $db->query("INSERT INTO `" . $dbprefix . "expense_categories` (`title`) VALUES ('Fleet: Work Order');");
}


if (!$db->fieldExists('type' ,$dbprefix . 'fleet_driver_documents')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_driver_documents`
    ADD COLUMN `type` VARCHAR(45) NOT NULL DEFAULT 'driver',
    ADD COLUMN `vehicle_id` INT(11) NOT NULL DEFAULT 0;
    ");
}


if (!$db->tableExists($dbprefix . 'fleet_part_groups')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_part_groups (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_part_types')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_part_types (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_parts')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_parts (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `part_type_id` INT(11) NULL,
      `brand` TEXT NULL,
      `model` TEXT NULL,
      `serial_number` TEXT NULL,
      `vehicle_id` INT(11) NOT NULL DEFAULT 0,
      `driver_id` INT(11) NOT NULL DEFAULT 0,
      `part_group_id` INT(11) NULL,
      `status` TEXT NULL,
      `purchase_vendor` INT(11) NULL,
      `purchase_date` DATE NULL,
      `purchase_price` DECIMAL(15,2) NULL,
      `warranty_expiration_date` DATE NULL,
      `purchase_comments` TEXT NULL,
      `in_service_date` DATE NULL,
      `estimated_service_life_in_months` INT(11) NULL,
      `estimated_resale_value` DECIMAL(15,2) NULL,
      `out_of_service_date` DATE NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_part_histories')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_part_histories (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `part_id` INT(11) NOT NULL,
      `type` TEXT NOT NULL,
      `vehicle_id` INT(11) NULL,
      `driver_id` INT(11) NULL,
      `start_time` TEXT NULL,
      `end_time` TEXT NULL,
      `start_by` INT(11) NULL,
      `end_by` INT(11) NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('parts' ,$dbprefix . 'fleet_work_orders')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_work_orders`
    ADD COLUMN `parts` TEXT NULL;
    ");
}


if (!$db->tableExists($dbprefix . 'fleet_insurance_status')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_insurance_status (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->tableExists($dbprefix . 'fleet_insurance_company')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_insurance_company (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` TEXT NOT NULL,
      `description` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}


if (!$db->fieldExists('insurance_company_id' ,$dbprefix . 'fleet_insurances')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_insurances`
    ADD COLUMN `insurance_company_id` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `insurance_status_id` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->tableExists($dbprefix . 'fleet_vehicle_histories')) {
    $db->query('CREATE TABLE ' . $dbprefix . "fleet_vehicle_histories (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `vehicle_id` INT(11) NOT NULL,
      `type` TEXT NOT NULL,
      `from_value` TEXT NULL,
      `to_value` TEXT NULL,
      `datecreated` DATETIME NULL,
      `addedfrom` INT(11) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $db->charset . ';');
}

if (!$db->fieldExists('is_fail' ,$dbprefix . 'fleet_inspection_question_box_description')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_inspection_question_box_description`
    ADD COLUMN `is_fail` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('recurring' ,$dbprefix . 'fleet_inspection_forms')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_inspection_forms`
    ADD COLUMN `recurring` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `recurring_type` VARCHAR(10) NULL,
    ADD COLUMN `custom_recurring` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `cycles` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `total_cycles` INT(11) NOT NULL DEFAULT 0;
    ");
}

if (!$db->fieldExists('recurring' ,$dbprefix . 'fleet_inspections')) { 
  $db->query('ALTER TABLE `' . $dbprefix . "fleet_inspections`
    ADD COLUMN `recurring` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `recurring_type` VARCHAR(10) NULL,
    ADD COLUMN `custom_recurring` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `cycles` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `total_cycles` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `is_recurring_from` INT(11) NOT NULL DEFAULT 0,
    ADD COLUMN `last_recurring_date` DATE NULL;
    ");
}

if (!$db->fieldExists('fleet_vehicle_id', $dbprefix.'notifications')) {
  $db->query('ALTER TABLE `' . $dbprefix . "notifications`
    ADD COLUMN `fleet_vehicle_id` int(1) NOT NULL DEFAULT '0',
    ADD COLUMN `fleet_logbook_id` int(1) NOT NULL DEFAULT '0'
    ;");
}