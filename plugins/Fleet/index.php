<?php


/*
  Plugin Name: Fleet Management
  Description: One place to manage and maintain your fleet
  Version: 1.0.0
  Requires at least: 3.0
  Author: GreenTech Solutions
 */
use App\Controllers\Security_Controller;

app_hooks()->add_action('app_hook_head_extension', 'fleet_add_head_component');
app_hooks()->add_action('app_hook_head_extension', 'fleet_load_js');

app_hooks()->add_action("app_hook_role_permissions_extension", 'fleet_permissions');
app_hooks()->add_filter("app_filter_role_permissions_save_data", 'save_fleet_permissions');

define('FLEET_MODULE_UPLOAD_FOLDER', 'plugins/Fleet/uploads');
define('FLEET_REVISION', 100);

  //add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {

    $fleet_submenu = array();
    $ci = new Security_Controller(false);
    $permissions = $ci->login_user->permissions;

    if (fleet_has_permission('fleet_can_view_dashboard') || fleet_has_permission('fleet_can_view_vehicle') || fleet_has_permission('fleet_can_view_transaction') || fleet_has_permission('fleet_can_view_driver') || fleet_has_permission('fleet_can_view_work_performance') || fleet_has_permission('fleet_can_view_benefit_and_penalty') || fleet_has_permission('fleet_can_view_event') || fleet_has_permission('fleet_can_view_work_orders') || fleet_has_permission('fleet_can_view_garage') || fleet_has_permission('fleet_can_view_maintenance') || fleet_has_permission('fleet_can_view_fuel') || fleet_has_permission('fleet_can_view_part') || fleet_has_permission('fleet_can_view_insurance') || fleet_has_permission('fleet_can_view_inspection') || fleet_has_permission('fleet_can_view_bookings') || fleet_has_permission('fleet_can_view_report') || fleet_has_permission('fleet_can_view_setting')) {
        
        if (fleet_has_permission('fleet_can_view_dashboard')) {
            $fleet_submenu["fleet_dashboard"] = array(
                "name" => "menu_dashboard", 
                "url" => "fleet/dashboard", 
                "class" => "home"
            );
        }
        
        if (fleet_has_permission('fleet_can_view_vehicle')) {
            $fleet_submenu["fleet_vehicle"] = array(
                "name" => "menu_vehicle", 
                "url" => "fleet/vehicles", 
                "class" => "truck"
            );
        }

        if (fleet_has_permission('fleet_can_view_transaction')) {
            $fleet_submenu["fleet_transaction"] = array(
                "name" => "menu_transaction", 
                "url" => "fleet/transactions?group=invoices", 
                "class" => "list"
            );
        }

        if (fleet_has_permission('fleet_can_view_driver')) {
            $fleet_submenu["fleet_driver"] = array(
                "name" => "menu_driver", 
                "url" => "fleet/drivers", 
                "class" => "user"
            );
        }

        if (fleet_has_permission('fleet_can_view_work_performance')) {
            $fleet_submenu["fleet_work_performance"] = array(
                "name" => "menu_work_performance", 
                "url" => "fleet/work_performances", 
                "class" => "line-chart"
            );
        }

        if (fleet_has_permission('fleet_can_view_benefit_and_penalty')) {
            $fleet_submenu["fleet_benefit_and_penalty"] = array(
                "name" => "menu_benefit_and_penalty", 
                "url" => "fleet/benefit_and_penalty", 
                "class" => "newspaper"
            );
        }

        if (fleet_has_permission('fleet_can_view_event')) {
            $fleet_submenu["fleet_event"] = array(
                "name" => "menu_event", 
                "url" => "fleet/events", 
                "class" => "newspaper"
            );
        }

        if (fleet_has_permission('fleet_can_view_work_orders')) {
            $fleet_submenu["fleet_work_orders"] = array(
                "name" => "menu_work_orders", 
                "url" => "fleet/work_orders", 
                "class" => "bill"
            );
        }

        if (fleet_has_permission('fleet_can_view_garage')) {
            $fleet_submenu["fleet_garage"] = array(
                "name" => "menu_garage", 
                "url" => "fleet/garages", 
                "class" => "home"
            );
        }

        if (fleet_has_permission('fleet_can_view_maintenance')) {
            $fleet_submenu["fleet_maintenance"] = array(
                "name" => "menu_maintenance", 
                "url" => "fleet/maintenances", 
                "class" => "wrench"
            );
        }

        if (fleet_has_permission('fleet_can_view_fuel')) {
            $fleet_submenu["fleet_fuel"] = array(
                "name" => "menu_fuel", 
                "url" => "fleet/fuels", 
                "class" => "pump"
            );
        }

        if (fleet_has_permission('fleet_can_view_part')) {
            $fleet_submenu["fleet_parts"] = array(
                "name" => "menu_parts", 
                "url" => "fleet/parts", 
                "class" => "pump"
            );
        }

        if (fleet_has_permission('fleet_can_view_insurance')) {
            $fleet_submenu["fleet_insurance"] = array(
                "name" => "menu_insurance", 
                "url" => "fleet/insurances", 
                "class" => "file"
            );
        }

        if (fleet_has_permission('fleet_can_view_inspection')) {
            $fleet_submenu["fleet_inspection"] = array(
                "name" => "menu_inspection", 
                "url" => "fleet/inspections", 
                "class" => "file"
            );
        }

        if (fleet_has_permission('fleet_can_view_booking')) {
            $fleet_submenu["fleet_bookings"] = array(
                "name" => "menu_bookings", 
                "url" => "fleet/bookings", 
                "class" => "cart"
            );
        }

        if (fleet_has_permission('fleet_can_view_report')) {
            $fleet_submenu["fleet_report"] = array(
                "name" => "menu_report", 
                "url" => "fleet/reports", 
                "class" => "chart"
            );
        }

        if (fleet_has_permission('fleet_can_view_setting')) {
            $fleet_submenu["fleet_setting"] = array(
                "name" => "menu_setting", 
                "url" => "fleet/settings?group=vehicle_groups", 
                "class" => "cog"
            );
        }

        $sidebar_menu["fleet"] = array(
            "name" => "als_fleet",
            "url" => "fleet/dashboard",
            "class" => "truck",
            "submenu" => $fleet_submenu,
            "position" => 4,
        );
    }


    return $sidebar_menu;
});


//install dependencies
register_installation_hook("Fleet", function () {
    require_once __DIR__ . '/install.php';
});

//activation
register_activation_hook("Fleet", function () {
    require_once __DIR__ . '/install.php';
});

//update plugin
register_update_hook("Fleet", function () {
    require_once __DIR__ . '/install.php';
});

//uninstallation: remove data from database
register_uninstallation_hook("Fleet", function () {
    require_once __DIR__ . '/uninstall.php';
});

app_hooks()->add_action('app_hook_fleet_init', function (){
    // Removed license verification
});

app_hooks()->add_action('app_hook_uninstall_plugin_Fleet', function (){
    // Removed license deactivation logic
});

/**
 * init add head component
 */
function fleet_add_head_component() {
    $viewuri = $_SERVER['REQUEST_URI'];

    if (!(strpos($viewuri, '/fleet_client') === false)) {
        echo '<link href="' . base_url('plugins/Fleet/assets/css/main.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }
    
    if (!(strpos($viewuri, '/fleet_client/booking_detail') === false)) {
        echo '<link href="' . base_url('plugins/Fleet/assets/css/client_style.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }


    if (!(strpos($viewuri, '/fleet/') === false)) {
        echo '<link href="' . base_url('plugins/Fleet/assets/css/main.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }


    if (!(strpos($viewuri, '/fleet/parts') === false)) {
        echo '<link href="' . base_url('plugins/Warehouse/assets/css/styles.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
        echo '<link href="' . base_url('plugins/Warehouse/assets/css/commodity_list.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }

    if (!(strpos($viewuri, '/fleet/booking_detail') === false)) {
        echo '<link href="' . base_url('plugins/Fleet/assets/css/client_style.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }

    if (!(strpos($viewuri, '/fleet/dashboard') === false)) {
        echo '<link href="' . base_url('assets/js/fullcalendar/fullcalendar.min.css')  . '?v=' . FLEET_REVISION . '"  rel="stylesheet" type="text/css" />';
    }
}

/**
 * init add footer component
 */
function fleet_load_js() {
    $viewuri = $_SERVER['REQUEST_URI'];

    if (!(strpos($viewuri, 'fleet') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/fleet_main.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=vehicle_groups') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/vehicle_groups.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=vehicle_types') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/vehicle_types.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=inspection_forms') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/inspection_forms.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=criterias') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/criterias.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=insurance_types') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/insurance_types.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=insurance_categories') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/insurance_categories.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=insurance_company') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/insurance_company.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=insurance_status') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/insurance_status.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=part_types') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/part_types.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/settings?group=part_groups') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/settings/part_groups.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/inspections') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/inspections/manage.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/parts') === false)) { 
         echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/simplelightbox/simple-lightbox.min.js') . '?v=' . FLEET_REVISION . '"></script>';
         echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/simplelightbox/simple-lightbox.jquery.min.js') . '?v=' . FLEET_REVISION . '"></script>';
         echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/simplelightbox/masonry-layout-vanilla.min.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/booking_detail') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/bookings/booking_detail.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/logbook_detail') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/work_performances/logbook_detail.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/work_order') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/work_orders/work_order.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/work_order_detail') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/work_orders/work_order_detail.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/transactions?group=invoices') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/transactions/invoices.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/transactions?group=expenses') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/transactions/expenses.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/dashboard') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/highcharts.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/variable-pie.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/export-data.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/accessibility.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/exporting.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/highcharts-3d.js') . '?v=' . FLEET_REVISION . '"></script>';

        echo '<script src="' . base_url('assets/js/fullcalendar/fullcalendar.min.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('assets/js/fullcalendar/locales-all.min.js') . '?v=' . FLEET_REVISION . '"></script>';

    
    }

    if (!(strpos($viewuri, '/fleet/fuel_report') === false) || !(strpos($viewuri, '/fleet/maintenance_report') === false) || !(strpos($viewuri, '/fleet/event_report') === false) || !(strpos($viewuri, '/fleet/work_order_report') === false) || !(strpos($viewuri, '/fleet/work_performance_report') === false) || !(strpos($viewuri, '/fleet/income_and_expense_report') === false) || !(strpos($viewuri, '/fleet/rp_') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/highcharts.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/variable-pie.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/export-data.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/accessibility.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/modules/exporting.js') . '?v=' . FLEET_REVISION . '"></script>';
        echo '<script src="' . base_url('plugins/Fleet/assets/plugins/highcharts/highcharts-3d.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/fuel_report') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/fuel_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/maintenance_report') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/maintenance_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/event_report') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/event_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/work_order_report') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/work_order_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/work_performance_report') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/work_performance_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_operating_cost_summary') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/operating_cost_summary_report.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_total_cost_trend') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/total_cost_trend.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_status_changes') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/status_changes.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_group_changes') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/group_changes.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_vehicle_assignment_log') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/vehicle_assignment_log.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_vehicle_assignment_summary') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/vehicle_assignment_summary.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_inspection_submissions_list') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/inspection_submissions_list.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_inspection_submissions_summary') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/inspection_submissions_summary.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_vehicle_list') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/vehicle_list.js') . '?v=' . FLEET_REVISION . '"></script>';
    }
    
    if (!(strpos($viewuri, '/fleet/rp_vehicle_renewal_reminders') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/vehicle_renewal_reminders.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_inspection_failures_list') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/inspection_failures_list.js') . '?v=' . FLEET_REVISION . '"></script>';
    }

    if (!(strpos($viewuri, '/fleet/rp_inspection_schedules') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/inspection_schedules.js') . '?v=' . FLEET_REVISION . '"></script>';
    }
    
    if (!(strpos($viewuri, '/fleet/rp_cost_meter_trend') === false)) {
        echo '<script src="' . base_url('plugins/Fleet/assets/js/reports/cost_meter_trend.js') . '?v=' . FLEET_REVISION . '"></script>';
    }
}

function fleet_permissions() {
    $uri = explode('?', $_SERVER['REQUEST_URI']);
    $role_id = basename($uri[0]);

    $Roles_model = model("Roles_model");
    $role_info = $Roles_model->get_one($role_id);
    $permissions = unserialize($role_info->permissions);
    
    $access_fleet = get_array_value($permissions, "fleet");
    if (is_null($access_fleet)) {
        $access_fleet = "";
    }

    echo '<li>
        <span data-feather="key" class="icon-14 ml-20"></span>
        <h5>'. app_lang("can_access_fleets").'</h5>
        <div>'.
            form_radio(array(
                "id" => "fleet_no",
                "name" => "fleet_permission",
                "value" => "",
                "class" => "form-check-input"
                    ), $access_fleet, ($access_fleet === "") ? true : false)
            .'<label for="fleet_no">'. app_lang("no").' </label>
        </div>
        <div>
            '. form_radio(array(
                "id" => "fleet_yes",
                "name" => "fleet_permission",
                "value" => "all",
                "class" => "form-check-input"
                    ), $access_fleet, ($access_fleet === "all") ? true : false).'
            <label for="fleet_yes">'. app_lang("yes").'</label>
        </div>
    </li>';
}

function save_fleet_permissions($permissions){
    $fleet = $_POST['fleet_permission'];
    $permissions = array_merge($permissions, ['fleet' => $fleet]);

    return $permissions;
}


app_hooks()->add_filter('app_filter_notification_config', function ($events) {
    $hr_staff_training_link = function ($options) {
        $url = "";
        if (isset($options->hr_send_training_staff_id)) {
            $url = get_uri("hr_profile/staff_profile/" . $options->hr_send_training_staff_id.'/staff_training');
        }

        return array("url" => $url);
    };

    $hr_lay_off_checklist_link = function ($options) {
        $url = "";
        if (isset($options->hr_send_layoff_checklist_handle_staff_id)) {
            $url = get_uri("hr_profile/resignation_procedures?detail=" . $options->hr_send_layoff_checklist_handle_staff_id);
        }

        return array("url" => $url);
    };

    $events["hr_please_complete_the_tests_below_to_complete_the_training_program"] = [
            "notify_to" => array("team_members"),
            "info" => $hr_staff_training_link
    ];

    $events["a_new_training_program_is_assigned_to_you"] = [
        "notify_to" => array("team_members"),
        "info" => $hr_staff_training_link
    ];

    $events["hr_resignation_procedures_are_waiting_for_your_confirmation"] = [
            "notify_to" => array("team_members"),
            "info" => $hr_lay_off_checklist_link
    ];

    return $events;
});

app_hooks()->add_filter('app_filter_client_left_menu', function ($sidebar_menu) {

    $file_sharing_submenu = array();
    $ci = new Security_Controller(false);

    if($ci->login_user->user_type == 'client'){
        $sidebar_menu["fleet"] = array(
            "name" => "fleet",
            "url" => "fleet_client",
            "class" => "truck",
            "position" => 3,
        );
    }

    

    return $sidebar_menu;
});