<?php 
if(fleet_has_permission('fleet_can_edit_booking')){
  $status = fleet_render_status_html($booking->id, 'booking', $booking->status, true);   
}else{
  $status = fleet_render_status_html($booking->id, 'booking', $booking->status, false);   
}
?>
<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
   <div class="row">
    <div class="col-md-12">
      <div class="panel_s accounting-template estimate">
        <div class="panel-body">
          <div class="row">
              <?php
              $currency_name = '';
              if(isset($base_currency)){
                $currency_name = $base_currency->name;
              }
              $sub_total = 0;
              ?>
                  
              <div class="invoice accounting-template">
                <div class="col-md-12 fr1">
                <div class="col-12">
                    <a href="<?php echo admin_url('fleet/bookings'); ?>" class="btn btn-default pull-right"><?php echo _l('close'); ?></a>
                    <a href="#"  onclick="update_info(<?php echo new_html_entity_decode($booking->id); ?>); return false;" class="btn btn-info pull-right mright10 text-white <?php if(!fleet_has_permission('fleet_can_edit_booking')){echo 'hide';} ?>"><?php echo _l('update_info'); ?></a>
                    <?php if(!$booking->invoice_id > 0){ ?>
                      <a href="#"  onclick="create_invoice(<?php echo new_html_entity_decode($booking->id); ?>); return false;" id="btn-create-invoice" class="btn btn-success pull-right mright10 <?php if(!fleet_has_permission('fleet_can_edit_booking')){echo 'hide';} ?>"><?php echo _l('create_invoice'); ?></a>
                  <?php }else{ ?>
                    <a href="<?php echo admin_url('invoices/view/'.$booking->invoice_id); ?>" class="btn pull-right"><?php echo _l('view_invoice'); ?></a>
                  <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-md-12">
                <hr>  
              </div>  
        </div>  
            <h4 class="h4-color"><?php echo _l('general_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                    <?php echo form_hidden('_booking_id', $booking->id); ?>

                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('booking_number'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->number) ; ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('status'); ?></td>
                          <td><?php echo new_html_entity_decode($status); ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('delivery_date'); ?></td>
                          <td><?php echo _d($booking->delivery_date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('receipt_address'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->receipt_address) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('note'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->note); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-striped no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('customer'); ?></td>
                          <td><a href="<?php echo admin_url('clients/client/'.$booking->userid) ?>"><?php echo get_company_name($booking->userid); ?></a></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('delivery_date'); ?></td>
                          <td><?php echo _d($booking->delivery_date) ; ?></td>
                       </tr>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('phone'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->phone); ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('delivery_address'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->delivery_address) ; ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
            <h4 class="h4-color mtop25"><?php echo _l('admin_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
            <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('invoice'); ?></td>
                          <td id="invoice-number"><a href="<?php echo admin_url('invoices/view/'.$booking->invoice_id) ?>"><?php echo ($booking->invoice_id != 0 ? get_invoice_id($booking->invoice_id) : ''); ?></a></td>
                       </tr>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('amount'); ?></td>
                          <td><?php echo to_currency($booking->amount, '') ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('admin_note'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->admin_note); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
          <?php if($booking->rating != 0){ ?>
            <h4 class="h4-color mtop25"><?php echo _l('rating'); ?></h4>
            <hr class="hr-color">
            <div class="row">
            <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('rating'); ?></td>
                          <td><div class="_star-rating">
                        <a href="#" class="a-rating <?php if($booking->rating >= 1){ echo 'checked'; } ?>" data-rating="1"><i data-feather="star" class="icon-16"></i></a>
                  <a href="#" class="a-rating <?php if($booking->rating >= 2){ echo 'checked'; } ?>" data-rating="2"><i data-feather="star" class="icon-16"></i></a>
                  <a href="#" class="a-rating <?php if($booking->rating >= 3){ echo 'checked'; } ?>" data-rating="3"><i data-feather="star" class="icon-16"></i></a>
                  <a href="#" class="a-rating <?php if($booking->rating >= 4){ echo 'checked'; } ?>" data-rating="4"><i data-feather="star" class="icon-16"></i></a>
                  <a href="#" class="a-rating <?php if($booking->rating == 5){ echo 'checked'; } ?>" data-rating="5"><i data-feather="star" class="icon-16"></i></a>
                        <input type="hidden" name="rating" class="rating-value" value="<?php echo new_html_entity_decode($booking->rating); ?>">
                     </div></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('rating_comments'); ?></td>
                          <td><?php echo new_html_entity_decode($booking->comments); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
        <?php } ?>
              
        <h4 class="h4-color mtop25"><?php echo _l('logbook'); ?></h4>
        <hr class="hr-color">
        <div class="page-title clearfix">
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-logbook <?php if(!fleet_has_permission('fleet_can_create_logbook')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <table class="table table-logbook scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('name'); ?></th>
                 <th><?php echo _l('booking_number'); ?></th>
                 <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('driver'); ?></th>
                 <th><?php echo _l('date'); ?></th>
                 <th><?php echo _l('status'); ?></th>
              </tr>
           </thead>
        </table>     
  </div>
</div>
</div>
<div class="modal fade" id="chosse" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="add-title"><?php echo _l('please_let_us_know_the_reason_for_canceling_the_order') ?></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <?php echo render_textarea('cancel_reason','cancel_reason',''); ?>
        </div>
      </div>
      <div class="clearfix">               
        <br>
        <br>
        <div class="clearfix">               
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          <button type="button" data-status="8" class="btn btn-danger cancell_order"><?php echo _l('cancell'); ?></button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div><!-- /.modal -->
<?php $arrAtt = array();
      $arrAtt['data-type']='currency';
?>
<div class="modal fade" id="info-modal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('update_info')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/booking_update_info'),array('id'=>'info-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id', $booking->id); ?>
         
         <div class="modal-body">
                <?php echo render_input('amount', 'amount', $booking->amount, 'text', $arrAtt); ?>
                <?php echo render_textarea('admin_note','admin_note', $booking->admin_note); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>

<div class="modal fade" id="logbook-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('logbook')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/logbook'),array('id'=>'logbook-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
         
         <div class="modal-body">
            <?php echo render_select('booking_id', $bookings, array('id', 'number'), 'booking', '', ['required' => true]); ?>
            <?php echo render_select('vehicle_id', $vehicles, array('id', 'name'),'vehicle', '', ['required' => true]); ?>
            <?php echo render_select('driver_id', $drivers, array('id', array('first_name', 'last_name')),'driver', '', ['required' => true]); ?>
            <?php echo render_input('name', 'name', '', 'text',['required' => true]); ?>
            <?php echo render_input('odometer', 'odometer'); ?>
            <?php echo render_date_input('date', 'date', '', ['required' => true]); ?>
            <?php echo render_textarea('description','description'); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>
<?php require 'plugins/Fleet/assets/js/work_performances/logbook_manage_js.php'; ?>