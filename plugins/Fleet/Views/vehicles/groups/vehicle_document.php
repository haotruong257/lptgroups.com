<?php if(isset($vehicle)){ ?>
<div class="page-title clearfix">
 <h1><?php echo _l('vehicle_document'); ?></h1>
 <div class="title-button-group">
  <div class="clearfix"></div>
       <a href="<?php echo admin_url('fleet/driver_document?vehicle_id='.$vehicle->id); ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_edit_vehicle')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
   </div>
 </div>
<?php echo view('Fleet\Views\vehicle_documents/table_html'); ?>
<?php } ?>
