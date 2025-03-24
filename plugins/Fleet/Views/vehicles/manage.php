<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="<?php echo get_uri('fleet/vehicle'); ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_vehicle')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <?php echo render_select('vehicle_type_id',$vehicle_types, array('id', 'name'),'vehicle_type'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_select('vehicle_group_id',$vehicle_groups, array('id', 'name'),'vehicle_group'); ?>
            </div>
            <div class="col-md-3">
              <?php 
                  $status = [
                     ['id' => 'active', 'name' => _l('active')],
                     ['id' => 'inactive', 'name' => _l('inactive')],
                     ['id' => 'in_shop', 'name' => _l('in_shop')],
                     ['id' => 'out_of_service', 'name' => _l('out_of_service')],
                     ['id' => 'sold', 'name' => _l('sold')],
                  ];
               ?>

              <?php echo render_select('status',$status, array('id', 'name'),'status'); ?>
            </div>
          </div>

          <table class="table table-vehicles scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('name'); ?></th>
                 <th><?php echo _l('year'); ?></th>
                  <th><?php echo _l('make'); ?></th>
                  <th><?php echo _l('model'); ?></th>
                 <th><?php echo _l('type'); ?></th>
                 <th><?php echo _l('group'); ?></th>
                 <th><?php echo _l('status'); ?></th>
              </tr>
           </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require 'plugins/Fleet/assets/js/vehicles/manage_js.php';?>
