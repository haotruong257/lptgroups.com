<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
           <div class="clearfix"></div>
                <a href="#" class="btn btn-default mbot15 add-new-drivers <?php if(!fleet_has_permission('fleet_can_create_driver')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
            </div>
          </div>
        <div class="card-body">
          <?php
            $table_data = array(
              _l('name'),
              _l('email'),
              _l('role'),
              _l('last_login'),
              _l('active'),
              );
            
            render_datatable($table_data,'drivers');
            ?>
        </div>
      </div>
</div>

<div class="modal fade" id="driver-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo _l('driver')?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php echo form_open_multipart(admin_url('fleet/driver'),array('id'=>'driver-form'));?>
      <div class="modal-body">
        <?php echo render_select('staff',$staffs, array('id', array('first_name', 'last_name')),'staff'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div>
<?php require 'plugins/Fleet/assets/js/drivers/manage_js.php';?>
