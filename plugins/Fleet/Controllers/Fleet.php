<?php

/**
 * Fleet Controller
 */

namespace Fleet\Controllers;

use App\Controllers\Security_Controller;

class Fleet extends Security_Controller
{
    protected $Fleet_model;
    function __construct() {
        parent::__construct();
        $this->Fleet_model = new \Fleet\Models\Fleet_model();
        app_hooks()->do_action('app_hook_fleet_init');
    }

    /**
     * vehicle
     * @return view
     */
    public function vehicles(){
        $this->required_module();

        if (!has_permission('fleet_vehicle', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('vehicle');
        $data['vehicle_types'] = $this->Fleet_model->get_data_vehicle_types();
        $data['vehicle_groups'] = $this->Fleet_model->get_data_vehicle_groups();

        return $this->template->rander('Fleet\Views\vehicles/manage', $data);
    }

    /**
     * setting
     * @return view
     */
    public function settings()
    {
        $this->required_module();
        if (!has_permission('fleet_setting', '', 'view')) {
            access_denied('setting');
        }
        
        $data          = [];
        $data['group'] = $this->request->getGet('group');

        $data['tab'][] = 'vehicle_groups';
        $data['tab'][] = 'vehicle_types';
        $data['tab'][] = 'inspection_forms';
        $data['tab'][] = 'criterias';
        $data['tab'][] = 'insurance_categories';
        $data['tab'][] = 'insurance_types';
        $data['tab'][] = 'insurance_company';
        $data['tab'][] = 'insurance_status';
        $data['tab'][] = 'part_types';
        $data['tab'][] = 'part_groups';
        $data['tab'][] = 'permissions';
        
        $data['tab_2'] = $this->request->getGet('tab');
        if ($data['group'] == '') {
            $data['group'] = 'vehicle_groups';
        }


        $data['title']        = _l($data['group']);
        $data['tabs']['view'] = 'settings/' . $data['group'];
        return $this->template->rander('Fleet\Views\settings/manage', $data);
    }

    /**
     * vehicle groups table
     * @return json
     */
    public function vehicle_groups_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_vehicle_groups';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_vehicle_group(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_vehicle_group/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit vehicle group
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function vehicle_group()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_vehicle_group($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('vehicle_group')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_vehicle_group($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('vehicle_group')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=vehicle_groups');
        }
    }

    /**
     * delete vehicle group
     * @param  integer $id
     * @return
     */
    public function delete_vehicle_group($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_vehicle_group($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('vehicle_group')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=vehicle_groups');
    }

    /**
     * get data vehicle group
     * @param  integer $id 
     * @return json     
     */
    public function get_data_vehicle_group($id){
        $vehicle_group = $this->Fleet_model->get_data_vehicle_groups($id);

        echo json_encode($vehicle_group);
    }

    /**
     * vehicle types table
     * @return json
     */
    public function vehicle_types_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_vehicle_types';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_vehicle_type(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_vehicle_type/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit vehicle type
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function vehicle_type()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_vehicle_type($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('vehicle_type')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_vehicle_type($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('vehicle_type')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=vehicle_types');
        }
    }

    /**
     * delete vehicle type
     * @param  integer $id
     * @return
     */
    public function delete_vehicle_type($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_vehicle_type($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('vehicle_type')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=vehicle_types');
    }

    /**
     * get data vehicle type
     * @param  integer $id 
     * @return json     
     */
    public function get_data_vehicle_type($id){
        $vehicle_type = $this->Fleet_model->get_data_vehicle_types($id);

        echo json_encode($vehicle_type);
    }

    /**
     * delete vehicle
     * @param  integer $id
     * @return
     */
    public function delete_vehicle($id)
    {
        if (!has_permission('fleet_vehicle', '', 'delete')) {
            access_denied('fleet_vehicle');
        }
        $success = $this->Fleet_model->delete_vehicle($id);
        $message = '';
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('vehicle')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/vehicles');
    }

    /**
     * vehicles table
     * @return json
     */
    public function vehicles_table(){
           
            $select = [
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_vehicle_types.name as type_name',
                db_prefix() . 'fleet_vehicle_groups.name as group_name',
                'year',
                'make',
                'model',
                'status',
            ];

            $where = [];

            $is_report = $this->request->getPost("is_report");
            if ($this->request->getPost('vehicle_type_id')) {
                $vehicle_type_id = $this->request->getPost('vehicle_type_id');
                array_push($where, 'AND vehicle_type_id = '. $vehicle_type_id);
            }

            if ($this->request->getPost('vehicle_group_id')) {
                $vehicle_group_id = $this->request->getPost('vehicle_group_id');
                array_push($where, 'AND vehicle_group_id = '. $vehicle_group_id);
            }

            if ($this->request->getPost('status')) {
                $status = $this->request->getPost('status');
                array_push($where, 'AND status = "'. $status.'"');
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_vehicles';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicle_types ON ' . db_prefix() . 'fleet_vehicle_types.id = ' . db_prefix() . 'fleet_vehicles.vehicle_type_id',
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicle_groups ON ' . db_prefix() . 'fleet_vehicle_groups.id = ' . db_prefix() . 'fleet_vehicles.vehicle_group_id',];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_vehicles.id as id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $categoryOutput = '<a href="' . admin_url('fleet/vehicle/' . $aRow['id']) . '">' . $aRow['vehicle_name'] . '</a>';
                if($is_report == ''){
                    $categoryOutput .= '<div class="row-options">';
                    $categoryOutput .= '<a href="' . admin_url('fleet/vehicle/' . $aRow['id']) . '">' . _l('view') . '</a>';

                    if (fleet_has_permission('fleet_can_edit_vehicle')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/vehicle/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                    }
                
                    if (fleet_has_permission('fleet_can_delete_vehicle')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_vehicle/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $categoryOutput .= '</div>';
                }
                $row[] = $categoryOutput;
                $row[] = $aRow['year'];
                $row[] = $aRow['make'];
                $row[] = $aRow['model'];
                $row[] = $aRow['type_name'];
                $row[] = $aRow['group_name'];
                $row[] = _l($aRow['status']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * add or edit driver
     * @return view
     */
    public function driver($id = ''){
        if ($this->request->getPost()) {
            $staffid                = $this->request->getPost('staff');

            if($staffid != ''){
                if (!has_permission('fleet_driver', '', 'create')) {
                    access_denied('fleet_driver');
                }

                $success = $this->Fleet_model->add_driver($staffid);
                if ($success) {
                     $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('driver')));

                    app_redirect('fleet/driver_detail/'.$staffid);
                }
            }
        }

        app_redirect('fleet/drivers');
    }

    /**
     * delete driver
     * @param  integer $id
     * @return
     */
    public function delete_driver($id)
    {
        if (!has_permission('fleet_driver', '', 'delete')) {
            access_denied('fleet_driver');
        }
        $success = $this->Fleet_model->delete_driver($id);
        $message = '';
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('driver')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/drivers');
    }

    /**
     * driver
     * @return view
     */
    public function drivers(){
        $this->required_module();
        if (!has_permission('fleet_driver', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('driver');
        $data['staffs']         = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff", "status" => "active"))->getResultArray();

        return $this->template->rander('Fleet\Views\drivers/manage', $data);
    }


    public function drivers_table(){
        $has_permission_delete = has_permission('staff', '', 'delete');

        $aColumns = [
            'first_name',
            'email',
            db_prefix() . 'roles.title',
            'last_online',
            'status',
            ];
        $sIndexColumn = 'id';
        $sTable       = db_prefix() . 'users';
        $join         = ['LEFT JOIN ' . db_prefix() . 'roles ON ' . db_prefix() . 'roles.id = ' . db_prefix() . 'users.role_id'];
        $i            = 0;


        $role_id = $this->Fleet_model->get_fleet_driver_role_id();

        $where =[];
        array_push($where, 'AND role_id = "'. $role_id.'"');

        $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
            'image',
            'last_name',
            db_prefix() . 'users.id as staffid',
            ]);

        $output  = $result['output'];
        $rResult = $result['rResult'];

        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
                    $_data = $aRow[strafter($aColumns[$i], 'as ')];
                } else {
                    $_data = $aRow[$aColumns[$i]];
                }
                if ($aColumns[$i] == 'last_online') {
                    if ($_data != null) {
                        $_data = '<span class="text-has-action is-date" data-toggle="tooltip" data-title="' . _dt($_data) . '">' . time_ago($_data) . '</span>';
                    } else {
                        $_data = 'Never';
                    }
                } elseif ($aColumns[$i] == 'status') {
                    $checked = '';
                    if ($aRow['status'] == 'active') {
                        $checked = 'checked';
                    }

                    $_data = '<div class="onoffswitch">
                        <input type="checkbox" ' . (($aRow['staffid'] == get_staff_user_id() || (is_admin($aRow['staffid']) || !has_permission('staff', '', 'edit')) && !is_admin()) ? 'disabled' : '') . ' data-switch-url="' . admin_url() . 'staff/change_staff_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_' . $aRow['staffid'] . '" data-id="' . $aRow['staffid'] . '" ' . $checked . '>
                        <label class="onoffswitch-label" for="c_' . $aRow['staffid'] . '"></label>
                    </div>';

                    // For exporting
                    $_data .= '<span class="hide">' . ($checked == 'checked' ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
                } elseif ($aColumns[$i] == 'first_name') {
                    $image_url = get_avatar($aRow['image']);
                    $user_avatar = "<span class='avatar avatar-xs'><img src='$image_url' alt='...'></span>";

                    $_data = '<a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . $user_avatar . '</a>';

                    $_data .= ' <a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . $aRow['first_name'] . ' ' . $aRow['last_name'] . '</a>';

                    $_data .= '<div class="row-options">';
                    $_data .= '<a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . _l('view') . '</a>';

                    if (fleet_has_permission('fleet_can_delete_driver')) {
                        $_data .= ' | <a href="' . admin_url('fleet/delete_driver/' . $aRow['staffid']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $_data .= '</div>';
                } elseif ($aColumns[$i] == 'email') {
                    $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
                } else {
                    if (strpos($aColumns[$i], 'date_picker_') !== false) {
                        $_data = (strpos($_data, ' ') !== false ? _dt($_data) : _d($_data));
                    }
                }
                $row[] = $_data;
            }

            $row['DT_RowClass'] = 'has-row-options';

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
        die();
    }

    /**
     * view driver detail
     * @return view
     */
    public function driver_detail($id = ''){
        $data['staff_departments'] = $this->Fleet_model->get_staff_departments($id);

        $data['departments'] = $this->Fleet_model->get_department();

        if ($id == '') {
            $title = _l('add_new', _l('client_lowercase'));
        } else {
            $data['driver'] = $this->Fleet_model->get_driver($id);

            $group         = !$this->request->getGet('group') ? 'general_information' : $this->request->getGet('group');
            $data['group'] = $group;

            $data['tab'][] = ['name' => 'general_information', 'icon' => '<i class="fa fa-user-circle menu-icon"></i>'];
            $data['tab'][] = ['name' => 'vehicle_assignments','icon' => '<i class="fa fa-truck menu-icon"></i>'];
            $data['tab'][] = ['name' => 'driver_documents', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
            if(fleet_get_status_modules('Hr_profile')){
                $data['tab'][] = ['name' => 'training_information', 'icon' => '<i class="fa fa-file-invoice menu-icon"></i>'];
            }

            $data['tab'][] = ['name' => 'benefit_and_penalty', 'icon' => '<i class="fa fa-file-invoice-dollar menu-icon"></i>'];
            $data['tabs']['view'] = 'drivers/groups/'.$data['group'];

            if (!$data['driver']) {
                show_404();
            }

            $title          = $data['driver']->first_name .' '.$data['driver']->last_name;
            $data['vehicles'] = $this->Fleet_model->get_vehicle();
            $data['drivers'] = $this->Fleet_model->get_driver();

            if ($group == 'training_information') {
                $Hr_profile_model = model('Hr_profile\Models\Hr_profile_model');
                $member = $Hr_profile_model->get_staff($id);
                if (!$member) {
                    blank_page('Staff Member Not Found', 'danger');
                }
                $data['member'] = $member;

                $training_data = [];
                //Onboarding training
                $training_allocation_staff = $Hr_profile_model->get_training_allocation_staff($id);

                if ($training_allocation_staff != null) {

                    $training_data['list_training_allocation'] = get_object_vars($training_allocation_staff);
                }

                if (isset($training_allocation_staff) && $training_allocation_staff != null) {
                    $training_data['training_allocation_min_point'] = 0;

                    $job_position_training = $Hr_profile_model->get_job_position_training_de($training_allocation_staff->jp_interview_training_id);

                    if ($job_position_training) {
                        $training_data['training_allocation_min_point'] = $job_position_training->mint_point;
                    }

                    if ($training_allocation_staff) {
                        $training_process_id = $training_allocation_staff->training_process_id;

                        $training_data['list_training'] = $Hr_profile_model->get_list_position_training_by_id_training($training_process_id);

                        //Get the latest employee's training result.
                        $training_results = $this->get_mark_staff($id, $training_process_id);

                        $training_data['training_program_point'] = $training_results['training_program_point'];
                        $training_data['staff_training_result'] = $training_results['staff_training_result'];

                        //have not done the test data
                        $staff_training_result = [];
                        foreach ($training_data['list_training'] as $key => $value) {
                            $staff_training_result[$value['training_id']] = [
                                'training_name' => $value['subject'],
                                'total_point' => 0,
                                'training_id' => $value['training_id'],
                                'total_question' => 0,
                                'total_question_point' => 0,
                            ];
                        }

                        //did the test
                        if (count($training_results['staff_training_result']) > 0) {

                            foreach ($training_results['staff_training_result'] as $result_key => $result_value) {
                                if (isset($staff_training_result[$result_value['training_id']])) {
                                    unset($staff_training_result[$result_value['training_id']]);
                                }
                            }

                            $training_data['staff_training_result'] = array_merge($training_results['staff_training_result'], $staff_training_result);

                        } else {
                            $training_data['staff_training_result'] = $staff_training_result;
                        }

                        if ((float) $training_results['training_program_point'] >= (float) $training_data['training_allocation_min_point']) {
                            $training_data['complete'] = 0;
                        } else {
                            $training_data['complete'] = 1;
                        }

                    }
                }

                if (count($training_data) > 0) {
                    $data['training_data'][] = $training_data;
                }

                //Additional training
                $additional_trainings = $Hr_profile_model->get_additional_training($id);

                foreach ($additional_trainings as $key => $value) {
                    $training_temp = [];

                    $training_temp['training_allocation_min_point'] = $value['mint_point'];
                    $training_temp['list_training_allocation'] = $value;
                    $training_temp['list_training'] = $Hr_profile_model->get_list_position_training_by_id_training($value['position_training_id']);

                    //Get the latest employee's training result.
                    $training_results = $this->get_mark_staff($id, $value['position_training_id']);

                    $training_temp['training_program_point'] = $training_results['training_program_point'];
                    $training_temp['staff_training_result'] = $training_results['staff_training_result'];

                    //have not done the test data
                    $staff_training_result = [];
                    foreach ($training_temp['list_training'] as $key => $value) {
                        $staff_training_result[$value['training_id']] = [
                            'training_name' => $value['subject'],
                            'total_point' => 0,
                            'training_id' => $value['training_id'],
                            'total_question' => 0,
                            'total_question_point' => 0,
                        ];
                    }

                    //did the test
                    if (count($training_results['staff_training_result']) > 0) {

                        foreach ($training_results['staff_training_result'] as $result_key => $result_value) {
                            if (isset($staff_training_result[$result_value['training_id']])) {
                                unset($staff_training_result[$result_value['training_id']]);
                            }
                        }

                        $training_temp['staff_training_result'] = array_merge($training_results['staff_training_result'], $staff_training_result);

                    } else {
                        $training_temp['staff_training_result'] = $staff_training_result;
                    }

                    if ((float) $training_results['training_program_point'] >= (float) $training_temp['training_allocation_min_point']) {
                        $training_temp['complete'] = 0;
                    } else {
                        $training_temp['complete'] = 1;
                    }

                    if (count($training_temp) > 0) {
                        $data['training_data'][] = $training_temp;
                    }

                }

            }
        }


        $data['criterias'] = $this->Fleet_model->get_criterias();


        $data['title'] = $title;
        
        return $this->template->rander('Fleet\Views\drivers/driver_detail', $data);
    }

    /* Edit client or add new client*/
    public function vehicle($id = '')
    {
        if (!has_permission('fleet_vehicle', '', 'view')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            if ($id == '') {
                if (!has_permission('fleet_vehicle', '', 'create')) {
                    access_denied('fleet');
                }

                $data = $this->request->getPost();

                $id = $this->Fleet_model->add_vehicle($data);
                if ($id) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('vehicle')));
                    app_redirect('fleet/vehicle/' . $id);
                }
            } else {
                if (!has_permission('fleet_vehicle', '', 'edit')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->update_vehicle($this->request->getPost(), $id);
                if ($success == true) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('vehicle')));
                }
                app_redirect('fleet/vehicle/' . $id);
            }
        }

        $group         = !$this->request->getGet('group') ? 'details' : $this->request->getGet('group');
        $data['group'] = $group;

        if ($id == '') {
            $title = _l('add_new', _l('vehicle'));
        } else {
            $vehicle                = $this->Fleet_model->get_vehicle($id);
            $data['vehicle_tabs'] = [];
            $data['vehicle_tabs']['details'] = ['name' => 'details', 'icon' => '<i class="fa fa-user-circle menu-icon"></i>'];
            $data['vehicle_tabs']['maintenance'] = ['name' => 'maintenance','icon' => '<i class="fa fa-users menu-icon"></i>'];
            $data['vehicle_tabs']['lifecycle'] = ['name' => 'lifecycle','icon' => '<i class="fa fa-file-powerpoint menu-icon"></i>'];
            $data['vehicle_tabs']['financial'] = ['name' => 'financial', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
            $data['vehicle_tabs']['specifications'] = ['name' => 'specifications', 'icon' => '<i class="fa fa-cart-plus menu-icon"></i>'];
            $data['vehicle_tabs']['assignment_history'] = ['name' => 'assignment_history', 'icon' => '<i class="fa fa-history menu-icon"></i>'];
            $data['vehicle_tabs']['fuel_history'] = ['name' => 'fuel_history', 'icon' => '<i class="fa fa-gas-pump menu-icon"></i>'];
            $data['vehicle_tabs']['insurances'] = ['name' => 'insurances', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
            $data['vehicle_tabs']['inspections'] = ['name' => 'inspections', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
            $data['vehicle_tabs']['vehicle_document'] = ['name' => 'vehicle_document', 'icon' => '<i class="fa fa-file-invoice menu-icon"></i>'];
            $data['vehicle_tabs']['parts'] = ['name' => 'parts', 'icon' => '<i class="fa fa-newspaper menu-icon"></i>'];

            if (!$vehicle) {
                show_404();
            }

            $data['tab']      = isset($data['vehicle_tabs'][$group]) ? $data['vehicle_tabs'][$group] : null;
            $data['tab']['view'] = 'groups/'.$data['group'];

            if (!$data['tab']) {
                show_404();
            }

            // Fetch data based on groups
            if ($group == 'details') {
               
            } elseif ($group == 'financial') {
                $data['vendors'] = $this->Fleet_model->get_vendor();
            } elseif ($group == 'vault') {
                $data['vault_entries'] = hooks()->apply_filters('check_vault_entries_visibility', $this->clients_model->get_vault_entries($id));

                if ($data['vault_entries'] === -1) {
                    $data['vault_entries'] = [];
                }
            } elseif ($group == 'fuel_history') {
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
                $data['vendors'] = $this->Fleet_model->get_vendor();
                $data['fuel_consumption'] = $this->Fleet_model->calculating_fuel_consumption($id);
            } elseif ($group == 'inspections') {
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
                $data['inspection_forms'] = $this->Fleet_model->get_inspection_forms();
            } elseif ($group == 'assignment_history') {
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
                $data['drivers'] = $this->Fleet_model->get_driver();
            } elseif ($group == 'maintenance') {
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
                $data['garages'] = $this->Fleet_model->get_garages();
                $data['parts'] = $this->Fleet_model->get_part();

                $data['currency_name'] = get_setting('default_currency');
                
            } elseif ($group == 'insurances') {
                $data['insurance_status'] = $this->Fleet_model->get_data_insurance_status();
                $data['insurance_company'] = $this->Fleet_model->get_data_insurance_company();
                $data['insurance_categorys'] = $this->Fleet_model->get_insurance_category();;
                $data['insurance_types'] = $this->Fleet_model->get_insurance_type();;
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
            } elseif($group == 'parts'){
                $data['part_types'] = $this->Fleet_model->get_data_part_types();
                $data['part_groups'] = $this->Fleet_model->get_data_part_groups();
            } elseif ($group == 'map') {
                if (get_setting('google_api_key') != '' && !empty($client->latitude) && !empty($client->longitude)) {
                    $this->app_scripts->add('map-js', base_url($this->app_scripts->core_file('assets/js', 'map.js')) . '?v=' . $this->app_css->core_version());

                    $this->app_scripts->add('google-maps-api-js', [
                        'path'       => 'https://maps.googleapis.com/maps/api/js?key=' . get_setting('google_api_key') . '&callback=initMap',
                        'attributes' => [
                            'async',
                            'defer',
                            'latitude'       => "$client->latitude",
                            'longitude'      => "$client->longitude",
                            'mapMarkerTitle' => "$client->company",
                        ],
                        ]);
                }
            }

            $data['staff'] = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff", "status" => "active"))->getResultArray();

            $data['vehicle'] = $vehicle;
            $title          = $vehicle->name;

            // Get all active staff members (used to add reminder)
            $data['members'] = $data['staff'];

            if (!empty($data['client']->company)) {
                // Check if is realy empty client company so we can set this field to empty
                // The query where fetch the client auto populate firstname and lastname if company is empty
                if (is_empty_customer_company($data['client']->userid)) {
                    $data['client']->company = '';
                }
            }
        }

        $data['vehicle_types'] = $this->Fleet_model->get_data_vehicle_types();
        $data['vehicle_groups'] = $this->Fleet_model->get_data_vehicle_groups();
        $data['bodyclass'] = 'customer-profile dynamic-create-groups';
        $data['title']     = $title;

        return $this->template->rander('Fleet\Views\vehicles/vehicle', $data);
    }

    /**
     * { vehicle_detail }
     */
    public function vehicle_detail($id = ''){


        $group         = !$this->request->getGet('group') ? 'general_information' : $this->request->getGet('group');
        $data['group'] = $group;

        $data['tab'][] = ['name' => 'general_information', 'icon' => '<i class="fa fa-user-circle menu-icon"></i>'];
        $data['tab'][] = ['name' => 'maintenance','icon' => '<i class="fa fa-users menu-icon"></i>'];
        $data['tab'][] = ['name' => 'lifecycle','icon' => '<i class="fa fa-file-powerpoint menu-icon"></i>'];
        $data['tab'][] = ['name' => 'financial', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
        $data['tab'][] = ['name' => 'specifications', 'icon' => '<i class="fa fa-cart-plus menu-icon"></i>'];
        $data['tab'][] = ['name' => 'assignment_history', 'icon' => '<i class="fa fa-history menu-icon"></i>'];
        $data['tab'][] = ['name' => 'fuel_history', 'icon' => '<i class="fa fa-gas-pump menu-icon"></i>'];
        $data['tab'][] = ['name' => 'inspections', 'icon' => '<i class="fa fa-file-text menu-icon"></i>'];
        $data['tab'][] = ['name' => 'settings', 'icon' => '<i class="fa fa-paperclip menu-icon"></i>'];

        if($data['group'] == ''){
            $data['group'] = 'general_information';
        }
        $data['tabs']['view'] = 'groups/'.$data['group'];

        $data['vehicle'] = $this->Fleet_model->get_vehicle($id);

        $data['title']     = $data['vehicle']->name;
        $data['vehicle_types'] = $this->Fleet_model->get_data_vehicle_types();
        $data['vehicle_groups'] = $this->Fleet_model->get_data_vehicle_groups();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();
        $data['vendors'] = $this->Fleet_model->get_vendor();
        $data['inspection_forms'] = $this->Fleet_model->get_inspection_forms();

        $data['currency_name'] = get_setting('default_currency');
        

        return $this->template->rander('Fleet\Views\vehicles/vehicle_detail', $data);
    }
    
    /* Edit driver document or add new driver document */
    public function driver_document($id = '')
    {
        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            if ($id == '') {

                $id = $this->Fleet_model->add_driver_document($data);

                if ($id) {
                    handle_driver_document_attachments($id);

                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('document')));
                    app_redirect('fleet/driver_document/' . $id);
                }
            } else {
                $success = $this->Fleet_model->update_driver_document($data, $id);
                handle_driver_document_attachments($id);

                if($data['driver_id'] != 0){
                    $url = 'fleet/driver_detail/' . $data['driver_id'].'?group=driver_documents';
                }else{
                    $url = 'fleet/vehicle/' . $data['vehicle_id'].'?group=vehicle_document';
                }

                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('document')));
                app_redirect('fleet/driver_document/' . $id);
            }
        }

        $data['driver_id'] = $this->request->getGet('driver_id');

        $data['vehicle_id'] = $this->request->getGet('vehicle_id');

        if ($id == '') {
            $title = _l('add_new', _l('document'));
        } else {
            $data['driver_document']                 = $this->Fleet_model->get_driver_document($id, [], true);

            $title = $data['driver_document']->subject;
            $data['driver_id'] = $data['driver_document']->driver_id;
            $data['vehicle_id'] = $data['driver_document']->vehicle_id;
        }

        $data['title']         = $title;
        return $this->template->rander('Fleet\Views\driver_documents/driver_document', $data);
    }

    /**
     * Adds an driver document attachment.
     *
     * @param        $id     The identifier
     */
    public function add_driver_document_attachment($id)
    {
        $driver_id = $this->request->getGet('driver_id');
        $vehicle_id = $this->request->getGet('vehicle_id');
        handle_driver_document_attachments($id);

        if($driver_id != '' && $driver_id != 0){
            $url = admin_url('fleet/driver_detail/' . $driver_id.'?group=driver_documents');
        }else{
            $url = admin_url('fleet/vehicle/' . $vehicle_id.'?group=vehicle_document');
        }
        echo json_encode([
            'url' => $url
        ]);
        die;
    }

    /**
     * driver documents table
     * @return json
     */
    public function driver_documents_table(){
           
            $select = [
                'id',
                'subject',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $rel_id = '';
            $rel_type = '';

            $driverid = $this->request->getPost("driverid");
            if($driverid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_driver_documents.driver_id ="'.$driverid.'"');
                $rel_id = $driverid;
                $rel_type = 'driver';
            }

            $vehicleid = $this->request->getPost("vehicleid");
            if($vehicleid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_driver_documents.vehicle_id ="'.$vehicleid.'"');
                $rel_id = $vehicleid;
                $rel_type = 'vehicle';
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_driver_documents';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['subject'];

                $categoryOutput .= '<div class="row-options">';
                $categoryOutput .= '<a href="' . admin_url('fleet/view_driver_documents/' . $aRow['id']) . '">' . _l('view') . '</a>';

                if (fleet_has_permission('fleet_can_edit_vehicle') || fleet_has_permission('fleet_can_edit_driver')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/driver_document/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                }
            
                if (fleet_has_permission('fleet_can_delete_vehicle') || fleet_has_permission('fleet_can_delete_driver')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_driver_document/' . $aRow['id'].'/'.$rel_id.'/'.$rel_type) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;

                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * add vehicle assignment
     * @return json
     */
    public function vehicle_assignment(){
        $data = $this->request->getPost();

        if($data['id'] == ''){
            if (!has_permission('fleet_vehicle_assignment', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_vehicle_assignment($data);
            if($success){
                $message = _l('added_successfully');

                $vehicle = $this->Fleet_model->get_vehicle($data['vehicle_id']);

                if($data['driver_id'] != get_staff_user_id()){
                    fleet_log_notification('fleet_vehicle_assigned_to_you', [
                            'fleet_vehicle_id'     => $data['vehicle_id']
                        ], get_staff_user_id(), $data['driver_id']);
                }

                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('vehicle_assignment')));

            }else {
                $this->session->setFlashdata("error_message", _l('vehicle_assignment_failed'));
            }
        }else{
            if (!has_permission('fleet_vehicle_assignment', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_vehicle_assignment($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('vehicle_assignment')));
            }
        }
        
        app_redirect('fleet/vehicle/'.$data['vehicle_id'].'?group=assignment_history');
    }
    
    /**
     * vehicle assignments table
     * @return json
     */
    public function vehicle_assignments_table(){
           
            $select = [
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                'driver_id',
                'start_time',
                'end_time',
                'starting_odometer',
                'ending_odometer',
                db_prefix() . 'fleet_vehicle_assignments.addedfrom as addedfrom',
            ];

            $where = [];
            $rel_id = '';
            $rel_type = '';

            $is_report = $this->request->getPost("is_report");
            $vehicle_id = $this->request->getPost("id");
            if($vehicle_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_vehicle_assignments.vehicle_id ="'.$vehicle_id.'"');
                $rel_id = $vehicle_id;
                $rel_type = 'vehicle';
            }

            $driverid = $this->request->getPost("driverid");
            if($driverid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_vehicle_assignments.driver_id ="'.$driverid.'"');
                $rel_id = $driverid;
                $rel_type = 'driver';
            }


            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_vehicle_assignments';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_vehicle_assignments.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_vehicle_assignments.id as id', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $categoryOutput = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">'.$aRow['vehicle_name'].'</a>';

                if ($is_report == '') {
                    $categoryOutput .= '<div class="row-options">';
                    if (fleet_has_permission('fleet_can_edit_vehicle') || fleet_has_permission('fleet_can_edit_driver')) {
                        $categoryOutput .= '<a href="#" onclick="edit_vehicle_assignment(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                    }
                
                    if (fleet_has_permission('fleet_can_delete_vehicle') || fleet_has_permission('fleet_can_delete_driver')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_vehicle_assignment/' . $aRow['id'].'/'. $rel_id.'/'. $rel_type) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $categoryOutput .= '</div>';
                }

                $row[] = $categoryOutput;

                $row[] = get_staff_full_name($aRow['driver_id']);
                $row[] = _d($aRow['start_time']);
                $row[] = _d($aRow['end_time']);
                $row[] = $aRow['starting_odometer'];
                $row[] = $aRow['ending_odometer'];
                $row[] = get_staff_full_name($aRow['addedfrom']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
    * mantanances
    */
    public function maintenances(){
        $this->required_module();
        if ($this->request->getPost()) {
            $data  = $this->request->getPost();
            $insert_id = 0;
            if($data['id'] == ''){
                unset($data['id']);
                $insert_id = $this->Fleet_model->add_maintenances($data);
                if($insert_id > 0){
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('maintenances')));
                }
                else{
                    $this->session->setFlashdata("error_message", sprintf(_l('added_fail'), _l('maintenances')));
                }
            }
            else
            {
                $result = $this->Fleet_model->update_maintenances($data);
                if($result == true){
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('maintenances')));
                }
                else{
                    $this->session->setFlashdata("error_message", sprintf(_l('no_data_changes'), _l('maintenances')));
                }
            }
            $redirect = $this->request->getGet('redirect');
            if($redirect != ''){
                $rel_type = $this->request->getGet('rel_type');
                $rel_id = $this->request->getGet('rel_id');
                if($rel_type != '' && is_numeric($rel_id)){
                    if($rel_type == 'audit'){
                        $this->Fleet_model->update_audit_detail_item($data['asset_id'], $rel_id, ['maintenance_id' => $insert_id]);
                    }
                    if($rel_type == 'cart_detailt'){
                        $this->Fleet_model->update_cart_detail($rel_id, ['maintenance_id' => $insert_id]);
                    }
                }
                app_redirect($redirect);
            }
            else{
                app_redirect('fleet/maintenances');         
            }
        }

        $data['title']    = _l('maintenances');
        $base_currency = get_setting('default_currency');
        $data['currency_name'] = get_setting('default_currency');

        $data['garages'] = $this->Fleet_model->get_garages();
        $data['vendors'] = $this->Fleet_model->get_vendor();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['parts'] = $this->Fleet_model->get_part();
        return $this->template->rander('Fleet\Views\maintenances/manage', $data);
    }

    /**
    * maintenances table
    * @return json 
    */
    public function maintenances_table(){
            if($this->request->getPost()){

    
                $currency_name = get_setting('default_currency');
                

                $select = [
                    db_prefix() . 'fleet_maintenances.id as id',
                    db_prefix() . 'fleet_vehicles.name as vehicle_name',
                    'maintenance_type',
                    'title',
                    'start_date',
                    'completion_date',
                    'cost',
                ];


                $where        = [];


                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'fleet_maintenances';
                $join         = [
                    'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_maintenances.vehicle_id',
                ];

                $is_report = $this->request->getPost("is_report");
                $vehicle_id = $this->request->getPost("id");
                if($vehicle_id != ''){
                    array_push($where, ' AND '.db_prefix() . 'fleet_maintenances.vehicle_id ="'.$vehicle_id.'"');
                }

                $garage_id = $this->request->getPost("garage_id");
                if($garage_id != ''){
                    $is_report = 1;
                    array_push($where, ' AND '.db_prefix() . 'fleet_maintenances.garage_id ="'.$garage_id.'"');
                }

                $maintenance_type = $this->request->getPost("maintenance_type");
                $from_date = $this->request->getPost("from_date");
                $to_date = $this->request->getPost("to_date");

                if($maintenance_type != ''){
                    array_push($where, ' AND maintenance_type = "'.$maintenance_type.'"');
                }
                if($from_date != '' && $to_date == ''){
                    $from_date = fe_format_date($from_date);
                    array_push($where, ' AND date(start_date)="'.$from_date.'"');
                }
                if($from_date != '' && $to_date != ''){
                    $from_date = fe_format_date($from_date);
                    $to_date = fe_format_date($to_date);
                    array_push($where, ' AND date(start_date) between "'.$from_date.'" AND "'.$to_date.'"');
                }

                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_maintenances.notes as notes', 'supplier_id'
                    
                ]);

                $output  = $result['output'];
                $rResult = $result['rResult'];  
                foreach ($rResult as $aRow) {
                    $row = [];
                    $row[] = $aRow['id'];

                    $categoryOutput = '<a href="' . admin_url('fleet/maintenance_detail/' . $aRow['id']) . '">'.$aRow['vehicle_name'].'</a>';

                    if ($is_report == '') {
                        $categoryOutput .= '<div class="row-options">';

                        $categoryOutput .= '<a href="'.admin_url('fleet/maintenance_detail/'.$aRow['id'].'').'">' . _l('view') . '</a>';

                        if (fleet_has_permission('fleet_can_edit_maintenance')) {
                            $categoryOutput .= ' | <a href="#" onclick="edit_maintenances(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                        }

                        if (fleet_has_permission('fleet_can_delete_maintenance')) {
                            $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_maintenances/' . $aRow['id'].'/'.$vehicle_id) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                        }

                        $categoryOutput .= '</div>';
                    }

                   
                    $row[] = $categoryOutput;  
                    $row[] = _l('fe_'.$aRow['maintenance_type']);  
                    $row[] = '<span class="text-nowrap">'.$aRow['title'].'</span>';  
                    $row[] = '<span class="text-nowrap">'._d($aRow['start_date']).'</span>';  
                    $row[] = '<span class="text-nowrap">'._d($aRow['completion_date']).'</span>';   
                    $row[] = $aRow['notes']; 
                    $row[] = to_currency($aRow['cost'], $currency_name);  

                    $output['aaData'][] = $row;                                      
                }

                echo json_encode($output);
                die();
            }
    }

    /**
    * get data maintenances
    * @param  integer $id 
    */
    public function get_data_maintenances($id){
        $data_assets = $this->Fleet_model->get_maintenances($id);
        if($data_assets){
            $data_assets->completion_date = _d($data_assets->completion_date);
            $data_assets->start_date = _d($data_assets->start_date);
        }
        echo json_encode($data_assets);
        die;
    }

    /**
    * delete maintenances
    * @param  integer $id 
    */
    public function delete_maintenances($id, $vehicle_id = ''){
        if($id != ''){
            $result =  $this->Fleet_model->delete_maintenances($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('maintenances')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('maintenances')));
            }
        }

        if ($vehicle_id != '') {
            app_redirect('fleet/vehicle/'.$vehicle_id.'?group=maintenance');
        }

        app_redirect('fleet/maintenances');
    }

    /**
    * garages
    */
    public function garages(){
        $this->required_module();
        if ($this->request->getPost()) {
            $data  = $this->request->getPost();
            $insert_id = 0;
            if($data['id'] == ''){
                unset($data['id']);
                $insert_id = $this->Fleet_model->add_garages($data);
                if($insert_id > 0){
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('garages')));
                }
                else{
                    $this->session->setFlashdata("error_message", sprintf(_l('added_fail'), _l('garages')));
                }
            }
            else
            {
                $result = $this->Fleet_model->update_garages($data);
                if($result == true){
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('garages')));
                }
                else{
                    $this->session->setFlashdata("error_message", sprintf(_l('no_data_changes'), _l('garages')));
                }
            }
            $redirect = $this->request->getGet('redirect');
            if($redirect != ''){
                $rel_type = $this->request->getGet('rel_type');
                $rel_id = $this->request->getGet('rel_id');
                if($rel_type != '' && is_numeric($rel_id)){
                    if($rel_type == 'audit'){
                        $this->Fleet_model->update_audit_detail_item($data['asset_id'], $rel_id, ['maintenance_id' => $insert_id]);
                    }
                    if($rel_type == 'cart_detailt'){
                        $this->Fleet_model->update_cart_detail($rel_id, ['maintenance_id' => $insert_id]);
                    }
                }
                app_redirect($redirect);
            }
            else{
                app_redirect('fleet/garages');         
            }
        }

        $data['title']    = _l('garages');
        $base_currency = get_setting('default_currency');
        $data['currency_name'] = get_setting('default_currency');
        $data['vendors'] = $this->Fleet_model->get_vendor();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        return $this->template->rander('Fleet\Views\garages/manage', $data);
    }

    /**
    * garages table
    * @return json 
    */
    public function garages_table(){
            if($this->request->getPost()){

    
                $currency_name = get_setting('default_currency');

                $select = [
                    'id',
                    'name',
                    'address',
                    'country',
                    'city',
                    'zip',
                    'state',
                    'notes'
                ];

                $where        = [];
                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'fleet_garages';
                $join         = [
                ];

                $maintenance_type = $this->request->getPost("maintenance_type");

                if($maintenance_type != ''){
                    array_push($where, ' AND maintenance_type = "'.$maintenance_type.'"');
                }

                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

                $output  = $result['output'];
                $rResult = $result['rResult'];  
                foreach ($rResult as $aRow) {
                    $row = [];
                    $row[] = $aRow['id'];

                    $_data = '';
                    $_data .= '<div class="row-options">';
                    $_data .= '<a href="'.admin_url('fleet/garage_detail/'.$aRow['id'].'').'">' . _l('view') . '</a>';

                    if(fleet_has_permission('fleet_can_edit_garage')){
                        $_data .= ' | <a href="javascript:void(0)" onclick="edit('.$aRow['id'].'); return false;">' . _l('edit') . '</a>';
                    }
                    if(fleet_has_permission('fleet_can_delete_garage')){
                        $_data .= ' | <a href="'.admin_url('fleet/delete_garages/'.$aRow['id'].'').'" class="text-danger _delete">' . _l('fe_delete') . '</a>';
                    }

                    $_data .= '</div>'; 
                    $row[] = '<span class="text-nowrap">'.$aRow['name'].'</span>'.$_data;  
                    $row[] = $aRow['address']; 
                    $row[] = $aRow['country']; 
                    $row[] = $aRow['city']; 
                    $row[] = $aRow['zip']; 
                    $row[] = $aRow['state']; 
                    $row[] = $aRow['notes']; 

                    $output['aaData'][] = $row;                                      
                }

                echo json_encode($output);
                die();
            }
    }

    /**
    * get data garages
    * @param  integer $id 
    */
    public function get_data_garages($id){
        $data_garages = $this->Fleet_model->get_garages($id);
       
        echo json_encode($data_garages);
        die;
    }

    /**
    * delete garages
    * @param  integer $id 
    */
    public function delete_garages($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_garages($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('garages')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('garages')));
            }
        }
        app_redirect('fleet/garages');
    }

    /**
     * fuels
     * @return view
     */
    public function fuels(){

        $this->required_module();
        if (!has_permission('fleet_fuel', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('fuels');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['vendors'] = $this->Fleet_model->get_vendor();

        return $this->template->rander('Fleet\Views\fuels/manage', $data);
    }

    /**
     * fuel history table
     * @return json
     */
    public function fuel_history_table()
    {

            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                'fuel_time',
                'vendor_id',
                db_prefix() . 'fleet_fuel_history.odometer as odometer',
                'gallons',
                'price',
            ];

            $where = [];

            $is_report = $this->request->getPost("is_report");

            $vehicle_id = $this->request->getPost("id");
            if($vehicle_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_fuel_history.vehicle_id ="'.$vehicle_id.'"');
            }



            $fuel_type = $this->request->getPost("fuel_type");
            if($fuel_type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_fuel_history.fuel_type ="'.$fuel_type.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (fuel_time >= "' . $from_date . '" and fuel_time <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (fuel_time >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (fuel_time <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_fuel_history';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_fuel_history.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['vehicle_id', db_prefix() . 'fleet_fuel_history.id as id',]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">'.$aRow['vehicle_name'].'</a>';

                if ($is_report == '') {
                    $categoryOutput .= '<div class="row-options">';

                    if (fleet_has_permission('fleet_can_edit_fuel')) {
                        $categoryOutput .= '<a href="#" onclick="edit_fuel(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                    }

                    if (fleet_has_permission('fleet_can_delete_fuel')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_fuel/' . $aRow['id'].'/'.$vehicle_id) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $categoryOutput .= '</div>';
                }
                $row[] = $categoryOutput;
                $row[] = _dt($aRow['fuel_time']);
                $row[] = get_vendor_company_name($aRow['vendor_id']);
                $row[] = $aRow['odometer'] != null ? number_format((float)$aRow['odometer']) : '';
                $row[] = $aRow['gallons'] != null ? number_format((float)$aRow['gallons']) : '';
                $row[] = to_currency($aRow['price'], $currency);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * add fuel
     * @return json
     */
    public function add_fuel(){
        $data = $this->request->getPost();

        $redirect = 'insurances';
        if(isset($data['redirect'])){
            $redirect = $data['redirect'];
            unset($data['redirect']);
        }


        if($data['id'] == ''){
            if (!has_permission('fleet_fuel', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_fuel_history($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('fuel')));
            }else {
                $this->session->setFlashdata("error_message", _l('fuel_failed'));
            }
        }else{
            if (!has_permission('fleet_fuel', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_fuel_history($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('fuel')));
            }
        }

        if($redirect == 'vehicle'){
            app_redirect('fleet/vehicle/'.$data['vehicle_id'].'?group=fuel_history');
        }

        app_redirect('fleet/fuels');
    }

    /**
    * get data fuel
    * @param  integer $id 
    */
    public function get_data_fuel($id){
        $data_garages = $this->Fleet_model->get_fuel_history($id);
       
        echo json_encode($data_garages);
        die;
    }

    /**
    * delete fuel
    * @param  integer $id 
    */
    public function delete_fuel($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_fuel_history($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('fuel')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('fuel')));
            }
        }
        app_redirect('fleet/fuels');
    }

    /**
     * inspections
     * @return view
     */
    public function inspections(){
        $this->required_module();
        if (!has_permission('fleet_inspection', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('inspections');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['inspection_forms'] = $this->Fleet_model->get_inspection_forms();

        return $this->template->rander('Fleet\Views\inspections/manage', $data);
    }
    
    /**
     * Add new inspection form or update existing
     * @param integer id
     */
    public function inspection_form($id = '') {
        if (!has_permission('fleet_setting', '', 'view')) {
            access_denied('inspection_form');
        }
        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            if ($id == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('inspection_form');
                }
                $id = $this->Fleet_model->add_inspection_form($data);
                if ($id) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('inspection_form')));
                    app_redirect('fleet/inspection_form/' . $id);
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('inspection_form');
                }
                $success = $this->Fleet_model->update_inspection_form($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('inspection_form')));
                }
                app_redirect('fleet/inspection_form/' . $id);
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('inspection_form'));
        } else {
            $inspection_form = $this->Fleet_model->get_inspection_form($id);
            $data['inspection_form'] = $inspection_form;
            $title = $inspection_form->name;
        }
       
        $data['title'] = $title;

        return $this->template->rander('Fleet\Views\settings/inspection_form', $data);
    }

    /* New inspection form question */
    public function add_inspection_question_form() {
        if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die();
        }
            if ($this->request->getPost()) {
                echo json_encode([
                    'data' => $this->Fleet_model->add_inspection_question_form($this->request->getPost()),
                    'survey_question_only_for_preview' => _l('hr_survey_question_only_for_preview'),
                    'survey_question_required' => _l('required'),
                    'survey_question_string' => _l('question'),
                ]);
                die();
            }
    }

    /* Update question */
    public function update_inspection_question_form() {
        if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die();
        }
            if ($this->request->getPost()) {
                $this->Fleet_model->update_inspection_question_form($this->request->getPost());
            }
    }

    /* Remove survey question */
    public function remove_question($questionid)
    {
        if (!has_permission('surveys', '', 'edit')) {
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die();
        }
            echo json_encode([
                'success' => $this->Fleet_model->remove_question($questionid),
            ]);
    }

    /* Removes survey checkbox/radio description*/
    public function remove_box_description($questionboxdescriptionid)
    {
        if (!has_permission('surveys', '', 'edit')) {
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die();
        }
            echo json_encode([
                'success' => $this->Fleet_model->remove_box_description($questionboxdescriptionid),
            ]);
    }

    /* Add box description */
    public function add_box_description($questionid, $boxid)
    {
        if (!has_permission('surveys', '', 'edit')) {
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die();
        }
            $boxdescriptionid = $this->Fleet_model->add_box_description($questionid, $boxid);
            echo json_encode([
                'boxdescriptionid' => $boxdescriptionid,
            ]);
    }

    /* Reorder surveys */
    public function update_inspection_questions_orders()
    {
        if (fleet_has_permission('fleet_can_edit_setting')) {
                if ($this->request->getPost()) {
                    $this->Fleet_model->update_inspection_questions_orders($this->request->getPost());
                }
        }
    }

    /**
     * inspection forms table
     * @return json
     */
    public function inspection_forms_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_inspection_forms';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="' . admin_url('fleet/inspection_form/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_inspection_form/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * delete inspection form
     * @param  [type] $id
     * @return [type]
     */
    public function delete_inspection_form($id) {
        if (!has_permission('staffmanage_job_position', '', 'delete')) {
            access_denied('job_position');
        }
        if (!$id) {
            app_redirect('fleet/settings?group=inspection_forms');
        }
        $success = $this->Fleet_model->delete_inspection_form($id);
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('inspection_form')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=inspection_forms');
    }

    /**
    * inspections table
    * @return json 
    */
    public function inspections_table(){
            if($this->request->getPost()){

    
                $currency_name = get_setting('default_currency');

                $select = [
                    db_prefix() . 'fleet_vehicles.name as vehicle_name',
                    db_prefix() . 'fleet_inspection_forms.name as inspection_name',
                    db_prefix() . 'fleet_inspections.addedfrom as addedfrom',
                    db_prefix() . 'fleet_inspections.datecreated as datecreated',
                ];


                $where        = [];
                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'fleet_inspections';
                $join         = [
                    'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_inspections.vehicle_id',
                    'LEFT JOIN ' . db_prefix() . 'fleet_inspection_forms ON ' . db_prefix() . 'fleet_inspection_forms.id = ' . db_prefix() . 'fleet_inspections.inspection_form_id',
                ];

                $is_report = $this->request->getPost("is_report");
                $vehicle_id = $this->request->getPost("id");
                if($vehicle_id != ''){
                    array_push($where, ' AND '.db_prefix() . 'fleet_inspections.vehicle_id ="'.$vehicle_id.'"');
                }

                $from_date = $this->request->getPost("from_date");
                $to_date = $this->request->getPost("to_date");

                if($from_date != '' && $to_date == ''){
                    $from_date = fe_format_date($from_date);
                    array_push($where, ' AND date('.db_prefix() . 'fleet_inspections.datecreated)="'.$from_date.'"');
                }
                if($from_date != '' && $to_date != ''){
                    $from_date = fe_format_date($from_date);
                    $to_date = fe_format_date($to_date);
                    array_push($where, ' AND date('.db_prefix() . 'fleet_inspections.datecreated) between "'.$from_date.'" AND "'.$to_date.'"');
                }

                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() .'fleet_inspections.id as id'
                    
                ]);

                $output  = $result['output'];
                $rResult = $result['rResult'];  
                foreach ($rResult as $aRow) {
                    $row = [];

                    $_data = '';
                    if($is_report == ''){
                        $_data .= '<div class="row-options">';
                        $_data .= '<a href="' . admin_url('fleet/inspection_detail/' . $aRow['id']) . '">' . _l('view') . '</a>';

                        if(fleet_has_permission('fleet_can_edit_inspection')){
                            $_data .= ' | <a href="javascript:void(0)" onclick="edit_inspections('.$aRow['id'].'); return false;">' . _l('edit') . '</a>';
                        }
                        if(fleet_has_permission('fleet_can_delete_inspection')){
                            $_data .= ' | <a href="'.admin_url('fleet/delete_inspections/'.$aRow['id'].'/'.$vehicle_id).'" class="text-danger _delete">' . _l('fe_delete') . '</a>';
                        }
                        $_data .= '</div>'; 
                    }
                    $row[] = '<span class="text-nowrap">'.$aRow['vehicle_name'].'</span>'.$_data;  
                    $row[] = '<span class="text-nowrap">'.$aRow['inspection_name'].'</span>';  
                    $row[] = get_staff_full_name($aRow['addedfrom']);
                    $row[] = _d($aRow['datecreated']);  

                    $output['aaData'][] = $row;                                      
                }

                echo json_encode($output);
                die();
            }
    }

    /**
     * add inspection
     * @return json
     */
    public function add_inspection($vehicle_id = ''){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_inspection', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_inspection($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('inspection')));
            }else {
                $this->session->setFlashdata("error_message", _l('inspection_failed'));
            }
        }else{
            if (!has_permission('fleet_inspection', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_inspection($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('inspection')));
            }
        }

        if ($vehicle_id != '') {
            app_redirect('fleet/vehicle/'.$vehicle_id.'?group=inspections');
        }
        app_redirect('fleet/inspections');
    }

    /**
     * add inspection form content
     * @return json
     */
    public function get_inspection_form_content($inspection_form_id = '', $inspection_id = ''){
        if($inspection_form_id != ''){
            $data['inspection_form'] = $this->Fleet_model->get_inspection_form($inspection_form_id);
            $data['inspection_results'] = $this->Fleet_model->get_inspection_results($inspection_id);
            
            echo view('Fleet\Views\inspections/inspection_form_content', $data);
            die();
        }
    }

    /**
    * get data inspections
    * @param  integer $id 
    */
    public function get_data_inspections($id){
        $data_assets = $this->Fleet_model->get_inspections($id);
        
        echo json_encode($data_assets);
        die;
    }

    /**
    * delete inspections
    * @param  integer $id 
    */
    public function delete_inspections($id, $vehicle_id = ''){
        if($id != ''){
            $result =  $this->Fleet_model->delete_inspection($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('inspection')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('inspection')));
            }
        }

        if ($vehicle_id != '') {
            app_redirect('fleet/vehicle/'.$vehicle_id.'?group=inspections');
        }
        app_redirect('fleet/inspections');
    }

    /**
     * parts list
     * @param  integer $id
     * @return load view
     */
    public function parts($id = '') {
        $this->required_module();
        if(!has_permission('fleet_part', '', 'view')) {
            access_denied('fleet');
        }

        $data['part_types'] = $this->Fleet_model->get_data_part_types();
        $data['part_groups'] = $this->Fleet_model->get_data_part_groups();

        $data['title']         = _l('parts');
        return $this->template->rander('Fleet\Views\parts/manage', $data);
    }

    /**
     * add maintenance
     * @return json
     */
    public function add_maintenance(){
        $data = $this->request->getPost();
        
        $redirect = 'insurances';
        if(isset($data['redirect'])){
            $redirect = $data['redirect'];
            unset($data['redirect']);
        }

        $message = '';
        if($data['id'] == ''){
            if (!has_permission('fleet_maintenance', '', 'create')) {
                access_denied('fleet');
            }

            $success = $this->Fleet_model->add_maintenances($data);
            if($success){
                $message = _l('added_successfully');
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('maintenance')));
            }else {
                $this->session->setFlashdata("error_message", _l('maintenance_failed'));
            }
        }else{
            if (!has_permission('fleet_maintenance', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_maintenances($data, $id);
            if ($success) {
                $message = _l('updated_successfully', _l('maintenance'));
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('maintenance')));
            }else{
                $message = _l('update_failed', _l('maintenance'));
                $this->session->setFlashdata("error_message", sprintf(_l('update_failed'), _l('maintenance')));
            }
        }

        if($redirect == 'vehicle'){
            app_redirect('fleet/vehicle/'.$data['vehicle_id'].'?group=maintenance');
        }

        app_redirect('fleet/maintenances');
    }

    /**
     * fuels
     * @return view
     */
    public function benefit_and_penalty(){
        $this->required_module();
        if (!has_permission('fleet_benefit_and_penalty', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('benefit_and_penalty');
        $data['drivers'] = $this->Fleet_model->get_driver();
        $data['criterias'] = $this->Fleet_model->get_criterias();

        return $this->template->rander('Fleet\Views\benefit_and_penalty/manage', $data);
    }

    /**
     * benefit and penalty table
     * @return json
     */
    public function benefit_and_penalty_table()
    {


            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_benefit_and_penalty.id as id', // bulk actions
                'subject',
                'driver_id',
                'type',
                'date',
            ];

            $where = [];

            $id = $this->request->getPost("driverid");
            if($id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_benefit_and_penalty.driver_id ="'.$id.'"');
            }

            $fuel_type = $this->request->getPost("type");
            if($fuel_type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_benefit_and_penalty.type ="'.$fuel_type.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (date <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_benefit_and_penalty';
            $join         = [
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $row[] = $aRow['id'];
                $categoryOutput = $aRow['subject'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_benefit_and_penalty')) {
                    $categoryOutput .= '<a href="#" onclick="edit_benefit_and_penalty(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_benefit_and_penalty')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_benefit_and_penalty/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['driver_id']);
                $row[] = _l($aRow['type']);
                $row[] = _d($aRow['date']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }
    
    /**
     * add benefit_and_penalty
     * @return json
     */
    public function add_benefit_and_penalty(){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_benefit_and_penalty', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_benefit_and_penalty($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('benefit_and_penalty')));
            }else {
                $this->session->setFlashdata("error_message", _l('benefit_and_penalty_failed'));
            }
        }else{
            if (!has_permission('fleet_benefit_and_penalty', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_benefit_and_penalty($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('benefit_and_penalty')));
            }
        }
        app_redirect('fleet/benefit_and_penalty');
    }

    /**
    * delete benefit_and_penalty
    * @param  integer $id 
    */
    public function delete_benefit_and_penalty($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_benefit_and_penalty($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('benefit_and_penalty')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('benefit_and_penalty')));
            }
        }
        app_redirect('fleet/benefit_and_penalty');
    }

    /**
    * get data benefit_and_penalty
    * @param  integer $id 
    */
    public function get_data_benefit_and_penalty($id){
        $data_benefit_and_penalty = $this->Fleet_model->get_benefit_and_penalty($id);
       
        echo json_encode($data_benefit_and_penalty);
        die;
    }

    /**
     * criterias table
     * @return json
     */
    public function criterias_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_criterias';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_criteria(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_criteria/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * delete criteria
     * @param  integer $id
     * @return
     */
    public function delete_criteria($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_criteria($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('criteria')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=criterias');
    }

    /**
     * get data criteria
     * @param  integer $id 
     * @return json     
     */
    public function get_data_criteria($id){
        $criteria = $this->Fleet_model->get_criterias($id);

        echo json_encode($criteria);
    }

    /**
     *
     *  add or edit criteria
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function criteria()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_criteria($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('criteria')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_criteria($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('criteria')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=criterias');
        }
    }

    /**
    * delete vehicle_assignment
    * @param  integer $id 
    */
    public function delete_vehicle_assignment($id, $rel_id = '', $rel_type = ''){
        if($id != ''){
            $result =  $this->Fleet_model->delete_vehicle_assignment($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('vehicle_assignment')));
            }
            else{
                $this->session->setFlashdata("error_message", _l('can_not_delete'));
            }
        }
        if($rel_type == 'vehicle'){
            app_redirect('fleet/vehicle/'.$rel_id.'?group=assignment_history');
        }elseif($rel_type == 'driver'){
            app_redirect('fleet/driver_detail/'.$rel_id.'?group=vehicle_assignments');
        }
    }

    /**
    * get data vehicle_assignment
    * @param  integer $id 
    */
    public function get_data_vehicle_assignment($id){
        $data_vehicle_assignment = $this->Fleet_model->get_vehicle_assignment($id);
       
        echo json_encode($data_vehicle_assignment);
        die;
    }

    /**
     * bookings
     * @return view
     */
    public function bookings(){
        $this->required_module();
        if (!has_permission('fleet_bookings', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('bookings');
        $data['booking_status'] = fleet_booking_status();
        $data['clients'] = $this->Clients_model->get_details(["is_lead" => 0, 'delete' => 0])->getResultArray();

        return $this->template->rander('Fleet\Views\bookings/manage', $data);
    }

    /**
     * bookings table
     * @return json
     */
    public function bookings_table()
    {
            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_bookings.id as id',
                db_prefix() . 'fleet_bookings.subject as subject',
                db_prefix() . 'fleet_bookings.delivery_date as delivery_date',
                db_prefix() . 'clients.company_name as company',
                db_prefix() . 'fleet_bookings.status as status',
                db_prefix() . 'fleet_bookings.amount as amount',
                'invoice_id',
            ];

            $where = [];

            $status = $this->request->getPost("status");
            if($status != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_bookings.status ="'.$status.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (delivery_date >= "' . $from_date . '" and delivery_date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (delivery_date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (delivery_date <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_bookings';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.id = ' . db_prefix() . 'fleet_bookings.userid',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['number']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/booking_detail/' . $aRow['id']) . '">' . $aRow['number'] . '</a>';

                $categoryOutput .= '<div class="row-options">';

                $categoryOutput .= '<a href="' . admin_url('fleet/booking_detail/' . $aRow['id']) . '">' . _l('view') . '</a>';

                if (fleet_has_permission('fleet_can_delete_booking')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_booking/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = $aRow['subject'];
                $row[] = _d($aRow['delivery_date']);
                $row[] = $aRow['company'];
                $row[] = to_currency($aRow['amount'], $currency);
                $row[] = fleet_render_status_html($aRow['id'], 'booking', $aRow['status'], false);
                $row[] = '<a href="'. admin_url('invoices/view/'.$aRow['invoice_id']) .'">' . ($aRow['invoice_id'] != 0 ? get_invoice_id($aRow['invoice_id']) : '') .'</a>';

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * view booking detail
     * @return view
     */
    public function booking_detail($id = ''){

        $data['booking'] = $this->Fleet_model->get_booking($id);
        $data['bookings'] = $this->Fleet_model->get_booking();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();

        $data['title'] = _l('booking');
        
        return $this->template->rander('Fleet\Views\bookings/booking_detail', $data);
    }

    /**
     * { booking change status }
     *
     * @param  $order_number  The order number
     * @return json
     */
    public function booking_status_mark_as($status, $booking_id){
        $message = '';
        $success = $this->Fleet_model->booking_change_status($status, $booking_id);
        if ($success) {
            $message = _l('updated_successfully');
        }               

        echo json_encode([
                    'message' => $message,
                    'success' => $success
                ]);
        die;
    }

    public function booking_update_info(){
        if (!has_permission('fleet_bookings', '', 'edit')) {
            access_denied('fleet');
        }

        $data = $this->request->getPost();
        $id = '';
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
        }

        if(isset($data['amount'])){
            $data['amount'] = str_replace(',', '', $data['amount']);
        }

        $success = $this->Fleet_model->update_booking($data, $id);

        if ($success == true) {
            $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('booking')));
        }

        app_redirect('fleet/booking_detail/' . $id);
    }

    /**
     * create invoice by booking
     * @param  integer $id the booking id
     * @return json
     */
    public function create_invoice_by_booking($id)
    {
        if (!has_permission('fleet_bookings', '', 'create')) {
            access_denied('fleet_bookings');
        }
        $invoice_id = $this->Fleet_model->create_invoice_by_booking($id);
        $message    = $invoice_id ? _l('create_invoice_successfully') : '';


        $invoice_number = '';
        if ($invoice_id > 0) {
            $invoice_number = '<a href="' . admin_url('invoices/view/' . $invoice_id) . '" target="_blank">' . get_invoice_id($invoice_id) . '</a>';
        }
        echo json_encode([
            'invoice_number' => $invoice_number,
            'message'        => $message,
        ]);
        die();
    }

    /**
    * delete booking
    * @param  integer $id 
    */
    public function delete_booking($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_booking($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('booking')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('booking')));
            }
        }
        app_redirect('fleet/bookings');
    }

    /**
     * add booking
     * @return json
     */
    public function booking(){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_bookings', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_booking($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('booking')));
            }else {
                $this->session->setFlashdata("error_message", _l('bookings_failed'));
            }
        }else{
            if (!has_permission('fleet_bookings', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_booking($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('booking')));
            }
        }
        app_redirect('fleet/bookings');
    }

    /**
     * garage detail
     * @param  integer $garage_id 
     * @return view               
     */
    public function garage_detail($garage_id) {

        $data['garage'] = $this->Fleet_model->get_garages($garage_id);
        $data['staffs']         = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff", "status" => "active"))->getResultArray();

        return $this->template->rander('Fleet\Views\garages/garage_detail', $data);

    }

    public function maintenance_team_table(){
        
        $aColumns = [
            'first_name',
            'email',
            db_prefix() . 'roles.title',
            'last_online',
            'status',
            ];
            
        $sIndexColumn = 'id';
        $sTable       = db_prefix() . 'fleet_maintenance_teams';
        $join         = [
            'LEFT JOIN ' . db_prefix() . 'users ON ' . db_prefix() . 'users.id = ' . db_prefix() . 'fleet_maintenance_teams.staffid',
            'LEFT JOIN ' . db_prefix() . 'roles ON ' . db_prefix() . 'roles.id = ' . db_prefix() . 'users.role_id'
        ];
        $i            = 0;

        $where = [];
        $garage_id = $this->request->getPost("garage_id");
        if($garage_id != ''){
            array_push($where, ' AND '.db_prefix() . 'fleet_maintenance_teams.garage_id ="'.$garage_id.'"');
        }

        $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
            db_prefix() . 'fleet_maintenance_teams.staffid as staffid',
            db_prefix() . 'fleet_maintenance_teams.id as id',
            'image',
            'last_name',
            ]);

        $output  = $result['output'];
        $rResult = $result['rResult'];

        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
                    $_data = $aRow[strafter($aColumns[$i], 'as ')];
                } else {
                    $_data = $aRow[$aColumns[$i]];
                }
                if ($aColumns[$i] == 'last_online') {
                    if ($_data != null) {
                        $_data = '<span class="text-has-action is-date" data-toggle="tooltip" data-title="' . _d($_data) . '">' . time_ago($_data) . '</span>';
                    } else {
                        $_data = 'Never';
                    }
                } elseif ($aColumns[$i] == 'status') {
                    $checked = '';
                    if ($aRow['status'] == 'active') {
                        $checked = 'checked';
                    }

                    $_data = '<div class="onoffswitch">
                        <input type="checkbox" ' . (($aRow['staffid'] == get_staff_user_id() || (is_admin($aRow['staffid']) || !has_permission('staff', '', 'edit')) && !is_admin()) ? 'disabled' : '') . ' data-switch-url="' . admin_url('') . 'staff/change_staff_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_' . $aRow['staffid'] . '" data-id="' . $aRow['staffid'] . '" ' . $checked . '>
                        <label class="onoffswitch-label" for="c_' . $aRow['staffid'] . '"></label>
                    </div>';

                    // For exporting
                    $_data .= '<span class="hide">' . ($checked == 'checked' ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
                } elseif ($aColumns[$i] == 'first_name') {
                    $image_url = get_avatar($aRow['image']);
                    $user_avatar = "<span class='avatar avatar-xs'><img src='$image_url' alt='...'></span>";

                    $_data = '<a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . $user_avatar . '</a>';
                    $_data .= ' <a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . $aRow['first_name'] . ' ' . $aRow['last_name'] . '</a>';

                    $_data .= '<div class="row-options">';
                    $_data .= '<a href="' . admin_url('fleet/driver_detail/' . $aRow['staffid']) . '">' . _l('view') . '</a>';

                    if (fleet_has_permission('fleet_can_edit_garage')) {
                        $_data .= ' | <a href="' . admin_url('fleet/delete_maintenance_team/' . $aRow['id'].'/' . $garage_id) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $_data .= '</div>';
                } elseif ($aColumns[$i] == 'email') {
                    $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
                } else {
                    if (strpos($aColumns[$i], 'date_picker_') !== false) {
                        $_data = (strpos($_data, ' ') !== false ? _d($_data) : _d($_data));
                    }
                }
                $row[] = $_data;
            }

            $row['DT_RowClass'] = 'has-row-options';

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
        die();
    }

    /**
     * add or edit driver
     * @return view
     */
    public function add_maintenance_team($id = ''){
        if ($this->request->getPost()) {

            if (!has_permission('fleet_garage', '', 'create')) {
                access_denied('fleet_garages');
            }

            $data                = $this->request->getPost();
            $success = $this->Fleet_model->add_maintenance_team($data);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('maintenance_team')));
                app_redirect('fleet/garage_detail/'.$data['garage_id']);
            }
        }
    }

    /**
    * insurances
    */
    public function insurances(){
        $this->required_module();
        if ($this->request->getPost()) {
            $data  = $this->request->getPost();
            $insert_id = 0;
            if($data['id'] == ''){
                unset($data['id']);
                $insert_id = $this->Fleet_model->add_insurances($data);
                if($insert_id > 0){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurances')));
                }
                else{
                $this->session->setFlashdata("error_message", sprintf(_l('added_fail'), _l('insurances')));
                }
            }
            else
            {
                $result = $this->Fleet_model->update_insurances($data);
                if($result == true){
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurances')));
                }
                else{
                    $this->session->setFlashdata("error_message", sprintf(_l('no_data_changes'), _l('insurances')));
                }
            }
            $redirect = $this->request->getGet('redirect');
            if($redirect != ''){
                $rel_type = $this->request->getGet('rel_type');
                $rel_id = $this->request->getGet('rel_id');
                if($rel_type != '' && is_numeric($rel_id)){
                    if($rel_type == 'audit'){
                        $this->Fleet_model->update_audit_detail_item($data['asset_id'], $rel_id, ['insurance_id' => $insert_id]);
                    }
                    if($rel_type == 'cart_detailt'){
                        $this->Fleet_model->update_cart_detail($rel_id, ['insurance_id' => $insert_id]);
                    }
                }
                app_redirect($redirect);
            }
            else{
                app_redirect('fleet/insurances');         
            }
        }

        $data['title']    = _l('insurances');
        $base_currency = get_setting('default_currency');
        $data['currency_name'] = get_setting('default_currency');
        
        $data['insurance_categorys'] = $this->Fleet_model->get_insurance_category();
        $data['insurance_types'] = $this->Fleet_model->get_insurance_type();
        $data['insurance_status'] = $this->Fleet_model->get_data_insurance_status();
        $data['insurance_company'] = $this->Fleet_model->get_data_insurance_company();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        return $this->template->rander('Fleet\Views\insurances/manage', $data);
    }

    /**
     * insurances table
     * @return json
     */
    public function insurances_table()
    {
            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_insurances.name as name',
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_insurance_company.name as company_name',
                db_prefix() . 'fleet_insurance_status.name as status_name',
                db_prefix() . 'fleet_insurances.start_date as start_date',
                db_prefix() . 'fleet_insurances.end_date as end_date',
                db_prefix() . 'fleet_insurances.amount as amount',
            ];

            $where = [];

            $vehicleid = $this->request->getPost("vehicleid");
            if($vehicleid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_insurances.vehicle_id ="'.$vehicleid.'"');
            }

            $status = $this->request->getPost("status");
            if($status != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_insurances.status ="'.$status.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (start_date >= "' . $from_date . '" and start_date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (start_date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (start_date <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_insurances';
            $join         = [
            'LEFT JOIN ' . db_prefix() . 'fleet_insurance_company ON ' . db_prefix() . 'fleet_insurance_company.id = ' . db_prefix() . 'fleet_insurances.insurance_company_id',
            'LEFT JOIN ' . db_prefix() . 'fleet_insurance_status ON ' . db_prefix() . 'fleet_insurance_status.id = ' . db_prefix() . 'fleet_insurances.insurance_status_id',
            'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_insurances.vehicle_id'
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_insurances.id as id', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_insurance')) {
                    $categoryOutput .= '<a href="#" onclick="edit_insurance(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_insurance')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_insurance/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                $row[] = $aRow['company_name'];
                $row[] = $aRow['status_name'];
                $row[] = _d($aRow['start_date']);
                $row[] = _d($aRow['end_date']);
                $row[] = to_currency($aRow['amount'], $currency);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * work_performances
     * @return view
     */
    public function work_performances(){
        $this->required_module();
        if (!has_permission('fleet_work_performance', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('logbooks');
        $data['logbook_status'] = fleet_logbook_status();
        $data['bookings'] = $this->Fleet_model->get_booking();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();

        return $this->template->rander('Fleet\Views\work_performances/manage', $data);
    }

    /**
     * logbook table
     * @return json
     */
    public function logbook_table()
    {
            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_logbooks.id as id',
                db_prefix() . 'fleet_logbooks.name as name',
                db_prefix() . 'fleet_logbooks.date as date',
                db_prefix() . 'fleet_bookings.number as number',
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_logbooks.status as status',
            ];

            $where = [];
                $is_report = $this->request->getPost("is_report");
            $booking_id = $this->request->getPost("booking_id");
            if($booking_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_logbooks.booking_id ="'.$booking_id.'"');
            }

            $status = $this->request->getPost("status");
            if($status != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_logbooks.status ="'.$status.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (date <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_logbooks';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_bookings ON ' . db_prefix() . 'fleet_bookings.id = ' . db_prefix() . 'fleet_logbooks.booking_id',
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_logbooks.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['booking_id', 'driver_id', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/logbook_detail/' . $aRow['id']) . '">' . $aRow['name'] . '</a>';

                if($is_report == ''){
                    $categoryOutput .= '<div class="row-options">';

                    $categoryOutput .= '<a href="' . admin_url('fleet/logbook_detail/' . $aRow['id']) . '">' . _l('view') . '</a>';

                   if (fleet_has_permission('fleet_can_edit_work_performance')) {
                        $categoryOutput .= ' | <a href="#" onclick="edit_logbook(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                    }

                    if (fleet_has_permission('fleet_can_delete_work_performance')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_logbook/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $categoryOutput .= '</div>';
                }
                $row[] = $categoryOutput;
                $row[] = '<a href="' . admin_url('fleet/booking_detail/' . $aRow['booking_id']) . '">' . $aRow['number'] . '</a>';

                $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                $row[] = get_staff_full_name($aRow['driver_id']);
                $row[] = _d($aRow['date']);
                $row[] = fleet_render_status_html($aRow['id'], 'logbook', $aRow['status'], false);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * add logbook
     * @return json
     */
    public function logbook(){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_work_performance', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_logbook($data);
            if($success){
                if($data['driver_id'] != get_staff_user_id()){
                    fleet_log_notification('fleet_logbook_assigned_to_you', [
                        'fleet_logbook_id'            => $success,
                        ], get_staff_user_id(), $data['driver_id']
                    );
                }

                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('logbooks')));
            }else {
                $this->session->setFlashdata("error_message", _l('logbooks_failed'));
            }
        }else{
            if (!has_permission('fleet_work_performance', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_logbook($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('logbooks')));
            }
        }

        app_redirect('fleet/work_performances');
    }

    /**
    * delete logbook
    * @param  integer $id 
    */
    public function delete_logbook($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_logbook($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('logbooks')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('logbooks')));
            }
        }
        app_redirect('fleet/work_performances');
    }

    /**
    * get data logbook
    * @param  integer $id 
    */
    public function get_data_logbook($id){
        $data_garages = $this->Fleet_model->get_logbook($id);
       
        echo json_encode($data_garages);
        die;
    }

    /**
     * view booking detail
     * @return view
     */
    public function logbook_detail($id = ''){

        $data['logbook'] = $this->Fleet_model->get_logbook($id);

        $data['title'] = _l('logbook');
        
        return $this->template->rander('Fleet\Views\work_performances/logbook_detail', $data);
    }

    /**
     * { logbook change status }
     *
     * @param  $order_number  The order number
     * @return json
     */
    public function logbook_status_mark_as($status, $logbook_id){
        $message = '';
        $success = $this->Fleet_model->logbook_change_status($status, $logbook_id);
        if ($success) {
            $message = _l('updated_successfully');
        }               

        echo json_encode([
                    'message' => $message,
                    'success' => $success
                ]);
        die;
    }

    /**
     * tiem card table
     * @return json
     */
    public function time_card_table()
    {
            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_time_cards.driver_id as driver_id',
                db_prefix() . 'fleet_time_cards.start_time as start_time',
                db_prefix() . 'fleet_time_cards.end_time as end_time',
                db_prefix() . 'fleet_time_cards.notes as notes',
            ];

            $where = [];
            $logbook_id = $this->request->getPost("logbook_id");
            if($logbook_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_time_cards.logbook_id ="'.$logbook_id.'"');
            }
          
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_time_cards';
            $join         = [
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['logbook_id', 'id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/driver_detail/' . $aRow['driver_id']) . '">' . get_staff_full_name($aRow['driver_id']) . '</a>';

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_work_performance')) {
                    $categoryOutput .= '<a href="#" onclick="edit_time_card(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_edit_work_performance')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_time_card/' . $aRow['id'].'/'.$aRow['logbook_id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';

                $row[] = $categoryOutput;
                $row[] = _dt($aRow['start_time'], true);
                $row[] = _dt($aRow['end_time'], true);
                $row[] = $aRow['notes'];

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
    * delete time_card
    * @param  integer $id 
    */
    public function delete_time_card($id, $logbook_id = ''){
        if($id != ''){
            $result =  $this->Fleet_model->delete_time_card($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('time_cards')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('time_cards')));
            }
        }
        app_redirect('fleet/logbook_detail/'.$logbook_id);
    }

    /**
     * add time_card
     * @return json
     */
    public function time_card(){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!fleet_has_permission('fleet_can_edit_work_performance')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_time_card($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('time_cards')));
            }else {
                $this->session->setFlashdata("error_message", _l('time_cards_failed'));
            }
        }else{
            if (!fleet_has_permission('fleet_can_edit_work_performance')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_time_card($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('time_cards')));
            }
        }

        app_redirect('fleet/logbook_detail/'.$data['logbook_id']);
    }

    /**
    * get data time_card
    * @param  integer $id 
    */
    public function get_data_time_card($id){
        $data_time_card = $this->Fleet_model->get_time_card($id);
       
        echo json_encode($data_time_card);
        die;
    }

    /**
     * add insurance
     * @return json
     */
    public function insurance(){
        $data = $this->request->getPost();

        $redirect = 'insurances';
        if(isset($data['redirect'])){
            $redirect = $data['redirect'];
            unset($data['redirect']);
        }

        if($data['id'] == ''){
            if (!fleet_has_permission('fleet_can_create_insurance')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_insurance($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurances')));
            }else {
                $this->session->setFlashdata("error_message", _l('insurances_failed'));
            }
        }else{
            if (!fleet_has_permission('fleet_can_edit_insurance')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_insurance($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('insurances')));
            }
        }

        if($redirect == 'vehicle'){
            app_redirect('fleet/vehicle/'.$data['vehicle_id'].'?group=insurances');
        }

        app_redirect('fleet/insurances');
    }

    /**
    * delete insurance
    * @param  integer $id 
    */
    public function delete_insurance($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_insurance($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('insurances')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('insurances')));
            }

        }
        app_redirect('fleet/insurances');
    }


    /**
    * get data insurance
    * @param  integer $id 
    */
    public function get_data_insurance($id){
        $data_insurance = $this->Fleet_model->get_insurance($id);
       
        echo json_encode($data_insurance);
        die;
    }

    /**
     *
     *  add or edit insurance_category
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function insurance_category()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_insurance_category($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurance_category')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_insurance_category($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('insurance_category')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=insurance_categories');
            echo json_encode(['success' => $success, 'message' => $message]);
            die();
        }
    }

    /**
     *
     *  add or edit insurance_type
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function insurance_type()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_insurance_type($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurance_type')));

                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_insurance_type($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('insurance_type')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=insurance_types');
        }
    }

    /**
     * insurance_categories table
     * @return json
     */
    public function insurance_categories_table(){
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_insurance_categories';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_insurance_category(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_insurance_category/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * delete insurance_category
     * @param  integer $id
     * @return
     */
    public function delete_insurance_category($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_insurance_category($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('insurance_category')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=insurance_categories');
    }

    /**
     * get data insurance_category
     * @param  integer $id 
     * @return json     
     */
    public function get_data_insurance_category($id){
        $insurance_category = $this->Fleet_model->get_insurance_category($id);

        echo json_encode($insurance_category);
    }

    /**
     * insurance_types table
     * @return json
     */
    public function insurance_types_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_insurance_types';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_insurance_type(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_insurance_type/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * delete insurance_type
     * @param  integer $id
     * @return
     */
    public function delete_insurance_type($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_insurance_type($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('insurance_type')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=insurance_types');
    }

    /**
     * get data insurance_type
     * @param  integer $id 
     * @return json     
     */
    public function get_data_insurance_type($id){
        $insurance_type = $this->Fleet_model->get_insurance_type($id);

        echo json_encode($insurance_type);
    }

    /**
     * events
     * @return view
     */
    public function events(){
        $this->required_module();
        if (!has_permission('fleet_event', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('events');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();

        return $this->template->rander('Fleet\Views\events/manage', $data);
    }

    /**
     * add event
     * @return json
     */
    public function event(){
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_event', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_event($data);
            if($success){
                $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('events')));
            }else {
                $this->session->setFlashdata("error_message", _l('events_failed'));
            }
        }else{
            if (!has_permission('fleet_event', '', 'edit')) {
                access_denied('fleet');
            }
            $id = $data['id'];
            unset($data['id']);
            $success = $this->Fleet_model->update_event($data, $id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('events')));
            }
        }

        app_redirect('fleet/events');
    }

    /**
     * events table
     * @return json
     */
    public function events_table()
    {

            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_events.id as id',
                db_prefix() . 'fleet_events.subject as subject',
                db_prefix() . 'fleet_events.driver_id as driver_id',
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_events.event_type as event_type',
                db_prefix() . 'fleet_events.event_time as event_time',
            ];

            $where = [];

            $is_report = $this->request->getPost("is_report");
            $event_type = $this->request->getPost("event_type");
            if($event_type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_events.event_type ="'.$event_type.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (event_time >= "' . $from_date . '" and event_time <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (event_time >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (event_time <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_events';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_events.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_events.description as description', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = $aRow['subject'];

                if($is_report == ''){
                    $categoryOutput .= '<div class="row-options">';

                    if (fleet_has_permission('fleet_can_edit_event')) {
                        $categoryOutput .= '<a href="#" onclick="edit_event(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                    }

                    if (fleet_has_permission('fleet_can_delete_event')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_event/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                $row[] = get_staff_full_name($aRow['driver_id']);
                $row[] = _dt($aRow['event_time']);
                $row[] = _l($aRow['event_type']);
                $row[] = $aRow['description'];

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
    * get data event
    * @param  integer $id 
    */
    public function get_data_event($id){
        $data_event = $this->Fleet_model->get_event($id);
       
        echo json_encode($data_event);
        die;
    }

    /**
    * delete event
    * @param  integer $id 
    */
    public function delete_event($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_event($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('event')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('event')));
            }
        }
        app_redirect('fleet/events');
    }

    /**
     * work_orders
     * @return view
     */
    public function work_orders(){
        $this->required_module();
        if (!has_permission('fleet_work_orders', '', 'view')) {
            access_denied('fleet');
        }

        $data['title']         = _l('work_orders');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();

        return $this->template->rander('Fleet\Views\work_orders/manage', $data);
    }

    /**
     * work_orders table
     * @return json
     */
    public function work_orders_table()
    {

            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_work_orders.id as id',
                db_prefix() . 'fleet_work_orders.number as number',
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_work_orders.vendor_id as vendor_id',
                db_prefix() . 'fleet_work_orders.issue_date as issue_date',
                db_prefix() . 'fleet_work_orders.start_date as start_date',
                db_prefix() . 'fleet_work_orders.complete_date as complete_date',
                db_prefix() . 'fleet_work_orders.total as total',
            ];

            $where = [];

                $is_report = $this->request->getPost("is_report");
            $status = $this->request->getPost("status");
            if($status != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_work_orders.status ="'.$status.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (issue_date >= "' . $from_date . '" and issue_date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (issue_date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (issue_date <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_work_orders';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_work_orders.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_work_orders.status as status', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/work_order_detail/' . $aRow['id']) . '">'. $aRow['number']. '</a>';

                if($is_report == ''){
                    $categoryOutput .= '<div class="row-options">';

                    $categoryOutput .= '<a href="' . admin_url('fleet/work_order_detail/' . $aRow['id']) . '">' . _l('view') . '</a>';

                    if (fleet_has_permission('fleet_can_edit_work_orders')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/work_order/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                    }

                    if (fleet_has_permission('fleet_can_delete_work_orders')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_work_order/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                $row[] = get_vendor_company_name($aRow['vendor_id']);
                $row[] = _d($aRow['issue_date']);
                $row[] = _d($aRow['start_date']);
                $row[] = _d($aRow['complete_date']);
                $row[] = to_currency($aRow['total'], $currency);
                $row[] = fleet_render_status_html($aRow['id'], 'work_order', $aRow['status'], false);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
    * get data work_order
    * @param  integer $id 
    */
    public function get_data_work_order($id){
        $data_work_order = $this->Fleet_model->get_work_order($id);
       
        echo json_encode($data_work_order);
        die;
    }

    /**
    * delete work_order
    * @param  integer $id 
    */
    public function delete_work_order($id){
        if($id != ''){
            $result =  $this->Fleet_model->delete_work_order($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('work_order')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('work_order')));
            }
        }
        app_redirect('fleet/work_orders');
    }
        
    /**
     * add or update work_order
     * @return view
     */
    public function work_order($id = ''){
        if ($this->request->getPost()) {
            $data                = $this->request->getPost();

            if($id == ''){
                if (!has_permission('fleet_work_orders', '', 'create')) {
                    access_denied('fleet_work_orders');
                }
                $success = $this->Fleet_model->add_work_order($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('work_order')));
                }

                app_redirect('fleet/work_order_detail/' . $success);
            }else{
                if (!has_permission('fleet_work_orders', '', 'edit')) {
                    access_denied('fleet_work_orders');
                }
                $success = $this->Fleet_model->update_work_order($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('work_order')));
                }

                app_redirect('fleet/work_order_detail/' . $id);
            }
        }

        if($id != ''){
            $data['work_order'] = $this->Fleet_model->get_work_order($id);
        }

        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['title'] = _l('work_order');
        $data['vendors'] = $this->Fleet_model->get_vendor();
        $data['parts'] = $this->Fleet_model->get_part();

        return $this->template->rander('Fleet\Views\work_orders/work_order', $data);
    }

    /**
     * maintenance detail
     * @param  integer $maintenance_id 
     * @return view               
     */
    public function maintenance_detail($maintenance_id) {

        $data['maintenance'] = $this->Fleet_model->get_maintenances($maintenance_id);

        $data['currency'] = get_setting('default_currency');

        return $this->template->rander('Fleet\Views\maintenances/maintenance_detail', $data);

    }

    /**
     * view work order detail
     * @return view
     */
    public function work_order_detail($id = ''){

        $data['work_order'] = $this->Fleet_model->get_work_order($id);
        $data['currency'] = get_setting('default_currency');

        $data['title'] = _l('work_order');
        
        return $this->template->rander('Fleet\Views\work_orders/work_order_detail', $data);
    }

    /**
     * { work_order change status }
     *
     * @param  $order_number  The order number
     * @return json
     */
    public function work_order_status_mark_as($status, $work_order_id){
        $message = '';
        $success = $this->Fleet_model->work_order_change_status($status, $work_order_id);
        if ($success) {
            $message = _l('updated_successfully');
        }               

        echo json_encode([
                    'message' => $message,
                    'success' => $success
                ]);
        die;
    }

    /**
     * create expense by work_order
     * @param  integer $id the work_order id
     * @return json
     */
    public function create_expense_by_work_order($id)
    {
        if (!has_permission('fleet_work_orders', '', 'create')) {
            access_denied('fleet_work_orders');
        }

        $expense_id = $this->Fleet_model->create_expense_by_work_order($id);
        $message    = $expense_id ? _l('create_expense_successfully') : '';


        echo json_encode([
            'message'        => $message,
        ]);
        die();
    }

    /**
     * transactions
     * @return view
     */
    public function transactions()
    {
        $this->required_module();

        if (!has_permission('fleet_transaction', '', 'view')) {
            access_denied('setting');
        }
        
        $data          = [];
        $data['group'] = $this->request->getGet('group');

        $data['tab'][] = 'invoices';
        $data['tab'][] = 'expenses';
        
        $data['tab_2'] = $this->request->getGet('tab');
        if ($data['group'] == '') {
            $data['group'] = 'invoices';
        }


        $data['title']        = _l($data['group']);
        $data['tabs']['view'] = 'transactions/' . $data['group'];
        return $this->template->rander('Fleet\Views\transactions/manage', $data);
    }

    /**
     * invoices table
     * @return json
     */
    public function invoices_table()
    {

            $invoice_value_calculation_query = $this->Fleet_model->acc_get_invoice_value_calculation_query();
            $currency = get_setting('default_currency');
            $acc_closing_date = '';
            if(get_setting('acc_close_the_books') == 1){
                $acc_closing_date = get_setting('acc_closing_date');
            }
            $select = [
                db_prefix() . 'invoices.id as id',
                'client_id',
                'company_name',
                db_prefix() .'invoices.bill_date as date',
                db_prefix() .'invoices.status as status',
            ];
            $where = [];
            array_push($where, 'AND from_fleet = 1');
            
            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'invoices.bill_date >= "' . $from_date . '" and ' . db_prefix() . 'invoices.bill_date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'invoices.bill_date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'invoices.bill_date <= "' . $to_date . '")');
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'invoices';
            $join         = [
                'LEFT JOIN ' . get_db_prefix() . 'clients ON ' . get_db_prefix() . 'clients.id = ' . get_db_prefix() . 'invoices.client_id',
                            'LEFT JOIN (SELECT '.get_db_prefix().'taxes.* FROM '.get_db_prefix().'taxes) AS tax_table ON tax_table.id = '. get_db_prefix() . 'invoices.tax_id',
                            'LEFT JOIN (SELECT '.get_db_prefix().'taxes.* FROM '.get_db_prefix().'taxes) AS tax_table2 ON tax_table2.id = '. get_db_prefix() . 'invoices.tax_id2',
                            'LEFT JOIN (SELECT '.get_db_prefix().'taxes.* FROM '.get_db_prefix().'taxes) AS tax_table3 ON tax_table3.id = '. get_db_prefix() . 'invoices.tax_id3',
                        'LEFT JOIN (SELECT invoice_id, SUM(total) AS invoice_value FROM '.get_db_prefix().'invoice_items WHERE deleted=0 GROUP BY invoice_id) AS items_table ON items_table.invoice_id = '. get_db_prefix() . 'invoices.id'
                        ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [$invoice_value_calculation_query . ' as invoice_value', 'currency_symbol']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $categoryOutput = '<a href="' . admin_url('invoices/view/' . $aRow['id']) . '" target="_blank">' . get_invoice_id($aRow['id']) . '</a>';

                $row[] = $categoryOutput;

                $row[] = _d($aRow['date']);
                $row[] = to_currency($aRow['invoice_value'], $aRow['currency_symbol']);

                $row[] = anchor(get_uri("clients/view/" . $aRow['client_id']), $aRow['company_name']);
                $row[] = $this->_get_invoice_status_label($aRow['id']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    function _get_invoice_status_label($invoice_id, $return_html = true) {
        $invoice_status_class = "bg-secondary";
        $status = "not_paid";
        $now = get_my_local_time("Y-m-d");

        $invoice_info = $this->Invoices_model->get_details(['id' => $invoice_id])->getRow();
        
        //ignore the hidden value. check only 2 decimal place.
        $invoice_info->invoice_value = floor($invoice_info->invoice_value * 100) / 100;

        if ($invoice_info->status == "cancelled") {
            $invoice_status_class = "bg-danger";
            $status = "cancelled";
        } else if ($invoice_info->status != "draft" && $invoice_info->due_date < $now && $invoice_info->payment_received < $invoice_info->invoice_value) {
            $invoice_status_class = "bg-danger";
            $status = "overdue";
        } else if ($invoice_info->status !== "draft" && $invoice_info->payment_received <= 0) {
            $invoice_status_class = "bg-warning";
            $status = "not_paid";
        } else if ($invoice_info->payment_received * 1 && $invoice_info->payment_received >= $invoice_info->invoice_value) {
            $invoice_status_class = "bg-success";
            $status = "fully_paid";
        } else if ($invoice_info->payment_received > 0 && $invoice_info->payment_received < $invoice_info->invoice_value) {
            $invoice_status_class = "bg-primary";
            $status = "partially_paid";
        } else if ($invoice_info->status === "draft") {
            $invoice_status_class = "bg-secondary";
            $status = "draft";
        }

        $invoice_status = "<span class='mt0 badge $invoice_status_class large'>" . app_lang($status) . "</span>";
        if ($return_html) {
            return $invoice_status;
        } else {
            return $status;
        }
    }

    /**
     * expenses table
     * @return json
     */
    public function expenses_table()
    {

            $currency = get_setting('default_currency');
            $currency_symbol = get_setting("currency_symbol");
           
            $select = [
                db_prefix() . 'expenses.id as id',
                db_prefix() . 'expense_categories.title as category_name',
                db_prefix() . 'expenses.title as expense_name',
                db_prefix() . 'expenses.expense_date as date',
            ];
            $where = [];
            array_push($where, 'AND from_fleet = 1');

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'expenses.expense_date >= "' . $from_date . '" and ' . db_prefix() . 'expenses.expense_date <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'expenses.expense_date >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (' . db_prefix() . 'expenses.expense_date <= "' . $to_date . '")');
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'expenses';
            $join         = [
                'JOIN ' . get_db_prefix() . 'expense_categories ON ' . get_db_prefix() . 'expense_categories.id = ' . get_db_prefix() . 'expenses.category_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['amount']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('expenses#' . $aRow['id']) . '" target="_blank">' . $aRow['expense_name'] . '</a>';
               
                $row[] = $categoryOutput;
                $row[] = _d($aRow['date']);

                $row[] = to_currency($aRow['amount'], $currency_symbol);

                $row[] = $aRow['category_name'];

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
    * delete driver_document
    * @param  integer $id 
    */
    public function delete_driver_document($id, $rel_id = '', $rel_type = 'driver'){
        if($id != ''){
            $result =  $this->Fleet_model->delete_driver_document($id);
            if($result){
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('driver_document')));
            }
            else{
                $this->session->setFlashdata("error_message", sprintf(_l('deleted_fail'), _l('driver_document')));
            }
        }
        if($rel_type == 'driver'){
            app_redirect('fleet/driver_detail/'.$rel_id.'?group=driver_documents');
        }else{
            app_redirect('fleet/vehicle/'.$rel_id.'?group=vehicle_document');
        }

        app_redirect('fleet/drivers');
    }

    /**
     * view driver_documents
     * @return view
     */
    public function view_driver_documents($id = ''){

        $data['driver_document'] = $this->Fleet_model->get_driver_document($id);

        $data['title'] = _l('driver_document');
        
        return $this->template->rander('Fleet\Views\driver_documents/driver_document_detail', $data);
    }

    /**
     * { delete bill attachment }
     *
     * @param      <type>  $id       The identifier
     * @param      string  $preview  The preview
     */
    public function delete_driver_document_attachment($id, $document_id, $preview = '')
    {
        $db = db_connect('default');
        $db_builder = $db->table(get_db_prefix() . 'files');
        $db_builder->where('id', $id);
        $file = $db_builder->get()->getRow();

        if ($file->staffid == get_staff_user_id() || is_admin()) {
            $success = $this->Fleet_model->delete_driver_document_attachment($file, $document_id);
            if ($success) {
                $this->session->setFlashdata("success_message", sprintf(_l('deleted_successfully'), _l('driver_document')));
            } else {
                $this->session->setFlashdata("error_message", sprintf(_l('problem_deleting'), _l('driver_document')));
            }

            if ($preview == '') {
                app_redirect('fleet/driver_document/' . $document_id);
            } else {
                app_redirect('fleet/view_driver_documents/' . $document_id);
            }
        } else {
            access_denied('fleet');
        }
    }

    /**
     * Dashboard
     * @return view
     */
    public function dashboard(){
    
        $data['title'] = _l('dashboard');
        $data['driver_role_id'] = $this->Fleet_model->get_fleet_driver_role_id();
        $data['currency_symbol'] = get_setting('currency_symbol');
        $data['fuel_consumption_ranking'] = $this->Fleet_model->fuel_consumption_ranking();
        $data['calculating_driver_point'] = $this->Fleet_model->driver_ranking();
        
        return $this->template->rander('Fleet\Views\dashboard/manage', $data);
    }

    /**
     * get data dashboard
     * @return json
     */
    public function get_data_dashboard(){
        $data_filter = $this->request->getGet();

        $data['profit_and_loss_chart'] = $this->Fleet_model->get_data_profit_and_loss_chart($data_filter);
        $data['sales_chart'] = $this->Fleet_model->get_data_sales_chart($data_filter);

        echo json_encode($data);
        die;
    }

    /**
     * Reports
     * @return 
     */
    public function reports(){
        $this->required_module();
        $data['title'] = _l('reports');
        
        return $this->template->rander('Fleet\Views\reports/manage', $data);
    }
    
    /**
     * report fuel
     * @return view
     */
    public function fuel_report(){
        $data['title'] = _l('fuel_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/fuel_report', $data);
    }

    /**
     * Gets the data fuel chart.
     * @return json data chart
     */
    public function get_data_fuel_chart() {
        $data_fuel = $this->Fleet_model->get_data_fuel_chart();

        echo json_encode([
            'data_fuel' => $data_fuel,
        ]);
        die();
    }

    /**
     * report maintenance
     * @return view
     */
    public function maintenance_report(){
        $data['title'] = _l('maintenance_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/maintenance_report', $data);
    }

    /**
     * Gets the data maintenance chart.
     * @return json data chart
     */
    public function get_data_maintenance_chart() {
        $data_maintenance = $this->Fleet_model->get_data_maintenance_chart();

        echo json_encode([
            'data_maintenance' => $data_maintenance,
        ]);
        die();
    }

    /**
     * report event
     * @return view
     */
    public function event_report(){
        $data['title'] = _l('event_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/event_report', $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_event_chart() {
        $data_event = $this->Fleet_model->get_data_event_chart();
        $data_event_stats = $this->Fleet_model->event_stats();


        echo json_encode([
            'data_event' => $data_event,
            'data_event_stats' => $data_event_stats,
        ]);
        die();
    }

    /**
     * report work_order
     * @return view
     */
    public function work_order_report(){
        $data['title'] = _l('work_order_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/work_order_report', $data);
    }

    /**
     * Gets the data work_order chart.
     * @return json data chart
     */
    public function get_data_work_order_chart() {
        $data_work_order = $this->Fleet_model->get_data_work_order_chart();
        $data_work_order_stats = $this->Fleet_model->work_order_stats();


        echo json_encode([
            'data_work_order' => $data_work_order,
            'data_work_order_stats' => $data_work_order_stats,
        ]);
        die();
    }

    /**
     * report income_and_expense
     * @return view
     */
    public function income_and_expense_report(){
        $data['title'] = _l('income_and_expense_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/income_and_expense_report', $data);
    }

    /**
     * Gets the data income_and_expense chart.
     * @return json data chart
     */
    public function get_data_income_and_expense_chart() {
        $data = [];
        $data['profit_and_loss_chart'] = $this->Fleet_model->get_data_profit_and_loss_chart();
        $data['sales_chart'] = $this->Fleet_model->get_data_sales_chart();

        echo json_encode($data);
        die();
    }

    /**
     * report work_performance
     * @return view
     */
    public function work_performance_report(){
        $data['title'] = _l('work_performance_report');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/work_performance_report', $data);
    }

    /**
     * Gets the data work_performance chart.
     * @return json data chart
     */
    public function get_data_work_performance_chart() {
        $data_work_performance = $this->Fleet_model->get_data_work_performance_chart();
        $data_work_performance_stats = $this->Fleet_model->work_performance_stats();


        echo json_encode([
            'data_work_performance' => $data_work_performance,
            'data_work_performance_stats' => $data_work_performance_stats,
        ]);
        die();
    }

    /**
     * [get_data_work_performance_chart description]
     * @return [type] [description]
     */
    public function required_module() {
        $data = [];

        $data['required'] = [];

        if(!fleet_get_status_modules('Hr_profile')){
            $data['required'][] = _l('hr_profile');
        }

        if(!fleet_get_status_modules('Purchase')){
            $data['required'][] = _l('purchase');
        }

        if(count($data['required']) > 0){
            app_redirect('fleet/required_module_detail');
        }
    }

    public function required_module_detail() {
        $data = [];

        $data['required'] = [];

        $data['required']['hr_profile'] = 0;
        $data['required']['purchase'] = 0;

        if(fleet_get_status_modules('Hr_profile')){
            $data['required']['hr_profile'] = 1;
        }

        if(fleet_get_status_modules('Purchase')){
            $data['required']['purchase'] = 1;
        }

        return $this->template->rander('Fleet\Views/required_module', $data);
    }


    /* Edit legal document or add new legal document */
    public function vehicle_document($id = '')
    {
        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $data['type'] = 'vehicle';
            if ($id == '') {

                if (!has_permission('contracts', '', 'create')) {
                    access_denied('contracts');
                }
                $id = $this->Fleet_model->add_driver_document($data);
                if ($id) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('document')));

                    echo json_encode([
                        'url'       => admin_url('fleet/vehicle_document/' . $data['vehicle_id']),
                        'id' => $id,
                        'vehicle_id' => $data['vehicle_id'],
                    ]);
                    die;
                }
            } else {
                if (!has_permission('contracts', '', 'edit')) {
                    access_denied('contracts');
                }
                $success = $this->Fleet_model->update_driver_document($data, $id);

                echo json_encode([
                    'url'       => admin_url('fleet/vehicle/' . $data['vehicle_id'].'?group=vehicle_document'),
                    'id' => $id,
                    'vehicle_id' => $data['vehicle_id'],
                ]);
                die;
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('vehicle_document'));
        } else {
            $data['vehicle_document']                 = $this->Fleet_model->get_driver_document($id, [], true);

            $title = $data['vehicle_document']->subject;
            $data['vehicle_id'] = $data['vehicle_document']->vehicle_id;

        }

        if ($this->request->getGet('vehicle_id')) {
            $data['vehicle_id'] = $this->request->getGet('vehicle_id');
        }

        $data['title']         = $title;
        return $this->template->rander('Fleet\Views\vehicle_documents/vehicle_document', $data);
    }

    /**
     * get mark staff
     * @param  integer $id_staff
     * @return array
     */
    public function get_mark_staff($id_staff, $training_process_id) {
        $array_training_point = [];
        $training_program_point = 0;

        //Get the latest employee's training result.
        $Hr_profile_model = model('Hr_profile\Models\Hr_profile_model');
        $trainig_resultset = $Hr_profile_model->get_resultset_training($id_staff, $training_process_id);

        $array_training_resultset = [];
        $array_resultsetid = [];
        $list_resultset_id = '';

        foreach ($trainig_resultset as $item) {
            if (count($array_training_resultset) == 0) {
                array_push($array_training_resultset, $item['trainingid']);
                array_push($array_resultsetid, $item['resultsetid']);

                $list_resultset_id .= '' . $item['resultsetid'] . ',';
            }
            if (!in_array($item['trainingid'], $array_training_resultset)) {
                array_push($array_training_resultset, $item['trainingid']);
                array_push($array_resultsetid, $item['resultsetid']);

                $list_resultset_id .= '' . $item['resultsetid'] . ',';
            }
        }

        $list_resultset_id = rtrim($list_resultset_id, ",");
        $count_out = 0;
        if ($list_resultset_id == "") {
            $list_resultset_id = '0';
        } else {
            $count_out = count($array_training_resultset);
        }

        $array_result = [];
        foreach ($array_training_resultset as $key => $training_id) {
            $total_question = 0;
            $total_question_point = 0;

            $total_point = 0;
            $training_library_name = '';
            $training_question_forms = $Hr_profile_model->hr_get_training_question_form_by_relid($training_id);
            $hr_position_training = $Hr_profile_model->get_board_mark_form($training_id);
            $total_question = count($training_question_forms);
            if ($hr_position_training) {
                $training_library_name .= $hr_position_training->subject;
            }

            foreach ($training_question_forms as $question) {
                $flag_check_correct = true;

                $get_id_correct = $Hr_profile_model->get_id_result_correct($question['questionid']);
                $form_results = $Hr_profile_model->hr_get_form_results_by_resultsetid($array_resultsetid[$key], $question['questionid']);

                if (count($get_id_correct) == count($form_results)) {
                    foreach ($get_id_correct as $correct_key => $correct_value) {
                        if (!in_array($correct_value, $form_results)) {
                            $flag_check_correct = false;
                        }
                    }
                } else {
                    $flag_check_correct = false;
                }

                $result_point = $Hr_profile_model->get_point_training_question_form($question['questionid']);
                $total_question_point += $result_point->point;

                if ($flag_check_correct == true) {
                    $total_point += $result_point->point;
                    $training_program_point += $result_point->point;
                }

            }

            array_push($array_training_point, [
                'training_name' => $training_library_name,
                'total_point' => $total_point,
                'training_id' => $training_id,
                'total_question' => $total_question,
                'total_question_point' => $total_question_point,
            ]);
        }

        $response = [];
        $response['training_program_point'] = $training_program_point;
        $response['staff_training_result'] = $array_training_point;

        return $response;
    }

    public function download_file($folder_indicator, $attachmentid = '')
    {   

        $path = '';
        if ($folder_indicator == 'fle_driver_document') {
            $db = db_connect('default');
            $db_builder = $db->table(get_db_prefix() . 'files');
            $db_builder->where('id', $attachmentid);
            $file = $db_builder->get()->getRow();
            $path = FLEET_MODULE_UPLOAD_FOLDER . '/driver_documents/' . $file->rel_id.'/';
        }else {
            die('folder not specified');
        }

        return $this->download_app_files($path, serialize(array(array("file_name" => $file->file_name))));
    }

    

    /**
     * [get_calendar_data description]
     * @return [type] [description]
     */
    public function get_calendar_data()
    {
        echo json_encode($this->Fleet_model->get_calendar_data(
                date('Y-m-d', strtotime($this->request->getGet('start'))),
                date('Y-m-d', strtotime($this->request->getGet('end'))),
                '',
                '',
                $this->request->getGet()
            ));
        die();
    }

    /* Edit part or add new part*/
    public function part($id = '')
    {
        if (!has_permission('fleet_part', '', 'view')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            if ($id == '') {
                if (!has_permission('fleet_part', '', 'create')) {
                    access_denied('fleet');
                }

                $data = $this->request->getPost();

                $id = $this->Fleet_model->add_part($data);
                if ($id) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('part')));
                    app_redirect('fleet/part/' . $id);
                }
            } else {
                if (!has_permission('fleet_part', '', 'edit')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->update_part($this->request->getPost(), $id);
                if ($success == true) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('part')));
                }
                app_redirect('fleet/part/' . $id);
            }
        }

        $group         = !$this->request->getGet('group') ? 'details' : $this->request->getGet('group');
        $data['group'] = $group;

        if ($id == '') {
            $title = _l('add_new', _l('part'));
        } else {
            $part                = $this->Fleet_model->get_part($id);
            $data['part_tabs'] = [];
            $data['part_tabs']['details'] = ['name' => 'details', 'icon' => '<i class="fa fa-user-circle menu-icon"></i>'];
            $data['part_tabs']['assignment_history'] = ['name' => 'assignment_history', 'icon' => '<i class="fa fa-history menu-icon"></i>'];
            $data['part_tabs']['linked_vehicle_history'] = ['name' => 'linked_vehicle_history', 'icon' => '<i class="fa fa-link menu-icon"></i>'];

            if (!$part) {
                show_404();
            }

            $data['tab']      = isset($data['part_tabs'][$group]) ? $data['part_tabs'][$group] : null;
            $data['tab']['view'] = 'parts/groups/'.$data['group'];

            if (!$data['tab']) {
                show_404();
            }

            // Fetch data based on groups
            if ($group == 'details') {
               
            } 

            $data['part'] = $part;
            $title          = $part->name;

            if (!empty($data['client']->company)) {
                // Check if is realy empty client company so we can set this field to empty
                // The query where fetch the client auto populate firstname and lastname if company is empty
                if (is_empty_customer_company($data['client']->userid)) {
                    $data['client']->company = '';
                }
            }
        }

        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['drivers'] = $this->Fleet_model->get_driver();
        $data['vendors'] = $this->Fleet_model->get_vendor();
        $data['part_types'] = $this->Fleet_model->get_data_part_types();
        $data['part_groups'] = $this->Fleet_model->get_data_part_groups();
        $data['bodyclass'] = 'customer-profile dynamic-create-groups';
        $data['title']     = $title;

        return $this->template->rander('Fleet\Views\parts/part', $data);
    }

    /**
     * part groups table
     * @return json
     */
    public function part_groups_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_part_groups';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_part_group(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_part_group/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit part group
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function part_group()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_part_group($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('part_group')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_part_group($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('part_group')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=part_groups');
        }
    }

    /**
     * delete part group
     * @param  integer $id
     * @return
     */
    public function delete_part_group($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_part_group($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('part_group')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=part_groups');
    }

    /**
     * get data part group
     * @param  integer $id 
     * @return json     
     */
    public function get_data_part_group($id){
        $part_group = $this->Fleet_model->get_data_part_groups($id);

        echo json_encode($part_group);
    }

    /**
     * part types table
     * @return json
     */
    public function part_types_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_part_types';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_part_type(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_part_type/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit part type
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function part_type()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_part_type($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('part_type')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_part_type($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('part_type')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=part_types');
        }
    }

    /**
     * delete part type
     * @param  integer $id
     * @return
     */
    public function delete_part_type($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_part_type($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('part_type')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=part_types');
    }

    /**
     * get data part type
     * @param  integer $id 
     * @return json     
     */
    public function get_data_part_type($id){
        $part_type = $this->Fleet_model->get_data_part_types($id);

        echo json_encode($part_type);
    }

    /**
     * part histories table
     * @return json
     */
    public function part_histories_table(){
           
            $select = [
                'driver_id',
                'start_time',
                'end_time',
                'start_by',
                'end_by',
            ];

            $where = [];
            $rel_id = '';
            $rel_type = '';

            $part_id = $this->request->getPost("id");
            if($part_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_part_histories.part_id ="'.$part_id.'"');
                $rel_id = $part_id;
                $rel_type = 'part';
            }

            $driverid = $this->request->getPost("driverid");
            if($driverid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_part_histories.driver_id ="'.$driverid.'"');
                $rel_id = $driverid;
                $rel_type = 'driver';
            }

            $type = $this->request->getPost("type");
            if($type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_part_histories.type ="'.$type.'"');
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_part_histories';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_part_histories.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_part_histories.id as id', db_prefix() . 'fleet_vehicles.name as vehicle_name', 'type', 'vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                if($aRow['type'] == 'assignee'){
                    $row[] = '<a href="' . admin_url('fleet/driver_detail/' . $aRow['driver_id']) . '">' . get_staff_full_name($aRow['driver_id']) . '</a>';
                }elseif($aRow['type'] == 'linked_vehicle'){
                    $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                }
                $row[] = _d($aRow['start_time']);
                $row[] = _d($aRow['end_time']);
                $row[] = get_staff_full_name($aRow['start_by']);
                $row[] = $aRow['end_by'] != '' ? get_staff_full_name($aRow['end_by']) : '';

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * parts table
     * @return json
     */
    public function parts_table()
    {

            $currency = get_setting('default_currency');
            $select = [
                db_prefix() . 'fleet_parts.name as name',
                db_prefix() . 'fleet_parts.brand as brand',
                db_prefix() . 'fleet_parts.model as model',
                db_prefix() . 'fleet_parts.serial_number as serial_number',
                db_prefix() . 'fleet_parts.status as status',
                db_prefix() . 'fleet_part_groups.name as group_name',
                db_prefix() . 'fleet_part_types.name as type_name',
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'fleet_parts.driver_id as driver_id',
            ];

            $where = [];

            $vehicleid = $this->request->getPost("vehicleid");
            if($vehicleid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_parts.vehicle_id ="'.$vehicleid.'"');
            }

            $driverid = $this->request->getPost("driverid");
            if($driverid != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_parts.driver_id ="'.$driverid.'"');
            }

            $status = $this->request->getPost("status");
            if($status != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_parts.status ="'.$status.'"');
            }

            $type = $this->request->getPost("type");
            if($type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_parts.part_type_id ="'.$type.'"');
            }

            $group = $this->request->getPost("group");
            if($group != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_parts.part_group_id ="'.$group.'"');
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_parts';
            $join         = [
            'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_parts.vehicle_id',
            'LEFT JOIN ' . db_prefix() . 'fleet_part_types ON ' . db_prefix() . 'fleet_part_types.id = ' . db_prefix() . 'fleet_parts.part_type_id',
            'LEFT JOIN ' . db_prefix() . 'fleet_part_groups ON ' . db_prefix() . 'fleet_part_groups.id = ' . db_prefix() . 'fleet_parts.part_group_id'
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'fleet_parts.id as id', db_prefix() . 'fleet_parts.vehicle_id as vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="'.admin_url('fleet/part/'.$aRow['id'].'').'">' . $aRow['name'] . '</a>';

                if($vehicleid == ''){
                    $categoryOutput .= '<div class="row-options">';

                    $categoryOutput .= '<a href="'.admin_url('fleet/part/'.$aRow['id'].'').'">' . _l('view') . '</a>';

                    if (fleet_has_permission('fleet_can_delete_part')) {
                        $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_part/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                    $categoryOutput .= '</div>';
                }
                $row[] = $categoryOutput;

                $row[] = $aRow['type_name'];
                $row[] = $aRow['brand'];
                $row[] = $aRow['model'];
                $row[] = $aRow['serial_number'];
                $row[] = $aRow['group_name'];
                $row[] = _l($aRow['status']);
                $row[] = '<a href="'.admin_url('fleet/driver_detail/'.$aRow['driver_id'].'').'">' . get_staff_full_name($aRow['driver_id']) . '</a>';
                $row[] = '<a href="'.admin_url('fleet/vehicle/'.$aRow['vehicle_id'].'').'">' . $aRow['vehicle_name'] . '</a>';

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * delete part
     * @param  integer $id
     * @return
     */
    public function delete_part($id)
    {
        if (!has_permission('fleet_part', '', 'delete')) {
            access_denied('fleet_part');
        }
        $success = $this->Fleet_model->delete_part($id);
        $message = '';
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('part')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/parts');
    }

    /**
     * insurance company table
     * @return json
     */
    public function insurance_company_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_insurance_company';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_insurance_company(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_insurance_company/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit insurance company
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function insurance_company()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_insurance_company($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurance_company')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_insurance_company($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('insurance_company')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=insurance_company');
        }
    }

    /**
     * delete insurance company
     * @param  integer $id
     * @return
     */
    public function delete_insurance_company($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_insurance_company($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('insurance_company')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=insurance_company');
    }

    /**
     * get data insurance company
     * @param  integer $id 
     * @return json     
     */
    public function get_data_insurance_company($id){
        $insurance_company = $this->Fleet_model->get_data_insurance_company($id);

        echo json_encode($insurance_company);
    }

    /**
     * insurance status table
     * @return json
     */
    public function insurance_status_table(){
           
            $select = [
                'id',
                'name',
                'addedfrom',
                'datecreated',
            ];

            $where = [];
            $from_date = '';
            $to_date   = '';

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_insurance_status';
            $join         = [];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = $aRow['id'];

                $categoryOutput = $aRow['name'];

                $categoryOutput .= '<div class="row-options">';

                if (fleet_has_permission('fleet_can_edit_setting')) {
                    $categoryOutput .= '<a href="#" onclick="edit_insurance_status(' . $aRow['id'] . '); return false;">' . _l('edit') . '</a>';
                }

                if (fleet_has_permission('fleet_can_delete_setting')) {
                    $categoryOutput .= ' | <a href="' . admin_url('fleet/delete_insurance_status/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                }

                $categoryOutput .= '</div>';
                $row[] = $categoryOutput;
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _d($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     *
     *  add or edit insurance status
     *  @param  integer  $id     The identifier
     *  @return view
     */
    public function insurance_status()
    {
        if (!fleet_has_permission('fleet_can_edit_setting') && !fleet_has_permission('fleet_can_create_setting')) {
            access_denied('fleet');
        }

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $message = '';
            if ($data['id'] == '') {
                if (!fleet_has_permission('fleet_can_create_setting')) {
                    access_denied('fleet');
                }
                $success = $this->Fleet_model->add_insurance_status($data);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('added_successfully'), _l('insurance_status')));
                }else {
                    $this->session->setFlashdata("error_message", _l('add_failure'));
                }
            } else {
                if (!fleet_has_permission('fleet_can_edit_setting')) {
                    access_denied('fleet');
                }
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Fleet_model->update_insurance_status($data, $id);
                if ($success) {
                    $this->session->setFlashdata("success_message", sprintf(_l('updated_successfully'), _l('insurance_status')));
                }else {
                    $this->session->setFlashdata("error_message", _l('updated_fail'));
                }
            }

            app_redirect('fleet/settings?group=insurance_status');
        }
    }

    /**
     * delete insurance status
     * @param  integer $id
     * @return
     */
    public function delete_insurance_status($id)
    {
        if (!fleet_has_permission('fleet_can_delete_setting')) {
            access_denied('fleet_setting');
        }
        $success = $this->Fleet_model->delete_insurance_status($id);
        $message = '';
        
        if ($success) {
            $this->session->setFlashdata("success_message", sprintf(_l('deleted'), _l('insurance_status')));
        } else {
            $this->session->setFlashdata("error_message", _l('can_not_delete'));
        }
        app_redirect('fleet/settings?group=insurance_status');
    }

    /**
     * get data insurance status
     * @param  integer $id 
     * @return json     
     */
    public function get_data_insurance_status($id){
        $insurance_status = $this->Fleet_model->get_data_insurance_status($id);

        echo json_encode($insurance_status);
    }

    /**
     * report fuel
     * @return view
     */
    public function rp_operating_cost_summary(){
        $data['title'] = _l('operating_cost_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['operating_cost_summary'] = $this->Fleet_model->vehicle_operating_cost_summary();
        $data['vehicles'] = $this->Fleet_model->get_vehicle();

        $data['currency'] = get_setting('default_currency');

        return $this->template->rander('Fleet\Views\reports/includes/operating_cost_summary', $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_operating_cost_chart() {
        $data_operating_cost = $this->Fleet_model->get_data_operating_cost_chart();
        $data_operating_cost_stats = $this->Fleet_model->operating_cost_stats();


        echo json_encode([
            'data_operating_cost' => $data_operating_cost,
            'data_operating_cost_stats' => $data_operating_cost_stats,
        ]);
        die();
    }

    /**
     * report fuel
     * @return view
     */
    public function rp_total_cost_trend(){
        $data['title'] = _l('total_cost_trend');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        
        $data['currency'] = get_setting('default_currency');

        return $this->template->rander('Fleet\Views\reports/includes/total_cost_trend', $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_total_cost_trend_chart() {
        $data_total_cost_trend = $this->Fleet_model->get_data_total_cost_trend_chart();


        echo json_encode([
            'data_total_cost_trend' => $data_total_cost_trend,
        ]);
        die();
    }

    /**
     * report expense summary
     * @return view
     */
    public function rp_expense_summary(){
        $data['title'] = _l('expense_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        
        $data['currency'] = get_setting('default_currency');
        $data['vehicle_groups'] = $this->Fleet_model->get_data_vehicle_groups();

        return $this->template->rander('Fleet\Views\reports/includes/expense_summary', $data);
    }

    /**
     * report expenses_by_vehicle
     * @return view
     */
    public function rp_expenses_by_vehicle(){
        $data['title'] = _l('expenses_by_vehicle');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        
        $data['currency'] = get_setting('default_currency');

        return $this->template->rander('Fleet\Views\reports/includes/expenses_by_vehicle', $data);
    }

    /**
     * report status_changes
     * @return view
     */
    public function rp_status_changes(){
        $data['title'] = _l('status_changes');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/status_changes', $data);
    }

    /**
     * report group_changes
     * @return view
     */
    public function rp_group_changes(){
        $data['title'] = _l('group_changes');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/group_changes', $data);
    }
    
    /**
     * vehicle_histories table
     * @return json
     */
    public function vehicle_histories_table()
    {
          
            $select = [
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                'from_value',
                'to_value',
                db_prefix() . 'fleet_vehicle_histories.addedfrom as addedfrom',
                db_prefix() . 'fleet_vehicle_histories.datecreated as datecreated',
            ];

            $where = [];

            $is_report = $this->request->getPost("is_report");

            $vehicle_id = $this->request->getPost("id");
            if($vehicle_id != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_vehicle_histories.vehicle_id ="'.$vehicle_id.'"');
            }



            $type = $this->request->getPost("type");
            if($type != ''){
                array_push($where, ' AND '.db_prefix() . 'fleet_vehicle_histories.type ="'.$type.'"');
            }

            $from_date = '';
            $to_date   = '';
            if ($this->request->getPost('from_date')) {
                $from_date = $this->request->getPost('from_date');
                if (!$this->Fleet_model->check_format_date($from_date)) {
                    $from_date = to_sql_date($from_date);
                }
            }

            if ($this->request->getPost('to_date')) {
                $to_date = $this->request->getPost('to_date');
                if (!$this->Fleet_model->check_format_date($to_date)) {
                    $to_date = to_sql_date($to_date);
                }
            }
            if ($from_date != '' && $to_date != '') {
                array_push($where, 'AND (datecreated >= "' . $from_date . '" and datecreated <= "' . $to_date . '")');
            } elseif ($from_date != '') {
                array_push($where, 'AND (datecreated >= "' . $from_date . '")');
            } elseif ($to_date != '') {
                array_push($where, 'AND (datecreated <= "' . $to_date . '")');
            }
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_vehicle_histories';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_vehicle_histories.vehicle_id',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['vehicle_id']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];
                $categoryOutput = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">'.$aRow['vehicle_name'].'</a>';

                $row[] = $categoryOutput;
                $row[] = $aRow['from_value'] != null ? $aRow['from_value'] : '';
                $row[] = $aRow['to_value'] != null ? $aRow['to_value'] : '';
                $row[] = get_staff_full_name($aRow['addedfrom']);
                $row[] = _dt($aRow['datecreated']);

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * report status_summary
     * @return view
     */
    public function rp_status_summary(){
        $data['title'] = _l('status_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();

        return $this->template->rander('Fleet\Views\reports/includes/status_summary', $data);
    }

    /**
     * report vehicle_assignment_log
     * @return view
     */
    public function rp_vehicle_assignment_log(){
        $data['title'] = _l('vehicle_assignment_log');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        return $this->template->rander('Fleet\Views\reports/includes/vehicle_assignment_log', $data);
    }

    /**
     * report vehicle_assignment_summary
     * @return view
     */
    public function rp_vehicle_assignment_summary(){
        $data['title'] = _l('vehicle_assignment_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        return $this->template->rander('Fleet\Views\reports/includes/vehicle_assignment_summary', $data);
    }

    /**
     * view report
     * @return view
     */
    public function view_report(){
        $data_filter = $this->request->getPost();
        if(isset($data_filter['from_date'])){
            $data_filter['from_date'] = to_sql_date($data_filter['from_date']);
        }

        if(isset($data_filter['to_date'])){
            $data_filter['to_date'] = to_sql_date($data_filter['to_date']);
        }

        $data = $data_filter;
        $data['title'] = _l($data_filter['type']);
        $data['currency'] = get_setting('default_currency');

        switch ($data_filter['type']) {
            case 'vehicle_assignment_summary':
                $data['vehicles'] = $this->Fleet_model->get_vehicle();
                break;
            case 'cost_meter_trend':
                $data['vehicles'] = $this->Fleet_model->get_vehicle();

                break;

            default:
                break;
        }

        return view('Fleet\Views\reports/details/'.$data_filter['type'], $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_vehicle_assignment_summary_chart() {
        $data_filter = $this->request->getGet();
        $data_vehicle_assignment_summary = $this->Fleet_model->get_data_vehicle_assignment_summary_chart($data_filter);


        echo json_encode([
            'data_vehicle_assignment_summary' => $data_vehicle_assignment_summary,
        ]);
        die();
    }

    /**
     * [rp_inspection_submissions_list description]
     * @return [type] [description]
     */
    public function rp_inspection_submissions_list(){
        $data['title'] = _l('inspection_submissions_list');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        return $this->template->rander('Fleet\Views\reports/includes/inspection_submissions_list', $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_inspection_submissions_list_chart() {
        $data_inspection_submissions_list = $this->Fleet_model->get_data_inspection_submissions_list_chart();


        echo json_encode([
            'data_inspection_submissions_list' => $data_inspection_submissions_list,
        ]);
        die();
    }

    /**
     * [rp_inspection_submissions_summary description]
     * @return [type] [description]
     */
    public function rp_inspection_submissions_summary(){
        $data['title'] = _l('inspection_submissions_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        return $this->template->rander('Fleet\Views\reports/includes/inspection_submissions_summary', $data);
    }

    /**
     * [rp_fuel_summary description]
     * @return [type] [description]
     */
    public function rp_fuel_summary(){
        $data['title'] = _l('fuel_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['currency'] = get_setting('default_currency');
        $data['fuel_summary'] = $this->Fleet_model->get_fuel_summary();


        return $this->template->rander('Fleet\Views\reports/includes/fuel_summary', $data);
    }

    /**
     * [rp_fuel_entries_by_vehicle description]
     * @return [type] [description]
     */
    public function rp_fuel_entries_by_vehicle(){
        $data['title'] = _l('fuel_entries_by_vehicle');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/fuel_entries_by_vehicle', $data);
    }

    /**
     * Gets the data event chart.
     * @return json data chart
     */
    public function get_data_inspection_submissions_summary_chart() {
        $data_inspection_submissions_summary = $this->Fleet_model->get_data_inspection_submissions_summary_chart();


        echo json_encode([
            'data_inspection_submissions_summary' => $data_inspection_submissions_summary,
        ]);
        die();
    }

    /**
     * [rp_vehicle_list description]
     * @return [type] [description]
     */
    public function rp_vehicle_list(){
        $data['title'] = _l('vehicle_list');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/vehicle_list', $data);
    }


    /**
     * [rp_utilization_summary description]
     * @return [type] [description]
     */
    public function rp_utilization_summary(){
        $data['title'] = _l('utilization_summary');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/utilization_summary', $data);
    }

    /**
     * [rp_vehicle_renewal_reminders description]
     * @return [type] [description]
     */
    public function rp_vehicle_renewal_reminders(){
        $data['title'] = _l('vehicle_renewal_reminders');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/vehicle_renewal_reminders', $data);
    }

    /**
     * vehicle reminders table
     * @return json
     */
    public function vehicle_reminders_table(){
           
            $select = [
                db_prefix() . 'fleet_vehicles.name as vehicle_name',
                db_prefix() . 'reminders.description as description',
                db_prefix() . 'reminders.date as date',
                'staff',
                'isnotified',
            ];

            $where        = [
                'AND rel_type="vehicle"',
                ];
            $from_date = '';
            $to_date   = '';
                

                

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'reminders';
            $join         = ['LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'reminders.rel_id',];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['rel_id'
            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $categoryOutput = '<a href="' . admin_url('fleet/vehicle/' . $aRow['rel_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                
                $row[] = $categoryOutput;
                $row[] = $aRow['description'];
                $row[] = _dt($aRow['date']);
                $row[] = '<a href="' . admin_url('staff/profile/' . $aRow['staff']) . '">' . staff_profile_image($aRow['staff'], [
                'staff-profile-image-small',
                ]) . ' ' . get_staff_full_name($aRow['staff']) . '</a>';
                if ($aRow['isnotified'] == 1) {
                    $row[] = _l('reminder_is_notified_boolean_yes');
                } else {
                    $row[] = _l('reminder_is_notified_boolean_no');
                }

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * [rp_fuel_summary_by_location description]
     * @return [type] [description]
     */
    public function rp_fuel_summary_by_location(){
        $data['title'] = _l('fuel_summary_by_location');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['fuel_summary_by_location'] = $this->Fleet_model->fuel_summary_by_location();
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/fuel_summary_by_location', $data);
    }

    /**
     * inspection detail
     * @param  integer $inspection_id 
     * @return view               
     */
    public function inspection_detail($inspection_id) {

        $data['inspection'] = $this->Fleet_model->get_inspections($inspection_id);
        $data['staffs']         = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff", "status" => "active"))->getResultArray();

        return $this->template->rander('Fleet\Views\inspections/inspection_detail', $data);
    }

    /**
     * [rp_inspection_failures_list description]
     * @return [type] [description]
     */
    public function rp_inspection_failures_list(){
        $data['title'] = _l('inspection_failures_list');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/inspection_failures_list', $data);
    }

    /**
     * inspection failures table
     * @return json
     */
    public function inspection_failures_table(){
            $select = [
                db_prefix(). 'fleet_inspection_question_forms.question as question',
                db_prefix(). 'fleet_vehicles.name as vehicle_name',
                db_prefix(). 'fleet_inspection_forms.name as inspection_form_name',
                db_prefix(). 'fleet_inspections.id as inspection_id',
                db_prefix(). 'fleet_inspections.datecreated as date',
            ];

            $where        = ['AND '.db_prefix().'fleet_inspection_question_box_description.is_fail = 1'];

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'fleet_inspection_results';
            $join         = ['LEFT JOIN ' . db_prefix() . 'fleet_inspection_question_box_description ON ' . db_prefix() . 'fleet_inspection_question_box_description.questionboxdescriptionid = ' . db_prefix() . 'fleet_inspection_results.boxdescriptionid',
                'LEFT JOIN ' . db_prefix() . 'fleet_inspections ON ' . db_prefix() . 'fleet_inspections.id = ' . db_prefix() . 'fleet_inspection_results.inspection_id',
                'LEFT JOIN ' . db_prefix() . 'fleet_inspection_forms ON ' . db_prefix() . 'fleet_inspection_forms.id = ' . db_prefix() . 'fleet_inspections.inspection_form_id',
                'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_inspections.vehicle_id',
                'LEFT JOIN ' . db_prefix() . 'fleet_inspection_question_forms ON ' . db_prefix() . 'fleet_inspection_question_forms.questionid = ' . db_prefix() . 'fleet_inspection_question_box_description.questionid AND rel_type = "inspection_form"',
            ];
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['vehicle_id', 'is_fail'
            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row   = [];

                $row[] = _dt($aRow['date']);
                $row[] = '<a href="' . admin_url('fleet/inspection_detail/' . $aRow['inspection_id']) . '">' . _l('submission').' #'.$aRow['inspection_id'] . '</a>';
                $row[] = $aRow['inspection_form_name'];
                $row[] = $aRow['question'];
               
                $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }

    /**
     * [inspection schedules]
     * @return [type] [description]
     */
    public function rp_inspection_schedules(){
        $data['title'] = _l('inspection_schedules');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['currency'] = get_setting('default_currency');
        return $this->template->rander('Fleet\Views\reports/includes/inspection_schedules', $data);
    }

    /**
    * inspections schedules table
    * @return json 
    */
    public function inspection_schedules_table(){
            if($this->request->getPost()){

    
                $currency_name = get_setting('default_currency');

                $select = [
                    db_prefix() .'fleet_inspections.id as id',
                    db_prefix() . 'fleet_vehicles.name as vehicle_name',
                    db_prefix() . 'fleet_inspection_forms.name as inspection_name',
                    db_prefix() . 'fleet_inspections.recurring as recurring',
                    db_prefix() . 'fleet_inspections.is_recurring_from as is_recurring_from',
                    db_prefix() . 'fleet_inspections.last_recurring_date as last_recurring_date',
                    db_prefix() . 'fleet_inspections.addedfrom as addedfrom',
                    db_prefix() . 'fleet_inspections.datecreated as datecreated',
                ];


                $where        = [];
                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'fleet_inspections';
                $join         = [
                    'LEFT JOIN ' . db_prefix() . 'fleet_vehicles ON ' . db_prefix() . 'fleet_vehicles.id = ' . db_prefix() . 'fleet_inspections.vehicle_id',
                    'LEFT JOIN ' . db_prefix() . 'fleet_inspection_forms ON ' . db_prefix() . 'fleet_inspection_forms.id = ' . db_prefix() . 'fleet_inspections.inspection_form_id',
                ];

                $is_report = $this->request->getPost("is_report");
                $vehicle_id = $this->request->getPost("id");
                if($vehicle_id != ''){
                    array_push($where, ' AND '.db_prefix() . 'fleet_inspections.vehicle_id ="'.$vehicle_id.'"');
                }

                $from_date = $this->request->getPost("from_date");
                $to_date = $this->request->getPost("to_date");

                if($from_date != '' && $to_date == ''){
                    $from_date = fe_format_date($from_date);
                    array_push($where, ' AND date('.db_prefix() . 'fleet_inspections.datecreated)="'.$from_date.'"');
                }
                if($from_date != '' && $to_date != ''){
                    $from_date = fe_format_date($from_date);
                    $to_date = fe_format_date($to_date);
                    array_push($where, ' AND date('.db_prefix() . 'fleet_inspections.datecreated) between "'.$from_date.'" AND "'.$to_date.'"');
                }

                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() .'fleet_inspections.vehicle_id as vehicle_id'
                    
                ]);

                $output  = $result['output'];
                $rResult = $result['rResult'];  
                foreach ($rResult as $aRow) {
                    $row = [];

                    $row[] = '<a href="' . admin_url('fleet/vehicle/' . $aRow['vehicle_id']) . '">' . $aRow['vehicle_name'] . '</a>';
                    $row[] = get_staff_full_name($aRow['addedfrom']);
                    $row[] = _d($aRow['datecreated']);  
                    $row[] = '<a href="' . admin_url('fleet/inspection_detail/' . $aRow['id']) . '">' . _l('submission').' #'.$aRow['id'] . '</a>';
                    
                    $row[] = '<span class="text-nowrap">'.$aRow['inspection_name'].'</span>';  
                    if ($aRow['recurring'] != 0) {
                        $row[] = _l('reminder_is_notified_boolean_yes');
                    } else {
                        $row[] = _l('reminder_is_notified_boolean_no');
                    }

                    if($aRow['is_recurring_from'] != 0){
                        $row[] = '<a href="' . admin_url('fleet/inspection_detail/' . $aRow['is_recurring_from']) . '">' . _l('submission').' #'.$aRow['is_recurring_from'] . '</a>';
                    }else{
                        $row[] = '';
                    }

                    $row[] = _d($aRow['last_recurring_date']);

                    $output['aaData'][] = $row;             
                }

                echo json_encode($output);
                die();
            }
    }

    /**
     * [cost meter trend]
     * @return [type] [description]
     */
    public function rp_cost_meter_trend(){
        $data['title'] = _l('cost_meter_trend');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['currency'] = get_setting('default_currency');

        return $this->template->rander('Fleet\Views\reports/includes/cost_meter_trend', $data);
    }

    /**
     * Gets the data cost meter trend chart.
     * @return json data chart
     */
    public function get_data_cost_meter_trend_chart() {
        $data_filter = $this->request->getGet();
        $data_cost_meter_trend = $this->Fleet_model->get_data_cost_meter_trend_chart($data_filter);

        echo json_encode([
            'data_cost_meter_trend' => $data_cost_meter_trend,
        ]);
        die();
    }

    /**
     * [ vehicle details]
     * @return [type] [description]
     */
    public function rp_vehicle_details(){
        $data['title'] = _l('vehicle_details');
        $data['from_date'] = date('Y-01-01');
        $data['to_date'] = date('Y-m-d');
        $data['currency'] = get_setting('default_currency');
        $data['vehicles'] = $this->Fleet_model->get_vehicle();

        return $this->template->rander('Fleet\Views\reports/includes/vehicle_details', $data);
    }

    public function fleet_create_notification($data = array()) {

        ini_set('max_execution_time', 300); //300 seconds 
        //validate notification request

        $event = '';
        $event = get_array_value($data, "event");

        $user_id = get_array_value($data, "user_id");
        $activity_log_id = get_array_value($data, "activity_log_id");

        $options = array(
            "project_id" => get_array_value($data, "project_id"),
            "task_id" => get_array_value($data, "task_id"),
            "project_comment_id" => get_array_value($data, "project_comment_id"),
            "ticket_id" => get_array_value($data, "ticket_id"),
            "ticket_comment_id" => get_array_value($data, "ticket_comment_id"),
            "project_file_id" => get_array_value($data, "project_file_id"),
            "leave_id" => get_array_value($data, "leave_id"),
            "post_id" => get_array_value($data, "post_id"),
            "to_user_id" => get_array_value($data, "to_user_id"),
            "activity_log_id" => get_array_value($data, "activity_log_id"),
            "client_id" => get_array_value($data, "client_id"),
            "invoice_payment_id" => get_array_value($data, "invoice_payment_id"),
            "invoice_id" => get_array_value($data, "invoice_id"),
            "estimate_id" => get_array_value($data, "estimate_id"),
            "order_id" => get_array_value($data, "order_id"),
            "estimate_request_id" => get_array_value($data, "estimate_request_id"),
            "actual_message_id" => get_array_value($data, "actual_message_id"),
            "parent_message_id" => get_array_value($data, "parent_message_id"),
            "event_id" => get_array_value($data, "event_id"),
            "announcement_id" => get_array_value($data, "announcement_id"),
            "exclude_ticket_creator" => get_array_value($data, "exclude_ticket_creator"),
            "notification_multiple_tasks" => get_array_value($data, "notification_multiple_tasks"),
            "contract_id" => get_array_value($data, "contract_id"),
            "lead_id" => get_array_value($data, "lead_id"),
            "proposal_id" => get_array_value($data, "proposal_id"),
            "estimate_comment_id" => get_array_value($data, "estimate_comment_id"),

            "fleet_vehicle_id" => get_array_value($data, "fleet_vehicle_id"),
            "fleet_logbook_id" => get_array_value($data, "fleet_logbook_id"),
        );

        //get data from plugin by persing 'plugin_'
        foreach ($data as $key => $value) {
            if (strpos($key, 'plugin_') !== false) {
                $options[$key] = $value;
            }
        }

        $this->Fleet_model->fleet_create_notification($event, $user_id, $options, $data['to_user_id']);
    }

    public function save_update_education() {
        if ($this->request->getPost()) {
            $Hr_profile_model = model('Hr_profile\Models\Hr_profile_model');
            $data = $this->request->getPost();
            $data['training_time_from'] = to_sql_date1($data['training_time_from']);
            $data['training_time_to'] = to_sql_date1($data['training_time_to']);
            $data['admin_id'] = get_staff_user_id1();
            $data['programe_id'] = '';
            $data['date_create'] = to_sql_date1(get_my_local_time("Y-m-d"), true);
            if ($data['id'] == '') {
                $success = $Hr_profile_model->add_education($data);
                app_redirect('fleet/driver_detail/'.$data['staff_id'].'?group=training_information');
            } else {
                $success = $Hr_profile_model->update_education($data);
                app_redirect('fleet/driver_detail/'.$data['staff_id'].'?group=training_information');
            }
        }

        die;
    }

    /**
     * Saves permissions.
     */
    public function save_permissions(){

        $id = $this->request->getPost('id');
        $data = $this->request->getPost();
        unset($data['id']);

        $success = $this->Fleet_model->update_permission($data, $id);
        if($success){
            $this->session->setFlashdata('success_message', app_lang('updated_successfully'));
        }
        app_redirect('fleet/settings?group=permissions');
    }

    /**
     * { role list data }
     */
    public function role_list_data(){
        $list_data = $this->Roles_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_role_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /**
     * Makes a role row.
     *
     * @param        $data   The data
     *
     * @return       ( row data )
     */
    public function _make_role_row($data){
        return array("<a href='#' data-id='$data->id' class='role-row link'>" . $data->title . "</a>",
                "<a class='edit'><i data-feather='sliders' class='icon-16'></i></a>" 
            );
    }

    /**
     * { permissions }
     */
    public function permissions($role_id){
        if ($role_id) {

            validate_numeric_value($role_id);
            $view_data['model_info'] = $this->Roles_model->get_one($role_id);

            $permissions = unserialize($view_data['model_info']->plugins_permissions);

            if (!isset($permissions["fleet"]) ) {
                $permissions["fleet"] = array();
            }

            //dashboard
            $view_data["fleet_can_view_dashboard"] = get_array_value($permissions["fleet"], "fleet_can_view_dashboard");

            $view_data["fleet_can_view_vehicle"] = get_array_value($permissions["fleet"], "fleet_can_view_vehicle");
            $view_data["fleet_can_create_vehicle"] = get_array_value($permissions["fleet"], "fleet_can_create_vehicle");
            $view_data["fleet_can_edit_vehicle"] = get_array_value($permissions["fleet"], "fleet_can_edit_vehicle");
            $view_data["fleet_can_delete_vehicle"] = get_array_value($permissions["fleet"], "fleet_can_delete_vehicle");

            $view_data["fleet_can_view_transaction"] = get_array_value($permissions["fleet"], "fleet_can_view_transaction");

            $view_data["fleet_can_view_driver"] = get_array_value($permissions["fleet"], "fleet_can_view_driver");
            $view_data["fleet_can_create_driver"] = get_array_value($permissions["fleet"], "fleet_can_create_driver");
            $view_data["fleet_can_edit_driver"] = get_array_value($permissions["fleet"], "fleet_can_edit_driver");
            $view_data["fleet_can_delete_driver"] = get_array_value($permissions["fleet"], "fleet_can_delete_driver");

            $view_data["fleet_can_view_work_performance"] = get_array_value($permissions["fleet"], "fleet_can_view_work_performance");
            $view_data["fleet_can_create_work_performance"] = get_array_value($permissions["fleet"], "fleet_can_create_work_performance");
            $view_data["fleet_can_edit_work_performance"] = get_array_value($permissions["fleet"], "fleet_can_edit_work_performance");
            $view_data["fleet_can_delete_work_performance"] = get_array_value($permissions["fleet"], "fleet_can_delete_work_performance");

            $view_data["fleet_can_view_benefit_and_penalty"] = get_array_value($permissions["fleet"], "fleet_can_view_benefit_and_penalty");
            $view_data["fleet_can_create_benefit_and_penalty"] = get_array_value($permissions["fleet"], "fleet_can_create_benefit_and_penalty");
            $view_data["fleet_can_edit_benefit_and_penalty"] = get_array_value($permissions["fleet"], "fleet_can_edit_benefit_and_penalty");
            $view_data["fleet_can_delete_benefit_and_penalty"] = get_array_value($permissions["fleet"], "fleet_can_delete_benefit_and_penalty");

            $view_data["fleet_can_view_event"] = get_array_value($permissions["fleet"], "fleet_can_view_event");
            $view_data["fleet_can_create_event"] = get_array_value($permissions["fleet"], "fleet_can_create_event");
            $view_data["fleet_can_edit_event"] = get_array_value($permissions["fleet"], "fleet_can_edit_event");
            $view_data["fleet_can_delete_event"] = get_array_value($permissions["fleet"], "fleet_can_delete_event");

            $view_data["fleet_can_view_work_orders"] = get_array_value($permissions["fleet"], "fleet_can_view_work_orders");
            $view_data["fleet_can_create_work_orders"] = get_array_value($permissions["fleet"], "fleet_can_create_work_orders");
            $view_data["fleet_can_edit_work_orders"] = get_array_value($permissions["fleet"], "fleet_can_edit_work_orders");
            $view_data["fleet_can_delete_work_orders"] = get_array_value($permissions["fleet"], "fleet_can_delete_work_orders");

            $view_data["fleet_can_view_garage"] = get_array_value($permissions["fleet"], "fleet_can_view_garage");
            $view_data["fleet_can_create_garage"] = get_array_value($permissions["fleet"], "fleet_can_create_garage");
            $view_data["fleet_can_edit_garage"] = get_array_value($permissions["fleet"], "fleet_can_edit_garage");
            $view_data["fleet_can_delete_garage"] = get_array_value($permissions["fleet"], "fleet_can_delete_garage");

            $view_data["fleet_can_view_maintenance"] = get_array_value($permissions["fleet"], "fleet_can_view_maintenance");
            $view_data["fleet_can_create_maintenance"] = get_array_value($permissions["fleet"], "fleet_can_create_maintenance");
            $view_data["fleet_can_edit_maintenance"] = get_array_value($permissions["fleet"], "fleet_can_edit_maintenance");
            $view_data["fleet_can_delete_maintenance"] = get_array_value($permissions["fleet"], "fleet_can_delete_maintenance");

            $view_data["fleet_can_view_fuel"] = get_array_value($permissions["fleet"], "fleet_can_view_fuel");
            $view_data["fleet_can_create_fuel"] = get_array_value($permissions["fleet"], "fleet_can_create_fuel");
            $view_data["fleet_can_edit_fuel"] = get_array_value($permissions["fleet"], "fleet_can_edit_fuel");
            $view_data["fleet_can_delete_fuel"] = get_array_value($permissions["fleet"], "fleet_can_delete_fuel");

            $view_data["fleet_can_view_part"] = get_array_value($permissions["fleet"], "fleet_can_view_part");
            $view_data["fleet_can_create_part"] = get_array_value($permissions["fleet"], "fleet_can_create_part");
            $view_data["fleet_can_edit_part"] = get_array_value($permissions["fleet"], "fleet_can_edit_part");
            $view_data["fleet_can_delete_part"] = get_array_value($permissions["fleet"], "fleet_can_delete_part");

            $view_data["fleet_can_view_insurance"] = get_array_value($permissions["fleet"], "fleet_can_view_insurance");
            $view_data["fleet_can_create_insurance"] = get_array_value($permissions["fleet"], "fleet_can_create_insurance");
            $view_data["fleet_can_edit_insurance"] = get_array_value($permissions["fleet"], "fleet_can_edit_insurance");
            $view_data["fleet_can_delete_insurance"] = get_array_value($permissions["fleet"], "fleet_can_delete_insurance");

            $view_data["fleet_can_view_inspection"] = get_array_value($permissions["fleet"], "fleet_can_view_inspection");
            $view_data["fleet_can_create_inspection"] = get_array_value($permissions["fleet"], "fleet_can_create_inspection");
            $view_data["fleet_can_edit_inspection"] = get_array_value($permissions["fleet"], "fleet_can_edit_inspection");
            $view_data["fleet_can_delete_inspection"] = get_array_value($permissions["fleet"], "fleet_can_delete_inspection");

            $view_data["fleet_can_view_booking"] = get_array_value($permissions["fleet"], "fleet_can_view_booking");
            $view_data["fleet_can_create_booking"] = get_array_value($permissions["fleet"], "fleet_can_create_booking");
            $view_data["fleet_can_edit_booking"] = get_array_value($permissions["fleet"], "fleet_can_edit_booking");
            $view_data["fleet_can_delete_booking"] = get_array_value($permissions["fleet"], "fleet_can_delete_booking");

            //report
            $view_data["fleet_can_view_report"] = get_array_value($permissions["fleet"], "fleet_can_view_report");

            //setting
            $view_data["fleet_can_view_setting"] = get_array_value($permissions["fleet"], "fleet_can_view_setting");
            $view_data["fleet_can_create_setting"] = get_array_value($permissions["fleet"], "fleet_can_create_setting");
            $view_data["fleet_can_edit_setting"] = get_array_value($permissions["fleet"], "fleet_can_edit_setting");
            $view_data["fleet_can_delete_setting"] = get_array_value($permissions["fleet"], "fleet_can_delete_setting");

            $view_data['permissions'] = $permissions["fleet"];

            return $this->template->view("Fleet\Views\settings\permission_form", $view_data);
        }
    }

    /**
    * delete maintenances
    * @param  integer $id 
    */
    public function delete_maintenance_team($id, $garage_id = ''){
        if($id != ''){
            $result =  $this->Fleet_model->delete_maintenance_team($id);
        }

        if ($garage_id != '') {
            app_redirect('fleet/garage_detail/'.$garage_id);
        }

        app_redirect('fleet/maintenances');
    }
}  