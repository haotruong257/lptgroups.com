<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-booking <?php if(!fleet_has_permission('fleet_can_create_booking')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
                <?php 
                echo render_select('status', $booking_status, array('id', 'name'), 'status');
                ?>
              </div>
            <div class="col-md-3">
              <?php echo render_date_input('from_date','from_date'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_date_input('to_date','to_date'); ?>
            </div>
          </div>
          <hr>
          <table class="table table-fuel scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('booking_number'); ?></th>
                 <th><?php echo _l('subject'); ?></th>
                 <th><?php echo _l('delivery_date'); ?></th>
                 <th><?php echo _l('customer'); ?></th>
                 <th><?php echo _l('amount'); ?></th>
                 <th><?php echo _l('status'); ?></th>
                 <th><?php echo _l('invoice'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
<?php $arrAtt = array();
      $arrAtt['data-type']='currency';
?>
<div class="modal fade" id="booking-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('booking')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/booking'),array('id'=>'booking-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
        
         <div class="modal-body">
                <?php echo render_select('userid', $clients, array('id','company_name','customerGroups'), 'customer', '', ['required' => true]); ?>
                <?php echo render_input('subject', 'subject', '', 'text',['required' => true]); ?>
                <div class="row">
                   <div class="col-md-6">
                     <?php echo render_date_input('delivery_date', 'delivery_date', '', ['required' => true]); ?>
                   </div>
                   <div class="col-md-6">
                     <?php echo render_input('phone', 'phone', '', 'text',['required' => true]) ?>
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-6">
                     <?php echo render_textarea('receipt_address','receipt_address', '', ['required' => true]); ?>
                   </div>
                   <div class="col-md-6">
                     <?php echo render_textarea('delivery_address','delivery_address', '', ['required' => true]); ?>
                   </div>
                </div>
                <?php echo render_textarea('note','note'); ?>
                <?php echo render_input('amount', 'amount', '', 'text', $arrAtt); ?>
                <?php echo render_textarea('admin_note','admin_note'); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>
<?php require 'plugins/Fleet/assets/js/bookings/manage_js.php'; ?>
