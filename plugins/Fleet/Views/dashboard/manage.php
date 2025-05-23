<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
        <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          </div>

        <div class="row _buttons">
          <div class="col-md-6">
          </div>
          <div class="col-md-6">
                      <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
            
          <div class="_hidden_inputs _filters _tasks_filters">
              <?php
              echo form_hidden('last_30_days');
              echo form_hidden('this_month');
              echo form_hidden('this_quarter');
              echo form_hidden('this_year');
              echo form_hidden('last_month');
              echo form_hidden('last_quarter');
              echo form_hidden('last_year');
              ?>
          </div>

          
          </div>
        </div>
        <div class="card-body">
        <div class="row">
          <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = '';
                  $total_invoices = total_rows(db_prefix() . 'fleet_vehicles', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('vehicles'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-mini no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = 'role_id = '.$driver_role_id;
                  $total_invoices = total_rows(db_prefix() . 'users', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('drivers'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-default no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = '';
                  $total_invoices = total_rows(db_prefix() . 'clients', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('customers'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-warning no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = '';
                  $total_invoices = total_rows(db_prefix() . 'pur_vendor', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('vendors'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-success no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = '';
                  $total_invoices = total_rows(db_prefix() . 'fleet_bookings', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('bookings'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-info no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = 'from_fleet = 1';
                  // Junk leads are excluded from total
                  $total_invoices = total_rows(db_prefix() . 'invoices', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('invoices'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-success no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = '';
                  $total_invoices = total_rows(db_prefix() . 'fleet_work_orders', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('work_orders'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>

                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-default no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="quick-stats-leads mbot10 col-md-3">
            <div class="top_stats_wrapper">
                <?php
                  $where = 'from_fleet = 1';
                  // Junk leads are excluded from total
                  $total_invoices = total_rows(db_prefix() . 'expenses', $where);
                  ?>
                <div class="row pt-3 pb-3">
                  <div class="col-md-9">
                      <i class="fa-solid fa-gas-pump"> </i>&nbsp;<?php echo _l('expenses'); ?>
                  </div>
                  <span class="col-md-3 text-right">
                      <?php echo number_format($total_invoices); ?>
                  </span>
                </div>


                <div class="progress tw-mb-0 tw-mt-4 progress-bar-mini">
                    <div class="progress-bar progress-bar-danger no-percent-text not-dynamic w-100" role="progressbar"
                        aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"
                        data-percent="100">
                    </div>
                </div>
            </div>
        </div>
      </div>
        
        <hr class="mtop-5">
        <div class="clearfix"></div>
        <div id="fleet-calendar"></div>
        <hr class="mtop-5">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-bs-toggle="tooltip" data-bs-title="<?php echo _l('filter_by'); ?>">
            <button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn_filter">
              <i class="fa fa-filter" aria-hidden="true"></i> <?php echo _l('last_30_days'); ?>
            </button>
            <ul class="dropdown-menu width300">
              <li class="filter-group p-2 active" data-filter-group="group-date">
                  <a href="#" data-cview="last_30_days" onclick="dashboard_custom_view('last_30_days','<?php echo _l("last_30_days"); ?>','last_30_days'); return false;">
                      <?php echo _l('last_30_days'); ?>
                  </a>
              </li>
                <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="this_month" onclick="dashboard_custom_view('this_month','<?php echo _l("this_month"); ?>','this_month'); return false;">
                      <?php echo _l('this_month'); ?>
                  </a>
              </li>
              <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="this_quarter" onclick="dashboard_custom_view('this_quarter','<?php echo _l("this_quarter"); ?>','this_quarter'); return false;">
                      <?php echo _l('this_quarter'); ?>
                  </a>
              </li>
              <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="this_year" onclick="dashboard_custom_view('this_year','<?php echo _l("this_year"); ?>','this_year'); return false;">
                      <?php echo _l('this_year'); ?>
                  </a>
              </li>
              <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="last_month" onclick="dashboard_custom_view('last_month','<?php echo _l("last_month"); ?>','last_month'); return false;">
                      <?php echo _l('last_month'); ?>
                  </a>
              </li>
              <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="last_quarter" onclick="dashboard_custom_view('last_quarter','<?php echo _l("last_quarter"); ?>','last_quarter'); return false;">
                      <?php echo _l('last_quarter'); ?>
                  </a>
              </li>
              <li class="filter-group p-2" data-filter-group="group-date">
                  <a href="#" data-cview="last_year" onclick="dashboard_custom_view('last_year','<?php echo _l("last_year"); ?>','last_year'); return false;">
                      <?php echo _l('last_year'); ?>
                  </a>
              </li>
              <div class="clearfix"></div>
              <li class="divider"></li>
              <li class="dropdown-submenu p-2 pull-left filter-group" data-filter-group="group-date">
                 <a href="#" tabindex="-1"><?php echo _l('year'); ?></a>
                 <?php $current_year = date('Y');
                    $y0 = (int)$current_year;
                    $y1 = (int)$current_year - 1;
                    $y2 = (int)$current_year - 2;
                    $y3 = (int)$current_year - 3;
                    $y4 = (int)$current_year - 4;
                 ?>
                 <ul class="dropdown-menu dropdown-menu-left">
                  <li class="filter-group  p-2" data-filter-group="group-date">
                      <a href="#" data-cview="financial_year_<?php echo new_html_entity_decode($y0); ?>" onclick="dashboard_custom_view('financial_year_<?php echo new_html_entity_decode($y0); ?>','<?php echo _l("financial_year").': '.$y0; ?>','financial_year_<?php echo new_html_entity_decode($y0); ?>'); return false;"><?php echo new_html_entity_decode($y0); ?></a>
                  </li>
                  <li class="filter-group  p-2" data-filter-group="group-date">
                      <a href="#" data-cview="financial_year_<?php echo new_html_entity_decode($y1); ?>" onclick="dashboard_custom_view('financial_year_<?php echo new_html_entity_decode($y1); ?>','<?php echo _l("financial_year").': '.$y1; ?>','financial_year_<?php echo new_html_entity_decode($y1); ?>'); return false;"><?php echo new_html_entity_decode($y1); ?></a>
                  </li>
                  <li class="filter-group  p-2" data-filter-group="group-date">
                      <a href="#" data-cview="financial_year_<?php echo new_html_entity_decode($y2); ?>" onclick="dashboard_custom_view('financial_year_<?php echo new_html_entity_decode($y2); ?>','<?php echo _l("financial_year").': '.$y2; ?>','financial_year_<?php echo new_html_entity_decode($y2); ?>'); return false;"><?php echo new_html_entity_decode($y2); ?></a>
                  </li>
                  <li class="filter-group  p-2" data-filter-group="group-date">
                      <a href="#" data-cview="financial_year_<?php echo new_html_entity_decode($y3); ?>" onclick="dashboard_custom_view('financial_year_<?php echo new_html_entity_decode($y3); ?>','<?php echo _l("financial_year").': '.$y3; ?>','financial_year_<?php echo new_html_entity_decode($y3); ?>'); return false;"><?php echo new_html_entity_decode($y3); ?></a>
                  </li>
                  <li class="filter-group  p-2" data-filter-group="group-date">
                      <a href="#" data-cview="financial_year_<?php echo new_html_entity_decode($y4); ?>" onclick="dashboard_custom_view('financial_year_<?php echo new_html_entity_decode($y4); ?>','<?php echo _l("financial_year").': '.$y4; ?>','financial_year_<?php echo new_html_entity_decode($y4); ?>'); return false;"><?php echo new_html_entity_decode($y4); ?></a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
            </div>
          <div class="col-md-6 mtop15">
            <div class="panel_s">
              <div class="panel-body">
                <div id="profit_and_loss"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mtop15">
            <div class="panel_s">
              <div class="panel-body">
                <div id="sales_chart"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mtop25">
            <div class="col-md-6">
                <div class="panel_s">
                  <div class="panel-heading">
                    <h4><?php echo _l('fuel_consumption_ranking'); ?></h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-striped  no-margin">
                        <thead>
                            <tr>
                                <th><?php echo _l('rank'); ?></th>
                                <th><?php echo _l('driver'); ?></th>
                                <th class="text-right"><?php echo _l('consumption').' ('._l('100_km').')'; ?></th>
                            </tr>
                        </thead>
                      <tbody>
                        <?php foreach($fuel_consumption_ranking as $ranking){ ?>
                          <tr class="project-overview">
                            <td width="10%"><?php echo new_html_entity_decode($ranking['rank']); ?></td>
                            <td width="50%"><a href="<?php echo admin_url('fleet/vehicle/'.$ranking['vehicle_id']); ?>" class="invoice-number"><?php echo new_html_entity_decode($ranking['vehicle_name']); ?></a></td>
                            <td class="text-right"><?php echo new_html_entity_decode($ranking['consumption_100km']); ?></td>
                         </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <div class="col-md-6">
                <div class="panel_s">
                  <div class="panel-heading">
                    <h4><?php echo _l('driver_ranking'); ?></h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-striped  no-margin">
                        <thead>
                            <tr>
                                <th><?php echo _l('rank'); ?></th>
                                <th><?php echo _l('driver'); ?></th>
                                <th class="text-right"><?php echo _l('rating_total_reviews'); ?></th>
                            </tr>
                        </thead>
                      <tbody>
                        <?php foreach($calculating_driver_point as $ranking){ ?>
                          <tr class="project-overview">
                            <td width="10%"><?php echo new_html_entity_decode($ranking['rank']); ?></td>
                            <td width="50%"><a href="<?php echo admin_url('fleet/driver_detail/'.$ranking['driver_id']); ?>" class="invoice-number"><?php echo new_html_entity_decode($ranking['driver_name']); ?></a></td>
                            <td class="text-right"><?php echo new_html_entity_decode($ranking['rating'].'/'.$ranking['total_rating']); ?></td>
                         </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
</div>
   
<!-- box loading -->
<div id="box-loading"></div>
<?php require('plugins/Fleet/assets/js/dashboard/manage_js.php'); ?>
