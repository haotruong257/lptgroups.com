<?php if(isset($part)){ ?>
  <div class="page-title clearfix">
          <h1><?php echo _l('assignment_history'); ?></h1>
    </div>
<?php echo form_hidden('type', 'assignee'); ?>

<?php render_datatable(array(
  _l('assignee'),
  _l('start_time'),
  _l('end_time'),
  _l('started_by'),
  _l('ended_by'),
  ),'part-histories'); ?>

<?php } ?>