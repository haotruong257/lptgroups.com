<?php if(isset($part)){ ?>
  <div class="page-title clearfix">
          <h1><?php echo _l('linked_vehicle_history'); ?></h1>
    </div>

<?php echo form_hidden('type', 'linked_vehicle'); ?>

<?php render_datatable(array(
  _l('linked_vehicle'),
  _l('start_time'),
  _l('end_time'),
  _l('started_by'),
  _l('ended_by'),
  ),'part-histories'); ?>

<?php } ?>