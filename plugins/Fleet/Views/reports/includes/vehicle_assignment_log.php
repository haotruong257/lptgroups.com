<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <hr />
          <div id="container_chart"></div>

          <?php render_datatable(array(
              _l('vehicle'),
              _l('driver'),
                _l('start_time'),
                _l('end_time'),
                _l('starting_odometer'),
                _l('ending_odometer'),
              _l('addedfrom'),
            ),'vehicle-assignments'); ?>
        </div>
     </div>
    </div>
<!-- box loading -->
<div id="box-loading"></div>
