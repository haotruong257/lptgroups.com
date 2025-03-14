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

          <table class="table table-email-logs mtop25">
            <thead>
              <th><?php echo  _l('date'); ?></th>
              <th><?php echo  _l('submission'); ?></th>
              <th><?php echo  _l('form'); ?></th>
              <th><?php echo  _l('item'); ?></th>
              <th><?php echo  _l('vehicle'); ?></th>
            </thead>
            <tbody>
            </tbody>
          </table>
      </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
