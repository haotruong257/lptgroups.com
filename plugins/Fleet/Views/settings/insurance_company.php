<?php echo form_hidden('site_url', get_uri()); ?>
<div class="card">
    <div class="page-title clearfix">
        <h1><?php echo html_entity_decode($title); ?></h1>
        <div class="title-button-group">
  <a href="#" class="btn btn-default add-new-insurance-company mbot15 <?php if(!fleet_has_permission('fleet_can_create_setting')){echo 'hide';} ?>"><i data-feather="plus-circle" class="icon-16"></i> <?php echo _l('add'); ?></a>
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
			render_datatable($table_data,'insurance-company');
		?>
	</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="modal fade" id="insurance-company-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo _l('insurance_company')?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php echo form_open_multipart(admin_url('fleet/insurance_company'),array('id'=>'insurance-company-form', 'class' => 'general-form'));?>
      <?php echo form_hidden('id'); ?>
      <div class="modal-body">
        <?php echo render_input('name','name', '','text', array('required' => true)); ?>
        <div class="row">
          <div class="col-md-12">
            <p class="bold"><?php echo _l('description'); ?></p>
            <?php echo render_textarea('description','','',array(),array(),'','tinymce'); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div>