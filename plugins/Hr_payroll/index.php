<?php

/*
Plugin Name: HR Payroll
Description: This module encompasses everything that goes into onboarding and paying your employees.
Version: 1.0.0
Requires at least: 3.0
Author: GreenTech Solutions
Author URI: https://codecanyon.net/user/greentech_solutions
*/

use App\Libraries\Template;
use App\Controllers\Security_Controller;
if(!defined('HR_PAYROLL_REVISION')){
    define('HR_PAYROLL_REVISION', 100);
}

//prefix for contract
if(!defined('HR_PAYROLL_PREFIX_PROBATIONARY')){
    define('HR_PAYROLL_PREFIX_PROBATIONARY', ' (CT1)');
}
if(!defined('HR_PAYROLL_PREFIX_FORMAL')){
    define('HR_PAYROLL_PREFIX_FORMAL', ' (CT2)');
}

/*Modules Path*/
if(!defined('APP_MODULES_PATH')){
	define('APP_MODULES_PATH', FCPATH . 'plugins/');
}

if(!defined('EXT')){
	define('EXT', '.php');
}
if(!defined('HR_PAYROLL_MODULE_NAME')){
    define('HR_PAYROLL_MODULE_NAME', 'Hr_payroll');
}
if(!defined('HR_PAYROLL_PATH_LIBRARIES')){
    define('HR_PAYROLL_PATH_LIBRARIES', 'plugins/Hr_payroll/Libraries');
}
if(!defined('HR_PAYROLL_PATH')){
    define('HR_PAYROLL_PATH', 'plugins/Hr_payroll/Uploads/');
}

if(!defined('HR_PAYROLL_PAYSLIP_FOLDER')){
    define('HR_PAYROLL_PAYSLIP_FOLDER', 'plugins/Hr_payroll/Uploads/payslip/');
}
if(!defined('HR_PAYROLL_CREATE_PAYSLIP_EXCEL')){
    define('HR_PAYROLL_CREATE_PAYSLIP_EXCEL', 'plugins/Hr_payroll/Uploads/payslip_excel_file/');
}
if(!defined('HR_PAYROLL_CREATE_ATTENDANCE_SAMPLE')){
    define('HR_PAYROLL_CREATE_ATTENDANCE_SAMPLE', 'plugins/Hr_payroll/Uploads/attendance_sample_file/');
}
if(!defined('HR_PAYROLL_CREATE_EMPLOYEES_SAMPLE')){
    define('HR_PAYROLL_CREATE_EMPLOYEES_SAMPLE', 'plugins/Hr_payroll/Uploads/employees_sample_file/');
}
if(!defined('HR_PAYROLL_CREATE_COMMISSIONS_SAMPLE')){
    define('HR_PAYROLL_CREATE_COMMISSIONS_SAMPLE', 'plugins/Hr_payroll/Uploads/commissions_sample_file/');
}
if(!defined('HR_PAYROLL_ERROR')){
    define('HR_PAYROLL_ERROR', 'plugins/Hr_payroll/Uploads/file_error_response/');
}
if(!defined('HR_PAYROLL_PAYSLIP_FILE')){
    define('HR_PAYROLL_PAYSLIP_FILE', 'plugins/Hr_payroll/Uploads/payslip/');
}
if(!defined('HR_PAYROLL_EXPORT_EMPLOYEE_PAYSLIP')){
    define('HR_PAYROLL_EXPORT_EMPLOYEE_PAYSLIP', 'plugins/Hr_payroll/Uploads/export_employee_payslip/');
}

app_hooks()->add_action('app_hook_head_extension', function (){
	$viewuri = $_SERVER['REQUEST_URI'];


	if (!(strpos($viewuri, '/hr_payroll') === false)) {
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/styles.css') . '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/main.css') . '"  rel="stylesheet" type="text/css" />';
	}

	if (!(strpos($viewuri, '/hr_payroll/income_tax_rates') === false) || !(strpos($viewuri, '/hr_payroll/manage_bonus') === false) || !(strpos($viewuri, '/hr_payroll/hr_records_earnings_list') === false) || !(strpos($viewuri, '/hr_payroll/insurance_list') === false) || !(strpos($viewuri, '/hr_payroll/salary_deductions_list') === false) || !(strpos($viewuri, '/hr_payroll/earnings_list') === false) || !(strpos($viewuri, '/hr_payroll/income_tax_rebates') === false) || !(strpos($viewuri, '/hr_payroll/manage_employees') === false) || !(strpos($viewuri, '/hr_payroll/manage_attendance') === false) || !(strpos($viewuri, '/hr_payroll/manage_deductions') === false) || !(strpos($viewuri, '/hr_payroll/manage_commissions') === false) || !(strpos($viewuri, '/hr_payroll/income_taxs_manage') === false) || !(strpos($viewuri, '/hr_payroll/manage_insurances') === false) ) {

		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/handsontable/handsontable.full.min.css') . '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/handsontable/chosen.css') . '"  rel="stylesheet" type="text/css" />';
		echo '<script src="' . base_url('plugins/Hr_payroll/assets/plugins/handsontable/handsontable.full.min.js') . '"></script>';
	}

	if (!(strpos($viewuri,'hr_payroll/view_payslip_templates_detail') === false) || !(strpos($viewuri,'hr_payroll/view_payslip') === false)  ) {

		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/manage.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/iconfont.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/plugins.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/pluginsCss.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';

		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/iconCustom.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet-cellFormat.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
        //not scroll
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet-core.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet-print.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet-protection.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/luckysheet-zoom.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/chartmix.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/spectrum.min.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/plugins/luckysheet/css/chartmix.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
	}

	if (!(strpos($viewuri,'hr_payroll/manage_bonus') === false) ) {

	}

	if (!(strpos($viewuri,'hr_payroll/payslip_manage') === false) || !(strpos($viewuri,'hr_payroll/payslip_templates_manage') === false) ) {
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/modal_dialog.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
	}

	if (!(strpos($viewuri, '/hr_payroll/import_xlsx_attendance') === false) || !(strpos($viewuri, '/hr_payroll/import_xlsx_employees') === false) || !(strpos($viewuri,'hr_payroll/import_xlsx_commissions') === false) || !(strpos($viewuri,'hr_payroll/view_payslip_detail') === false) || !(strpos($viewuri,'hr_payroll/payslip_manage') === false) ) {
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/box_loading/box_loading.css')  .'?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
	}

	if (!(strpos($viewuri,'hr_payroll/view_payslip_detail') === false) || !(strpos($viewuri,'hr_payroll/view_payslip_templates_detail') === false) ) {
		echo '<link href="' . base_url('plugins/Hr_payroll/assets/css/luckysheet.css') . '?v=' . HR_PAYROLL_REVISION. '"  rel="stylesheet" type="text/css" />';
	}
});

app_hooks()->add_action('app_hook_head_extension', function (){
	$viewuri = $_SERVER['REQUEST_URI'];

	if (!(strpos($viewuri, '/hr_payroll') === false)) {
		echo '<script src="' . base_url('plugins/Hr_payroll/assets/plugins/main/main.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
	}


	if (!(strpos($viewuri, '/hr_payroll/income_tax_rates') === false) || !(strpos($viewuri, '/hr_payroll/manage_bonus') === false) || !(strpos($viewuri, '/hr_payroll/hr_records_earnings_list') === false) || !(strpos($viewuri, '/hr_payroll/insurance_list') === false) || !(strpos($viewuri, '/hr_payroll/salary_deductions_list') === false) || !(strpos($viewuri, '/hr_payroll/earnings_list') === false) || !(strpos($viewuri, '/hr_payroll/income_tax_rebates') === false) || !(strpos($viewuri, '/hr_payroll/manage_employees') === false) || !(strpos($viewuri, '/hr_payroll/manage_attendance') === false) || !(strpos($viewuri, '/hr_payroll/manage_deductions') === false) || !(strpos($viewuri, '/hr_payroll/manage_commissions') === false) || !(strpos($viewuri, '/hr_payroll/income_taxs_manage') === false) || !(strpos($viewuri, '/hr_payroll/manage_insurances') === false) ) {
		echo '<script src="' . base_url('plugins/Hr_payroll/assets/plugins/handsontable/chosen.jquery.js') . '"></script>';
		echo '<script src="' . base_url('plugins/Hr_payroll/assets/plugins/handsontable/handsontable-chosen-editor.js') . '"></script>';
	}

	if (!(strpos($viewuri,'hr_payroll/view_payslip_templates_detail') === false)){
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/luckysheet.umd_payslip.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';

	}

	if (!(strpos($viewuri,'hr_payroll/view_payslip_detail') === false)){
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/luckysheet.umd_payslip.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
	}



	if (!(strpos($viewuri,'hr_payroll/view_payslip_templates_detail') === false) || !(strpos($viewuri,'hr_payroll/view_payslip') === false) ) {

		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/spectrum.min.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/plugin.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/js/manage.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/vue.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/vuex.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/vuexx.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/index.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/echarts.min.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/chartmix.umd.min.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/FileSaver.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script  src="'.base_url('plugins/Hr_payroll/assets/plugins/excel.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script  src="'.base_url('plugins/Hr_payroll/assets/js/exports.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/js/upload_file.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/luckyexcel.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/luckysheet/js/store.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
	}

	if(!(strpos($viewuri,'hr_payroll/reports') === false)){

		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/highcharts/highcharts.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/highcharts/exporting.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
		echo '<script src="'.base_url('plugins/Hr_payroll/assets/plugins/highcharts/series-label.js').'?v=' . HR_PAYROLL_REVISION.'"></script>';
	}
});

app_hooks()->add_filter('app_filter_notification_config', function ($events) {
	return $events;
});

app_hooks()->add_action('app_hook_role_permissions_extension', function ($permissions){
	$permission_data = [];

	$permission_data["hr_payroll_can_view_own_hrp_employee"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_employee");
	$permission_data["hr_payroll_can_view_global_hrp_employee"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_employee");
	$permission_data["hr_payroll_can_create_hrp_employee"] = get_array_value($permissions, "hr_payroll_can_create_hrp_employee");
	$permission_data["hr_payroll_can_edit_hrp_employee"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_employee");
	$permission_data["hr_payroll_can_delete_hrp_employee"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_employee");
	$permission_data["hr_payroll_can_view_own_hrp_attendance"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_attendance");
	$permission_data["hr_payroll_can_view_global_hrp_attendance"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_attendance");
	$permission_data["hr_payroll_can_create_hrp_attendance"] = get_array_value($permissions, "hr_payroll_can_create_hrp_attendance");
	$permission_data["hr_payroll_can_edit_hrp_attendance"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_attendance");
	$permission_data["hr_payroll_can_delete_hrp_attendance"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_attendance");
	$permission_data["hr_payroll_can_view_own_hrp_commission"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_commission");
	$permission_data["hr_payroll_can_view_global_hrp_commission"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_commission");
	$permission_data["hr_payroll_can_create_hrp_commission"] = get_array_value($permissions, "hr_payroll_can_create_hrp_commission");
	$permission_data["hr_payroll_can_edit_hrp_commission"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_commission");
	$permission_data["hr_payroll_can_delete_hrp_commission"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_commission");
	$permission_data["hr_payroll_can_view_own_hrp_deduction"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_deduction");
	$permission_data["hr_payroll_can_view_global_hrp_deduction"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_deduction");
	$permission_data["hr_payroll_can_create_hrp_deduction"] = get_array_value($permissions, "hr_payroll_can_create_hrp_deduction");
	$permission_data["hr_payroll_can_edit_hrp_deduction"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_deduction");
	$permission_data["hr_payroll_can_delete_hrp_deduction"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_deduction");
	$permission_data["hr_payroll_can_view_own_hrp_bonus_kpi"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_bonus_kpi");
	$permission_data["hr_payroll_can_view_global_hrp_bonus_kpi"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_bonus_kpi");
	$permission_data["hr_payroll_can_create_hrp_bonus_kpi"] = get_array_value($permissions, "hr_payroll_can_create_hrp_bonus_kpi");
	$permission_data["hr_payroll_can_edit_hrp_bonus_kpi"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_bonus_kpi");
	$permission_data["hr_payroll_can_delete_hrp_bonus_kpi"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_bonus_kpi");
	$permission_data["hr_payroll_can_view_own_hrp_insurrance"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_insurrance");
	$permission_data["hr_payroll_can_view_global_hrp_insurrance"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_insurrance");
	$permission_data["hr_payroll_can_create_hrp_insurrance"] = get_array_value($permissions, "hr_payroll_can_create_hrp_insurrance");
	$permission_data["hr_payroll_can_edit_hrp_insurrance"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_insurrance");
	$permission_data["hr_payroll_can_delete_hrp_insurrance"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_insurrance");
	$permission_data["hr_payroll_can_view_own_hrp_payslip"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_payslip");
	$permission_data["hr_payroll_can_view_global_hrp_payslip"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_payslip");
	$permission_data["hr_payroll_can_create_hrp_payslip"] = get_array_value($permissions, "hr_payroll_can_create_hrp_payslip");
	$permission_data["hr_payroll_can_edit_hrp_payslip"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_payslip");
	$permission_data["hr_payroll_can_delete_hrp_payslip"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_payslip");
	$permission_data["hr_payroll_can_view_own_hrp_payslip_template"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_payslip_template");
	$permission_data["hr_payroll_can_view_global_hrp_payslip_template"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_payslip_template");
	$permission_data["hr_payroll_can_create_hrp_payslip_template"] = get_array_value($permissions, "hr_payroll_can_create_hrp_payslip_template");
	$permission_data["hr_payroll_can_edit_hrp_payslip_template"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_payslip_template");
	$permission_data["hr_payroll_can_delete_hrp_payslip_template"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_payslip_template");
	$permission_data["hr_payroll_can_view_own_hrp_income_tax"] = get_array_value($permissions, "hr_payroll_can_view_own_hrp_income_tax");
	$permission_data["hr_payroll_can_view_global_hrp_income_tax"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_income_tax");
	$permission_data["hr_payroll_can_view_global_hrp_report"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_report");
	$permission_data["hr_payroll_can_view_global_hrp_setting"] = get_array_value($permissions, "hr_payroll_can_view_global_hrp_setting");
	$permission_data["hr_payroll_can_create_hrp_setting"] = get_array_value($permissions, "hr_payroll_can_create_hrp_setting");
	$permission_data["hr_payroll_can_edit_hrp_setting"] = get_array_value($permissions, "hr_payroll_can_edit_hrp_setting");
	$permission_data["hr_payroll_can_delete_hrp_setting"] = get_array_value($permissions, "hr_payroll_can_delete_hrp_setting");



	$Template = new Template(false);

	$ci = new Security_Controller(false);
	$access_hr_payroll = get_array_value($permissions, "hr_payroll");
	if (is_null($access_hr_payroll)) {
		$access_hr_payroll = "";
	}

	echo  $Template->view('Hr_payroll\Views\includes/hrp_permissions', $permission_data);
});

app_hooks()->add_filter('app_filter_role_permissions_save_data', function ($permissions, $data) {
	$hr_payroll_data = [];

	$hr_payroll_data["hr_payroll_can_view_own_hrp_employee"] = isset($data["hr_payroll_can_view_own_hrp_employee"]) ? $data["hr_payroll_can_view_own_hrp_employee"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_employee"] = isset($data["hr_payroll_can_view_global_hrp_employee"]) ? $data["hr_payroll_can_view_global_hrp_employee"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_employee"] = isset($data["hr_payroll_can_create_hrp_employee"]) ? $data["hr_payroll_can_create_hrp_employee"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_employee"] = isset($data["hr_payroll_can_edit_hrp_employee"]) ? $data["hr_payroll_can_edit_hrp_employee"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_employee"] = isset($data["hr_payroll_can_delete_hrp_employee"]) ? $data["hr_payroll_can_delete_hrp_employee"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_attendance"] = isset($data["hr_payroll_can_view_own_hrp_attendance"]) ? $data["hr_payroll_can_view_own_hrp_attendance"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_attendance"] = isset($data["hr_payroll_can_view_global_hrp_attendance"]) ? $data["hr_payroll_can_view_global_hrp_attendance"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_attendance"] = isset($data["hr_payroll_can_create_hrp_attendance"]) ? $data["hr_payroll_can_create_hrp_attendance"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_attendance"] = isset($data["hr_payroll_can_edit_hrp_attendance"]) ? $data["hr_payroll_can_edit_hrp_attendance"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_attendance"] = isset($data["hr_payroll_can_delete_hrp_attendance"]) ? $data["hr_payroll_can_delete_hrp_attendance"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_commission"] = isset($data["hr_payroll_can_view_own_hrp_commission"]) ? $data["hr_payroll_can_view_own_hrp_commission"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_commission"] = isset($data["hr_payroll_can_view_global_hrp_commission"]) ? $data["hr_payroll_can_view_global_hrp_commission"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_commission"] = isset($data["hr_payroll_can_create_hrp_commission"]) ? $data["hr_payroll_can_create_hrp_commission"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_commission"] = isset($data["hr_payroll_can_edit_hrp_commission"]) ? $data["hr_payroll_can_edit_hrp_commission"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_commission"] = isset($data["hr_payroll_can_delete_hrp_commission"]) ? $data["hr_payroll_can_delete_hrp_commission"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_deduction"] = isset($data["hr_payroll_can_view_own_hrp_deduction"]) ? $data["hr_payroll_can_view_own_hrp_deduction"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_deduction"] = isset($data["hr_payroll_can_view_global_hrp_deduction"]) ? $data["hr_payroll_can_view_global_hrp_deduction"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_deduction"] = isset($data["hr_payroll_can_create_hrp_deduction"]) ? $data["hr_payroll_can_create_hrp_deduction"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_deduction"] = isset($data["hr_payroll_can_edit_hrp_deduction"]) ? $data["hr_payroll_can_edit_hrp_deduction"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_deduction"] = isset($data["hr_payroll_can_delete_hrp_deduction"]) ? $data["hr_payroll_can_delete_hrp_deduction"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_bonus_kpi"] = isset($data["hr_payroll_can_view_own_hrp_bonus_kpi"]) ? $data["hr_payroll_can_view_own_hrp_bonus_kpi"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_bonus_kpi"] = isset($data["hr_payroll_can_view_global_hrp_bonus_kpi"]) ? $data["hr_payroll_can_view_global_hrp_bonus_kpi"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_bonus_kpi"] = isset($data["hr_payroll_can_create_hrp_bonus_kpi"]) ? $data["hr_payroll_can_create_hrp_bonus_kpi"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_bonus_kpi"] = isset($data["hr_payroll_can_edit_hrp_bonus_kpi"]) ? $data["hr_payroll_can_edit_hrp_bonus_kpi"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_bonus_kpi"] = isset($data["hr_payroll_can_delete_hrp_bonus_kpi"]) ? $data["hr_payroll_can_delete_hrp_bonus_kpi"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_insurrance"] = isset($data["hr_payroll_can_view_own_hrp_insurrance"]) ? $data["hr_payroll_can_view_own_hrp_insurrance"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_insurrance"] = isset($data["hr_payroll_can_view_global_hrp_insurrance"]) ? $data["hr_payroll_can_view_global_hrp_insurrance"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_insurrance"] = isset($data["hr_payroll_can_create_hrp_insurrance"]) ? $data["hr_payroll_can_create_hrp_insurrance"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_insurrance"] = isset($data["hr_payroll_can_edit_hrp_insurrance"]) ? $data["hr_payroll_can_edit_hrp_insurrance"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_insurrance"] = isset($data["hr_payroll_can_delete_hrp_insurrance"]) ? $data["hr_payroll_can_delete_hrp_insurrance"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_payslip"] = isset($data["hr_payroll_can_view_own_hrp_payslip"]) ? $data["hr_payroll_can_view_own_hrp_payslip"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_payslip"] = isset($data["hr_payroll_can_view_global_hrp_payslip"]) ? $data["hr_payroll_can_view_global_hrp_payslip"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_payslip"] = isset($data["hr_payroll_can_create_hrp_payslip"]) ? $data["hr_payroll_can_create_hrp_payslip"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_payslip"] = isset($data["hr_payroll_can_edit_hrp_payslip"]) ? $data["hr_payroll_can_edit_hrp_payslip"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_payslip"] = isset($data["hr_payroll_can_delete_hrp_payslip"]) ? $data["hr_payroll_can_delete_hrp_payslip"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_payslip_template"] = isset($data["hr_payroll_can_view_own_hrp_payslip_template"]) ? $data["hr_payroll_can_view_own_hrp_payslip_template"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_payslip_template"] = isset($data["hr_payroll_can_view_global_hrp_payslip_template"]) ? $data["hr_payroll_can_view_global_hrp_payslip_template"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_payslip_template"] = isset($data["hr_payroll_can_create_hrp_payslip_template"]) ? $data["hr_payroll_can_create_hrp_payslip_template"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_payslip_template"] = isset($data["hr_payroll_can_edit_hrp_payslip_template"]) ? $data["hr_payroll_can_edit_hrp_payslip_template"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_payslip_template"] = isset($data["hr_payroll_can_delete_hrp_payslip_template"]) ? $data["hr_payroll_can_delete_hrp_payslip_template"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_own_hrp_income_tax"] = isset($data["hr_payroll_can_view_own_hrp_income_tax"]) ? $data["hr_payroll_can_view_own_hrp_income_tax"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_income_tax"] = isset($data["hr_payroll_can_view_global_hrp_income_tax"]) ? $data["hr_payroll_can_view_global_hrp_income_tax"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_report"] = isset($data["hr_payroll_can_view_global_hrp_report"]) ? $data["hr_payroll_can_view_global_hrp_report"] : NULL;
	$hr_payroll_data["hr_payroll_can_view_global_hrp_setting"] = isset($data["hr_payroll_can_view_global_hrp_setting"]) ? $data["hr_payroll_can_view_global_hrp_setting"] : NULL;
	$hr_payroll_data["hr_payroll_can_create_hrp_setting"] = isset($data["hr_payroll_can_create_hrp_setting"]) ? $data["hr_payroll_can_create_hrp_setting"] : NULL;
	$hr_payroll_data["hr_payroll_can_edit_hrp_setting"] = isset($data["hr_payroll_can_edit_hrp_setting"]) ? $data["hr_payroll_can_edit_hrp_setting"] : NULL;
	$hr_payroll_data["hr_payroll_can_delete_hrp_setting"] = isset($data["hr_payroll_can_delete_hrp_setting"]) ? $data["hr_payroll_can_delete_hrp_setting"] : NULL;

	$permissions = array_merge($permissions, $hr_payroll_data);

	return $permissions;
});

app_hooks()->add_filter('hr_profile_app_filter_staff_profile_ajax_tab', function ($hook_tabs, $user_id) {
	$hook_tabs[] = [
		'url' => get_uri('hr_payroll/staff_pay_slips/'.$user_id),
		'target' => 'tab-staff-pay_slips',
		'title' => app_lang('hr_pay_slips'),
	];


	return $hook_tabs;
});

if(!defined('HR_PAYROLL_VIEWPATH')){
    define('HR_PAYROLL_VIEWPATH', 'plugins/Hr_payroll');
}

/*add menu item to left menu*/
app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
	$hr_payroll_submenu = array();
	$ci = new Security_Controller(false);
	$permissions = $ci->login_user->permissions;

	if ($ci->login_user->is_admin || get_array_value($permissions, "hr_payroll_can_view_own_hrp_employee") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_employee") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_attendance") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_attendance") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_commission") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_commission") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_deduction") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_deduction") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_bonus_kpi") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_bonus_kpi") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_insurrance") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_insurrance") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_payslip") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_payslip") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_payslip_template") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_payslip_template") || get_array_value($permissions, "hr_payroll_can_view_own_hrp_income_tax") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_income_tax") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_report") || get_array_value($permissions, "hr_payroll_can_view_global_hrp_setting") ) {

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_employee') || hrp_has_permission('hr_payroll_can_view_global_hrp_employee') ){
			$hr_payroll_submenu["dashboard"] = array(
				"name" => "hr_manage_employees",
				"url" => "hr_payroll/manage_employees",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_attendance') || hrp_has_permission('hr_payroll_can_view_global_hrp_attendance') ){

			$hr_payroll_submenu["organizational_chart"] = array(
				"name" => "hr_manage_attendance",
				"url" => "hr_payroll/manage_attendance",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_commission') || hrp_has_permission('hr_payroll_can_view_global_hrp_commission') ){
			$hr_payroll_submenu["reception_staff"] = array(
				"name" => "hrp_commission_manage",
				"url" => "hr_payroll/manage_commissions",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_deduction') || hrp_has_permission('hr_payroll_can_view_global_hrp_deduction') ){

			$hr_payroll_submenu["job_positions"] = array(
				"name" => "hrp_deduction_manage",
				"url" => "hr_payroll/manage_deductions",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_bonus_kpi') || hrp_has_permission('hr_payroll_can_view_global_hrp_bonus_kpi') ){

			$hr_payroll_submenu["training_program"] = array(
				"name" => "hr_bonus_kpi",
				"url" => "hr_payroll/manage_bonus",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_insurrance') || hrp_has_permission('hr_payroll_can_view_global_hrp_insurrance') ){

			$hr_payroll_submenu["knowledge_base_q_a"] = array(
				"name" => "hrp_insurrance",
				"url" => "hr_payroll/manage_insurances",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_payslip') || hrp_has_permission('hr_payroll_can_view_global_hrp_payslip') ){

			$hr_payroll_submenu["contracts"] = array(
				"name" => "hr_pay_slips",
				"url" => "hr_payroll/payslip_manage",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_payslip_template') || hrp_has_permission('hr_payroll_can_view_global_hrp_payslip_template') ){

			$hr_payroll_submenu["dependent_persons"] = array(
				"name" => "hr_pay_slip_templates",
				"url" => "hr_payroll/payslip_templates_manage",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_own_hrp_income_tax') || hrp_has_permission('hr_payroll_can_view_global_hrp_income_tax') ){

			$hr_payroll_submenu["resignation_procedures"] = array(
				"name" => "hrp_income_tax",
				"url" => "hr_payroll/income_taxs_manage",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_global_hrp_report') ){

			$hr_payroll_submenu["reports"] = array(
				"name" => "hrp_reports",
				"url" => "hr_payroll/reports",
				"class" => "users",
			);
		}

		if(hrp_has_permission('hr_payroll_can_view_global_hrp_setting') ){

			$hr_payroll_submenu["contract_type"] = array(
				"name" => "settings",
				"url" => "hr_payroll/income_tax_rates",
				"class" => "users",
			);
		}


		$sidebar_menu["hr_payroll"] = array(
			"name" => "hr_payroll",
			"url" => "hr_payroll",
			"class" => "dollar-sign",
			"submenu" => $hr_payroll_submenu,
			"position" => 7,

		);
	}

	return $sidebar_menu;

});


/*install dependencies*/
register_installation_hook("Hr_payroll", function ($item_purchase_code) {
/*
* you can verify the item puchase code from here if you want.
* you'll get the inputted puchase code with $item_purchase_code variable
* use exit(); here if there is anything doesn't meet it's requirements
*/
 	include PLUGINPATH .  "Hr_payroll/lib/gtsverify.php";
	require_once __DIR__ . '/install.php';
});

/*Active action*/
register_activation_hook("Hr_payroll", function ($item_purchase_code) {
	require_once(__DIR__ . '/install.php');
});

/*add setting link to the plugin setting*/
app_hooks()->add_filter('app_filter_action_links_of_Hr_payroll', function () {
	$action_links_array = array(
	);

	return $action_links_array;
});

/*update plugin*/
register_update_hook("Hr_payroll", function () {
	require_once __DIR__ . '/install.php';
});

/*uninstallation: remove data from database*/
register_uninstallation_hook("Hr_payroll", function () {
	require_once __DIR__ . '/uninstall.php';
});
app_hooks()->add_action('app_hook_hrpayroll_init', function (){
    require_once __DIR__ .'/lib/gtsslib.php';
    $lic_hrpayroll = new HRPayrollLic();

});
app_hooks()->add_action('app_hook_uninstall_plugin_Hr_payroll', function (){
    require_once __DIR__ .'/lib/gtsslib.php';
    $lic_hrpayroll = new HRPayrollLic();

});

