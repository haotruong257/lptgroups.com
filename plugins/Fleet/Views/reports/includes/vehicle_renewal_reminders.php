<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <hr />

          <table class="table table-email-logs mtop25">
            <thead>
               <th><?php echo _l('vehicle'); ?></th>
               <th><?php echo _l('reminder_description'); ?></th>
               <th><?php echo _l('reminder_date'); ?></th>
               <th><?php echo _l('reminder_staff'); ?></th>
               <th><?php echo _l('reminder_is_notified'); ?></th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
     </div>
    </div>
<!-- box loading -->
<div id="box-loading"></div>
