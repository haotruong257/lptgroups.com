<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="<?php echo admin_url('fleet/part'); ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_part')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
              <?php echo render_select('type',$part_types, array('id', 'name'),'part_type'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_select('group',$part_groups, array('id', 'name'),'part_group'); ?>
            </div>
            <div class="col-md-3">
              <?php 
                  $status = [
                     ['id' => 'in_service', 'name' => _l('in_service')],
                     ['id' => 'out_of_service', 'name' => _l('out_of_service')],
                     ['id' => 'disposed', 'name' => _l('disposed')],
                     ['id' => 'missing', 'name' => _l('missing')],
                  ];
               ?>
              <?php echo render_select('status', $status, array('id', 'name'), 'status'); ?>
            </div>
          </div>
          <hr>
          <table class="table table-parts scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('part_name'); ?></th>
                 <th><?php echo _l('type'); ?></th>
                 <th><?php echo _l('brand'); ?></th>
                 <th><?php echo _l('model'); ?></th>
                 <th><?php echo _l('serial_number'); ?></th>
                 <th><?php echo _l('group'); ?></th>
                 <th><?php echo _l('status'); ?></th>
                 <th><?php echo _l('current_assignee'); ?></th>
                 <th><?php echo _l('linked_vehicle'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>

<?php require 'plugins/Fleet/assets/js/parts/manage_js.php'; ?>
