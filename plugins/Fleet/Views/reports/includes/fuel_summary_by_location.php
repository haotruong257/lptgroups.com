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

          <table class="table table-booking scroll-responsive mtop25 dataTable ">
               <thead>
                  <tr>
                    <th><?php echo _l('fuel_vendor_location'); ?></th>
                    <th><?php echo _l('transactions'); ?></th>
                   <th><?php echo _l('gallons'); ?></th>
                   <th><?php echo _l('cost'); ?></th>
                  </tr>
               </thead>
               <tbody></tbody>
               <tfoot>
                  <?php 
                      foreach($fuel_summary_by_location as $key => $fuel_summary){ 
                          ?>
                         <tr>
                            <td><?php echo new_html_entity_decode($key); ?></td>
                            <td><?php echo number_format($fuel_summary['transactions']); ?></td>
                            <td><?php echo number_format($fuel_summary['gallons']); ?></td>
                            <td><?php echo to_currency($fuel_summary['cost'], $currency); ?></td>
                         </tr>
                      <?php } ?>
               </tfoot>
            </table>
      </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
