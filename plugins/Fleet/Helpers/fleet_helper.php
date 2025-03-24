<?php
use App\Controllers\Security_Controller;
use Fleet\Controllers\Fleet;

/**
 * Handles upload for driver documents
 * @param  mixed $id expense id
 * @return void
 */
function handle_driver_document_attachments($id)
{
    if (!isset($_FILES['file'])) {
        return false;
    }

    $path = FLEET_MODULE_UPLOAD_FOLDER . '/driver_documents/' . $id . '/';

    if (isset($_FILES['file']['name'])) {

        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            _maybe_create_upload_path($path);
            $filename    = $_FILES['file']['name'];
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $attachment   = [];
                $attachment[] = [
                    'file_name' => $filename,
                    'filetype'  => $_FILES['file']['type'],
                    ];

                $Fleet_model = model("Fleet\Models\Fleet_model");
                $Fleet_model->add_attachment_to_database($id, 'fle_driver_document', $attachment);
            }
        }
    }
}


/**
 * render booking status html
 * @param  [type]  $id           
 * @param  [type]  $type         
 * @param  string  $status_value 
 * @param  boolean $ChangeStatus 
 * @return [type]                
 */
function fleet_render_status_html($id, $type, $status_value = '', $ChangeStatus = true)
{
    $status = '';
    $statuses = [];
    if($type == 'booking'){
        $statuses = fleet_booking_status();
    }else if($type == 'logbook'){
        $statuses = fleet_logbook_status();
    }else if($type == 'work_order'){
        $statuses = fleet_work_order_status();
    }else{
        $statuses = fleet_booking_status();
    }

    foreach ($statuses as $s) {
        if ($s['id'] == $status_value) {
            $status = $s;
            break;
        }
    }

    $outputStatus    = '';

    $outputStatus .= '<span class="inline-block badge" style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '" task-status-table="' . $status_value . '">';
    $outputStatus .= $status['name'];
    $canChangeStatus = (has_permission('service_management', '', 'edit') || is_admin());

    if ($canChangeStatus && $ChangeStatus) {
        $outputStatus .= '<div class="dropdown inline-block mleft5 table-export-exclude">';
        $outputStatus .= '<a href="#" class="dropdown-toggle text-dark dropdown-font-size" id="tableTaskStatus-' . $id . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $outputStatus .= '<span data-toggle="tooltip" title="' . _l('ticket_single_change_status') . '"><i data-feather="chevron-down" class="icon-14"></i></span>';
        $outputStatus .= '</a>';

        $outputStatus .= '<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="tableTaskStatus-' . $id . '">';
        foreach ($statuses as $taskChangeStatus) {
            if ($status_value != $taskChangeStatus['id']) {
                $outputStatus .= '<li class="p-2">
                <a href="#" onclick="'.$type.'_status_mark_as(\'' . $taskChangeStatus['id'] . '\',' . $id . '); return false;">
                ' . sprintf(_l('task_mark_as'), $taskChangeStatus['name']) . '
                </a>
                </li>';
            }
        }
        $outputStatus .= '</ul>';
        $outputStatus .= '</div>';
    }

    $outputStatus .= '</span>';

    return $outputStatus;
}

/**
 * booking status
 * @param  string $status 
 * @return [type]         
 */
function fleet_booking_status()
{
    $statuses = [

        [
            'id'             => 'new',
            'color'          => '#2196f3',
            'name'           => _l('new'),
            'order'          => 1,
            'filter_default' => false,
        ],
        [
            'id'             => 'approved',
            'color'          => '#3db8da',
            'name'           => _l('approved'),
            'order'          => 2,
            'filter_default' => false,
        ],
        [
            'id'             => 'rejected',
            'color'          => '#dc3545',
            'name'           => _l('rejected'),
            'order'          => 3,
            'filter_default' => true,
        ],
        [
            'id'             => 'processing',
            'color'          => '#3b82f6',
            'name'           => _l('processing'),
            'order'          => 4,
            'filter_default' => false,
        ],
        [
            'id'             => 'complete',
            'color'          => '#84c529',
            'name'           => _l('complete'),
            'order'          => 5,
            'filter_default' => false,
        ],
        [
            'id'             => 'cancelled',
            'color'          => '#d71a1a',
            'name'           => _l('cancelled'),
            'order'          => 6,
            'filter_default' => false,
        ],
        
    ];

    usort($statuses, function ($a, $b) {
        return $a['order'] - $b['order'];
    });

    return $statuses;
}


/**
 * logbook status
 * @param  string $status 
 * @return [type]         
 */
function fleet_logbook_status()
{

    $statuses = [

        [
            'id'             => 'new',
            'color'          => '#2196f3',
            'name'           => _l('new'),
            'order'          => 1,
            'filter_default' => false,
        ],
        [
            'id'             => 'processing',
            'color'          => '#3b82f6',
            'name'           => _l('processing'),
            'order'          => 2,
            'filter_default' => false,
        ],
        [
            'id'             => 'complete',
            'color'          => '#84c529',
            'name'           => _l('complete'),
            'order'          => 3,
            'filter_default' => false,
        ],
        [
            'id'             => 'cancelled',
            'color'          => '#d71a1a',
            'name'           => _l('cancelled'),
            'order'          => 4,
            'filter_default' => false,
        ],
        
    ];

    usort($statuses, function ($a, $b) {
        return $a['order'] - $b['order'];
    });

    return $statuses;
}

/**
 * work_order status
 * @param  string $status 
 * @return [type]         
 */
function fleet_work_order_status()
{

    $statuses = [

        [
            'id'             => 'open',
            'color'          => '#2196f3',
            'name'           => _l('open'),
            'order'          => 1,
            'filter_default' => false,
        ],
        [
            'id'             => 'in_progress',
            'color'          => '#3b82f6',
            'name'           => _l('in_progress'),
            'order'          => 2,
            'filter_default' => false,
        ],
        [
            'id'             => 'parts_ordered',
            'color'          => '#ffa500',
            'name'           => _l('parts_ordered'),
            'order'          => 3,
            'filter_default' => false,
        ],
        [
            'id'             => 'complete',
            'color'          => '#84c529',
            'name'           => _l('complete'),
            'order'          => 4,
            'filter_default' => false,
        ],
        
    ];

    usort($statuses, function ($a, $b) {
        return $a['order'] - $b['order'];
    });

    return $statuses;
}

/**
     * [new_html_entity_decode description]
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
if (!function_exists('new_html_entity_decode')) {
    
    function new_html_entity_decode($str){
        return html_entity_decode($str ?? '');
    }
}


/**
 * Gets the part name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_part_name_by_id')) {
    function fleet_get_part_name_by_id($id){
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $part = $Fleet_model->get_part($id);

        if($part){
            return $part->name;
        }

        return '';
    }
}

/**
 * Gets the part type name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_part_type_name_by_id')) {
    function fleet_get_part_type_name_by_id($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $part = $Fleet_model->get_data_part_types($id);

        if($part){
            return $part->name;
        }

        return '';
    }
}

/**
 * Gets the part group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_part_group_name_by_id')) {
    function fleet_get_part_group_name_by_id($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $part = $Fleet_model->get_data_part_groups($id);

        if($part){
            return $part->name;
        }

        return '';
    }
}


/**
 * Gets the vehicle name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_name_by_id')) {
    function fleet_get_vehicle_name_by_id($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $part = $Fleet_model->get_vehicle($id);

        if($part){
            return $part->name;
        }

        return '';
    }
}

/**
 * Gets the vehicle group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_group_name_by_id')) {
    function fleet_get_vehicle_group_name_by_id($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $vehicle = $Fleet_model->get_data_vehicle_groups($id);

        if($vehicle && is_object($vehicle)){
            return $vehicle->name;
        }

        return '';
    }
}

/**
 * Gets the vehicle group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_type_name_by_id')) {
    function fleet_get_vehicle_type_name_by_id($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $vehicle = $Fleet_model->get_data_vehicle_types($id);

        if($vehicle){
            return $vehicle->name;
        }

        return '';
    }
}

/**
 * Gets the vehicle group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_current_meter')) {
    function fleet_get_vehicle_current_meter($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $current_meter = $Fleet_model->get_vehicle_current_meter($id);

        if($current_meter){
            return $current_meter;
        }

        return '';
    }
}

/**
 * Gets the vehicle group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_current_meter_date')) {
    function fleet_get_vehicle_current_meter_date($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $current_meter_date = $Fleet_model->get_vehicle_current_meter_date($id);

        if($current_meter_date){
            return $current_meter_date;
        }

        return '';
    }
}


/**
 * Gets the vehicle group name by id.
 *
 * @param        $id   The id
 */
if (!function_exists('fleet_get_vehicle_current_operator')) {
    function fleet_get_vehicle_current_operator($id){
        
        $Fleet_model = model("Fleet\Models\Fleet_model");
        $current_operator = $Fleet_model->get_vehicle_current_operator($id);

        if($current_operator){
            return get_staff_full_name($current_operator);
        }

        return '';
    }
}

/**
 * get status modules wh
 * @param  string $module_name 
 * @return boolean             
 */
if (!function_exists('fleet_get_status_modules')) {
    function fleet_get_status_modules($module_name){
        $plugins = get_setting("plugins");
        $plugins = @unserialize($plugins);
        if (!($plugins && is_array($plugins))) {
            $plugins = array();
        }
        
        if(isset($plugins[$module_name]) && $plugins[$module_name] == 'activated'){
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('fleet_has_permission')) {
    function fleet_has_permission($staff_permission)
    {
        $ci = new Security_Controller(false);
        if($ci->login_user->is_admin == 1){
            return true;
        }

        $builder = db_connect('default');
        $builder = $builder->table(get_db_prefix().'roles');

        $role_id = $ci->login_user->role_id;

        $builder->where('id', $role_id);
        $role = $builder->get()->getRow();

        if(!isset($role->plugins_permissions)){
            return false;
        }

        $permissions = unserialize($role->plugins_permissions);

        if (!isset($permissions["fleet"]) ) {
            $permissions["fleet"] = array();
        }
        
        if(get_array_value($permissions["fleet"], $staff_permission)){
            return true;
        }
        return false;
    }
}

if (!function_exists('_get_invoice_value_calculation_query')) {
 function _get_invoice_value_calculation_query($invoices_table) {
        $select_invoice_value = "IFNULL(items_table.invoice_value,0)";

        $after_tax_1 = "(IFNULL(tax_table.percentage,0)/100*$select_invoice_value)";
        $after_tax_2 = "(IFNULL(tax_table2.percentage,0)/100*$select_invoice_value)";
        $after_tax_3 = "(IFNULL(tax_table3.percentage,0)/100*$select_invoice_value)";

        $discountable_invoice_value = "IF($invoices_table.discount_type='after_tax', (($select_invoice_value + $after_tax_1 + $after_tax_2) - $after_tax_3), $select_invoice_value )";

        $discount_amount = "IF($invoices_table.discount_amount_type='percentage', IFNULL($invoices_table.discount_amount,0)/100* $discountable_invoice_value, $invoices_table.discount_amount)";

        $before_tax_1 = "(IFNULL(tax_table.percentage,0)/100* ($select_invoice_value- $discount_amount))";
        $before_tax_2 = "(IFNULL(tax_table2.percentage,0)/100* ($select_invoice_value- $discount_amount))";
        $before_tax_3 = "(IFNULL(tax_table3.percentage,0)/100* ($select_invoice_value- $discount_amount))";

        $invoice_value_calculation_query = "(
                $select_invoice_value+
                IF($invoices_table.discount_type='before_tax',  (($before_tax_1+ $before_tax_2) - $before_tax_3), (($after_tax_1 + $after_tax_2) - $after_tax_3))
                - $discount_amount
               )";

        return $invoice_value_calculation_query;
    }
}

if (!function_exists('fleet_log_notification')) {

        function fleet_log_notification($event, $options = array(), $user_id = 0, $to_user_id = 0) {
            $ci = new Security_Controller(false);

            //send direct notification to the url
            $data = array(
                "event" => $event
            );

            if ($user_id) {
                $data["user_id"] = $user_id;
            } else if ($user_id === "0") {
                $data["user_id"] = $user_id; //if user id is 0 (string) we'll assume that it's system bot 
            } else if (isset($ci->login_user->id)) {
                $data["user_id"] = $ci->login_user->id;
            }

            $data['to_user_id'] = $to_user_id;

            foreach ($options as $key => $value) {
                $value = urlencode($value);
                $data[$key] = $value;
            }

            $Fleet = new Fleet();
            $Fleet->fleet_create_notification($data);
        }
    }

if (!function_exists('get_client_user_id')) {

  function get_client_user_id()
  { 
    $ci = new Security_Controller(false);
    if($ci->login_user->user_type == 'client'){
        return $ci->login_user->client_id;
    }

    return 0;
  }
}

if (!function_exists('get_contact_user_id')) {

  function get_contact_user_id()
  { 
    $ci = new Security_Controller(false);
    if($ci->login_user->user_type == 'client'){
        return $ci->login_user->id;
    }

    return 0;
  }
}
