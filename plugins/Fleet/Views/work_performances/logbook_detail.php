<?php 

if(fleet_has_permission('fleet_can_edit_work_performance')){
  $status = fleet_render_status_html($logbook->id, 'logbook', $logbook->status, true);   
}else{
  $status = fleet_render_status_html($logbook->id, 'logbook', $logbook->status, false);   
}

?>
<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="<?php echo get_uri('fleet/vehicle'); ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_vehicle')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
    </div>
   <div class="row">
    <div class="col-md-12">
      <div class="panel_s accounting-template estimate">
        <div class="panel-body">
            <h4 class="h4-color"><?php echo _l('general_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('name'); ?></td>
                          <td><?php echo new_html_entity_decode($logbook->name) ; ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('status'); ?></td>
                          <td><?php echo new_html_entity_decode($status); ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('date'); ?></td>
                          <td><?php echo _d($logbook->date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('description'); ?></td>
                          <td><?php echo new_html_entity_decode($logbook->description); ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-striped no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('booking_number'); ?></td>
                          <td><a href="<?php echo admin_url('fleet/booking_detail/'.$logbook->booking_id) ?>"><?php echo new_html_entity_decode($logbook->booking->number); ?></a></td>
                       </tr>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('vehicle'); ?></td>
                          <td><a href="<?php echo admin_url('fleet/vehicle/'.$logbook->vehicle_id) ?>"><?php echo new_html_entity_decode($logbook->vehicle->name); ?></a></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('vehicle'); ?></td>
                          <td><a href="<?php echo admin_url('fleet/driver_detail/'.$logbook->driver_id) ?>"><?php echo get_staff_full_name($logbook->driver_id); ?></a></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
            <h4 class="h4-color mtop25"><?php echo _l('time_card'); ?></h4>
            <hr class="hr-color">
            <div class="page-title clearfix">
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-time-card <?php if(!fleet_has_permission('fleet_can_edit_work_performance')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
            
            <table class="table table-time-card scroll-responsive">
               <thead>
                  <tr>
                     <th><?php echo _l('driver'); ?></th>
                     <th><?php echo _l('start_time'); ?></th>
                     <th><?php echo _l('end_time'); ?></th>
                     <th><?php echo _l('notes'); ?></th>
                  </tr>
               </thead>
            </table> 
            <div class="row">
            <div class="col-md-12">
                <hr>  
                <a href="<?php echo admin_url('fleet/work_performances'); ?>" class="btn btn-default pull-right"><?php echo _l('close'); ?></a>
            </div>
            </div>
            </div>
        </div>               
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

<div class="modal fade" id="time-card-modal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('update_info')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/time_card'),array('id'=>'time-card-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
         <?php echo form_hidden('logbook_id', $logbook->id); ?>
         
         <div class="modal-body">
         <div class="row">
         <div class="col-md-6">
                <?php echo render_datetime_input('start_time', 'start_time', '', ['required' => true]); ?>
         </div>
         <div class="col-md-6">
                <?php echo render_datetime_input('end_time', 'end_time', '', ['required' => true]); ?>
         </div>
         </div>
            <?php echo render_textarea('notes','notes'); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>