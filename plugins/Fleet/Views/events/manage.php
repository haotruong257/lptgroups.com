<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-event <?php if(!fleet_has_permission('fleet_can_create_event')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
              <?php 
                $event_type = [
                  ['id' => 'accident', 'name' => _l('accident')],
                  ['id' => 'parts_damage', 'name' => _l('parts_damage')],
                  ['id' => 'other', 'name' => _l('other')],
                ];
                echo render_select('_event_type', $event_type, array('id', 'name'), 'event_type');
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
          <table class="table table-event scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('subject'); ?></th>
                 <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('driver'); ?></th>
                 <th><?php echo _l('event_time'); ?></th>
                 <th><?php echo _l('event_type'); ?></th>
                 <th><?php echo _l('description'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $arrAtt = array();
      $arrAtt['data-type']='currency';
?>
<div class="modal fade" id="event-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('event')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/event'),array('id'=>'event-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
         
         <div class="modal-body">
            <?php echo render_input('subject', 'subject', '', 'text', ['required' => true]); ?>
            <?php echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', '', ['required' => true]); ?>
            <?php echo render_select('driver_id', $drivers, array('id', array('first_name', 'last_name')),'driver', '', ['required' => true]); ?>
            <?php echo render_datetime_input('event_time', 'event_time', '', ['required' => true]); ?>
            <?php echo render_select('event_type', $event_type, array('id', 'name'), 'event_type', '', ['required' => true]); ?>
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

<?php require 'plugins/Fleet/assets/js/events/manage_js.php'; ?>
