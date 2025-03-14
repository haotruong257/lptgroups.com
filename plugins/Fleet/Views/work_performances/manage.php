<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-logbook <?php if(!fleet_has_permission('fleet_can_create_work_performance')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
                <?php 
                echo render_select('status', $logbook_status, array('id', 'name'), 'status');
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
            <?php echo render_input('name', 'name', '', 'text', ['required' => true]); ?>
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
