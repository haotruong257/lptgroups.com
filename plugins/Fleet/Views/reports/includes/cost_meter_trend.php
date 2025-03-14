<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
         <div class="card-body">
          <h4><?php echo html_entity_decode($title); ?></h4>
          <a href="<?php echo admin_url('fleet/reports'); ?>"><?php echo _l('back_to_report_list'); ?></a>
          <?php echo form_hidden('timezone', date_default_timezone_get()); ?>
          <?php echo form_hidden('is_report', 1); ?>
          <hr />
            <?php echo form_open(admin_url('fleet/view_report'),array('id'=>'filter-form', 'class' => 'general-form')); ?>
          <div class="row">
              <div class="col-md-5">
                <?php echo render_date_input('from_date','from_date', _d($from_date)); ?>
              </div>
              <div class="col-md-5">
                <?php echo render_date_input('to_date','to_date', _d($to_date)); ?>
              </div>
              <div class="col-md-2">
                <?php echo form_hidden('type', 'cost_meter_trend'); ?>
                <a href="#" onclick="filter_form_handler(); return false;" class="btn btn-info btn-submit mtop25 text-white"><?php echo _l('filter'); ?></a>
              </div>
          </div>
            <?php echo form_close(); ?>

          <div id="container_chart"></div>

          <div id="DivIdToPrint"></div>
        </div>
     </div>
    </div>
  </div>
<!-- box loading -->
<div id="box-loading"></div>
