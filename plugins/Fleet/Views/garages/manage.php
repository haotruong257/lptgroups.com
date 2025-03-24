<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
         <div class="clearfix"></div>
              <a href="#" onclick="add();" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_garage')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <table class="table table-garages scroll-responsive">
           <thead>
             <tr>
              <th>ID</th>
              <th><?php echo  _l('name'); ?></th>
              <th><?php echo  _l('address'); ?></th>
              <th><?php echo  _l('country'); ?></th>
              <th><?php echo  _l('city'); ?></th>
              <th><?php echo  _l('zip'); ?></th>
              <th><?php echo  _l('state'); ?></th>
              <th><?php echo  _l('notes'); ?></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

      </div>
  </div>
</div>

<div class="modal fade" id="add_new_garages" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
         <span class="add-title hide"><?php echo _l('create_garage'); ?></span>
         <span class="edit-title"><?php echo _l('edit_garage'); ?></span>
       </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <?php echo form_open(admin_url('fleet/garages'),array('id'=>'garages-form', 'class' => 'general-form')); ?>
     <div class="modal-body">
      <?php 
      echo view('Fleet\Views\garages/modal_content.php');
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

<input type="hidden" name="are_you_sure_you_want_to_delete_these_items" value="<?php echo _l('fe_are_you_sure_you_want_to_delete_these_items') ?>">
<input type="hidden" name="please_select_at_least_one_item_from_the_list" value="<?php echo _l('please_select_at_least_one_item_from_the_list') ?>">

<input type="hidden" name="check">
<?php require 'plugins/Fleet/assets/js/garages/manage_js.php';?>
