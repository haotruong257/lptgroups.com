<?php echo form_hidden('site_url', get_uri()); ?>
<div class="card">
    <div class="page-title clearfix">
        <h1><?php echo html_entity_decode($title); ?></h1>
        <div class="title-button-group">
          <a href="<?php echo admin_url('fleet/inspection_form') ?>" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_setting')){echo 'hide';} ?>"><i data-feather="plus-circle" class="icon-16"></i> <?php echo _l('add'); ?></a>
        </div>
    </div>
    <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php 
          $table_data = array(
            _l('id'),
            _l('name'),
            _l('addedfrom'),
            _l('datecreated'),
            );
          render_datatable($table_data,'inspection-forms');
        ?>
      </div>
    </div>
  </div>
</div>