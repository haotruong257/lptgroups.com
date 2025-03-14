<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <hr />
          <div class="row mtop25">
            <div class="col-md-4">
                <div class="panel_s">
                  <div class="panel-heading">
                    <h4><?php echo _l('distance_based_vehicles_summary'); ?></h4>
                  </div>

                  <div class="panel-body">
                    <table class="table table-striped  no-margin">
                      <tbody>
                          <tr class="project-overview">
                            <td width="10%"><?php echo _l('usage'); ?></td>
                            <td width="50%" class="text-right"><?php echo number_format($fuel_summary['usage']); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('gallons'); ?></td>
                            <td width="50%" class="text-right"><?php echo number_format($fuel_summary['gallons']); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('economy'); ?></td>
                            <td width="50%" class="text-right"><?php echo number_format($fuel_summary['economy']); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('total_fuel_cost'); ?></td>
                            <td width="50%" class="text-right"><?php echo to_currency($fuel_summary['total_fuel_cost'], $currency); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('cost_gallons'); ?></td>
                            <td width="50%" class="text-right"><?php echo to_currency($fuel_summary['cost_gallons'], $currency); ?></td>
                         </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="panel_s">
                  <div class="panel-heading">
                    <h4><?php echo _l('all_vehicles_summary'); ?></h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-striped  no-margin">
                      <tbody>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('gallons'); ?></td>
                            <td width="50%" class="text-right"><?php echo number_format($fuel_summary['gallons']); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('total_fuel_cost'); ?></td>
                            <td width="50%" class="text-right"><?php echo to_currency($fuel_summary['total_fuel_cost'], $currency); ?></td>
                         </tr>
                         <tr class="project-overview">
                            <td width="10%"><?php echo _l('cost_gallons'); ?></td>
                            <td width="50%" class="text-right"><?php echo to_currency($fuel_summary['cost_gallons'], $currency); ?></td>
                         </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            
        </div>
          <table class="table table-booking scroll-responsive mtop25 dataTable ">
               <thead>
                  <tr>
                    <th><?php echo _l('vehicle'); ?></th>
                   <th><?php echo _l('usage'); ?></th>
                   <th><?php echo _l('gallons'); ?></th>
                   <th><?php echo _l('economy'); ?></th>
                   <th><?php echo _l('total_fuel_cost'); ?></th>
                   <th><?php echo _l('cost_gallons'); ?></th>
                  </tr>
               </thead>
               <tbody></tbody>
               <tfoot>
                  <?php 
                      $Fleet_model = model("Fleet\Models\Fleet_model");
                      foreach($vehicles as $vehicle){ 
                          $fuel_summary = $Fleet_model->fuel_summary_by_vehicle($vehicle['id']);
                          ?>
                         <tr>
                            <td><a href="<?php echo site_url('fleet/vehicle/' . $vehicle['id']); ?>" class="invoice-number">
                                      <?php echo new_html_entity_decode($vehicle['name']); ?>
                                    </a></td>
                            <td><?php echo number_format($fuel_summary['usage']); ?></td>
                            <td><?php echo number_format($fuel_summary['gallons']); ?></td>
                            <td><?php echo number_format($fuel_summary['economy']); ?></td>
                            <td><?php echo to_currency($fuel_summary['total_fuel_cost'], $currency); ?></td>
                            <td><?php echo to_currency($fuel_summary['cost_gallons'], $currency); ?></td>
                         </tr>
                      <?php } ?>
               </tfoot>
            </table>
      </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
