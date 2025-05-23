<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <?php echo form_hidden('type', 'status_change'); ?>
          <hr />
          <div id="container_chart"></div>

          <table class="table table-email-logs mtop25">
            <thead>
              <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('from'); ?></th>
                 <th><?php echo _l('to'); ?></th>
                 <th><?php echo _l('user'); ?></th>
                 <th><?php echo _l('date'); ?></th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
     </div>
    </div>
<!-- box loading -->
<div id="box-loading"></div>
