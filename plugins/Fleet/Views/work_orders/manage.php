<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="<?php echo admin_url('fleet/work_order'); ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_work_orders')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
              <?php 
                $statuss = [
                     ['id' => 'open', 'name' => _l('open')],
                     ['id' => 'in_progress', 'name' => _l('in_progress')],
                     ['id' => 'parts_ordered', 'name' => _l('parts_ordered')],
                     ['id' => 'complete', 'name' => _l('complete')],
                  ];
                echo render_select('_status', $statuss, array('id', 'name'), 'status');
                ?>
            </div>
            <div class="col-md-3">
              <?php echo render_date_input('from_date','from_date'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_date_input('to_date','to_date'); ?>
            </div>
          </div>
          <hr>
          <table class="table table-work-order scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('work_order_number'); ?></th>
                 <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('vendor'); ?></th>
                 <th><?php echo _l('issue_date'); ?></th>
                 <th><?php echo _l('start_date'); ?></th>
                 <th><?php echo _l('complete_date'); ?></th>
                 <th><?php echo _l('total'); ?></th>
                 <th><?php echo _l('status'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'plugins/Fleet/assets/js/work_orders/manage_js.php'; ?>
