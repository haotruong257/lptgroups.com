<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <hr />
          <table class="table table-booking scroll-responsive mtop25 dataTable ">
               <thead>
                  <tr>
                    <th><?php echo _l('group'); ?></th>
                   <th><?php echo _l('transactions'); ?></th>
                   <th><?php echo _l('vehicles'); ?></th>
                   <th><?php echo _l('total_cost'); ?></th>
                  </tr>
               </thead>
               <tbody></tbody>
               <tfoot>
                  <?php 
                      $Fleet_model = model("Fleet\Models\Fleet_model");
                      foreach($vehicle_groups as $group){ 
                          $expense_summary = $Fleet_model->expense_summary_by_vehicle_group($group['id']);
                          ?>
                         <tr>
                            <td><?php echo new_html_entity_decode($group['name']); ?></td>
                            <td><?php echo number_format($expense_summary['total_transaction']); ?></td>
                            <td><?php echo number_format($expense_summary['total_vehicle']); ?></td>
                            <td><?php echo to_currency($expense_summary['total_cost'], $currency); ?></td>
                         </tr>
                      <?php } ?>
               </tfoot>
            </table>
      </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
