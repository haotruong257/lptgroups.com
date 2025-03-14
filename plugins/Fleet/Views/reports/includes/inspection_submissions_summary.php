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
                    <th><?php echo _l('group'); ?></th>
                   <th><?php echo _l('submissions_count'); ?></th>
                   <th><?php echo _l('forms_count'); ?></th>
                  </tr>
               </thead>
               <tbody></tbody>
               <tfoot>
                  <?php 
                      $Fleet_model = model("Fleet\Models\Fleet_model");
                      foreach($vehicles as $vehicle){ 
                          $inspections_summary = $Fleet_model->inspections_summary_by_vehicle($vehicle['id']);
                          ?>
                         <tr>
                            <td><?php echo new_html_entity_decode($vehicle['name']); ?></td>
                            <td><?php echo number_format($inspections_summary['submission_count']); ?></td>
                            <td><?php echo number_format($inspections_summary['forms_count']); ?></td>
                         </tr>
                      <?php } ?>
               </tfoot>
            </table>
      </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
