<?php if(isset($vehicle)){ ?>
<div class="page-title clearfix">
 <h1><?php echo _l('assignment_history'); ?></h1>
 <div class="title-button-group">
  <div class="clearfix"></div>
       <a href="#" onclick="add_vehicle_assignment();" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_edit_driver') && !fleet_has_permission('fleet_can_edit_vehicle')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
   </div>
 </div>
<?php render_datatable(array(
_l('vehicle'),
_l('driver'),
  _l('start_time'),
  _l('end_time'),
  _l('starting_odometer'),
  _l('ending_odometer'),
_l('addedfrom'),
  ),'vehicle-assignments'); ?>

<?php $arrAtt = array();
      $arrAtt['data-type']='currency';
?>
<div class="modal fade" id="vehicle-assignment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo _l('vehicle_assignment')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php echo form_open_multipart(admin_url('fleet/vehicle_assignment'),array('id'=>'vehicle-assignment-form', 'class'=> 'general-form'));?>
         <?php echo form_hidden('id'); ?>
      <div class="modal-body">
        <?php echo render_select('vehicle_id',$vehicles, array('id', 'name'),'vehicle', $vehicle->id, ['required' => true]); ?>
        <?php echo render_select('driver_id',$drivers, array('id', array('first_name', 'last_name')),'driver', '', ['required' => true]); ?>
        <div class="row">
          <div class="col-md-6">
            <?php echo render_input('start_time','start_time', '', 'text', ['required' => true]); ?>
          </div>
          <div class="col-md-6">
            <?php echo render_input('starting_odometer','starting_odometer', '', 'text', $arrAtt); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?php echo render_input('end_time','end_time'); ?>
          </div>
          <div class="col-md-6">
            <?php echo render_input('ending_odometer','ending_odometer', '', 'text', $arrAtt); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div>
<?php } ?>