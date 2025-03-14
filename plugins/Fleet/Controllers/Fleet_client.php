<?php

/**
 * Fleet Controller
 */

namespace Fleet\Controllers;

use App\Controllers\Security_Controller;

class Fleet_client extends Security_Controller
{
    public function index()
    {
        if(is_client_logged_in()){

            $data['title'] = _l('fleet_bookings');
            $this->Fleet_model = new \Fleet\Models\Fleet_model();
            $data['currency'] = get_setting('default_currency');

            $data['booking_status'] = fleet_booking_status();
            $data['clients'] = $this->Clients_model->get_details(["is_lead" => 0, 'delete' => 0])->getResultArray();

            return $this->template->rander('Fleet\Views\client/manage', $data);

        }else{
            app_redirect(site_url());
        }
    }

    /**
     * add or edit booking
     * 
     * @return     json
     */
    public function booking(){
            $this->Fleet_model = new \Fleet\Models\Fleet_model();
        $data = $this->request->getPost();
        if($data['id'] == ''){
            if (!has_permission('fleet_bookings', '', 'create')) {
                access_denied('fleet');
            }
            $success = $this->Fleet_model->add_booking([
                    'number'    => 'BOOKING'.time(),
                    'subject'    => $data['subject'],
                    'phone' => $data['phone'],
                    'delivery_date'   => $data['delivery_date'],
                    'receipt_address'   => $data['receipt_address'],
                    'delivery_address'   => $data['delivery_address'],
                    'note'   => $data['note'],
                    'contactid' => get_contact_user_id(),
                    'userid'    => get_client_user_id(),
                ]);
            if($success){
                $message = _l('added_successfully');

                app_redirect('fleet_client/booking_detail/' . $success);
            }else {
                $message = _l('bookings_failed');
            }
        }

        app_redirect('fleet/bookings');
    }

    public function booking_detail($id){
        $this->Fleet_model = new \Fleet\Models\Fleet_model();

        $data             = [];
        $data['booking'] = $this->Fleet_model->get_booking($id);
        $data['title']    = _l('booking');

        return $this->template->rander('Fleet\Views\client/booking_detail', $data);

    }

    public function rating($id){
        $this->Fleet_model = new \Fleet\Models\Fleet_model();

        $data             = $this->request->getPost();

        $success = $this->Fleet_model->update_booking([
                    'rating'   => $data['rating'],
                    'comments'   => $data['comments'],
                ], $id);

        if ($success) {
        }

        app_redirect('fleet_client/booking_detail/' . $id);
    }

    /**
     * bookings table
     * @return json
     */
    public function bookings_table()
    {
            $this->Fleet_model = new \Fleet\Models\Fleet_model();

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

            array_push($where, ' AND '.db_prefix() . 'fleet_bookings.userid ="'.get_client_user_id().'"');

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
                $categoryOutput = '<a href="' . admin_url('fleet_client/booking_detail/' . $aRow['id']) . '">' . $aRow['number'] . '</a>';

                $row[] = $categoryOutput;
                $row[] = $aRow['subject'];
                $row[] = _d($aRow['delivery_date']);
                $row[] = $aRow['company'];
                $row[] = to_currency($aRow['amount'], $currency);
                $row[] = fleet_render_status_html($aRow['id'], 'booking', $aRow['status'], false);
                $row[] = '<a href="'. admin_url('invoices/preview/'.$aRow['invoice_id']) .'">' . ($aRow['invoice_id'] != 0 ? get_invoice_id($aRow['invoice_id']) : '') .'</a>';

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
    }
    
}
