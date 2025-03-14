<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" onclick="add_maintenances(); return false;" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_maintenance')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
        <div class="col-md-3">
          <?php 
          $maintenances = [
            ['id' => 'maintenance', 'maintenance_name' => _l('maintenance')],
            ['id' => 'repair', 'maintenance_name' => _l('repair')],
          ];
          echo render_select('maintenance_type_filter', $maintenances, array('id', 'maintenance_name'), 'maintenance_type');
          ?>
        </div>

        <div class="col-md-3">
          <?php echo render_date_input('from_date_filter', 'from_date'); ?>
        </div>

        <div class="col-md-3">
          <?php echo render_date_input('to_date_filter', 'to_date'); ?>
        </div>
        <div class="col-md-3"></div>
      </div>

      <div class="clearfix"></div>
      <br>
      <table class="table table-maintenances scroll-responsive">
       <thead>
         <tr>
          <th>ID</th>
          <th><?php echo  _l('vehicle'); ?></th>
          <th><?php echo  _l('maintenance_type'); ?></th>
          <th><?php echo  _l('title'); ?></th>
          <th><?php echo  _l('start_date'); ?></th>
          <th><?php echo  _l('completion_date'); ?></th>
          <th><?php echo  _l('notes'); ?></th>
          <th><?php echo  _l('cost'); ?></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

  </div>
</div>
</div>
</div>

<div class="modal fade" id="add_new_maintenances" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
         <span class="add-title hide"><?php echo _l('maintenance'); ?></span>
         <span class="edit-title"><?php echo _l('maintenance'); ?></span>
       </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <?php echo form_open(admin_url('fleet/add_maintenance'),array('id'=>'maintenances-form', 'class'=>'general-form')); ?>
     <div class="modal-body">
      <?php 
      echo view('Fleet\Views/maintenances/maintenance_modal_content.php');
      ?>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
    </div>
    <?php echo form_close(); ?>                 
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<input type="hidden" name="are_you_sure_you_want_to_delete_these_items" value="<?php echo _l('are_you_sure_you_want_to_delete_these_items') ?>">
<input type="hidden" name="please_select_at_least_one_item_from_the_list" value="<?php echo _l('please_select_at_least_one_item_from_the_list') ?>">

<input type="hidden" name="check">
<?php require 'plugins/Fleet/assets/js/maintenances/manage_js.php';?>
