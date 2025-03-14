<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#"  onclick="add_inspections();" class="btn btn-default mbot15 <?php if(!fleet_has_permission('fleet_can_create_inspection')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
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
      <div class="clearfix"></div>
      <table class="table table-inspections scroll-responsive">
       <thead>
         <tr>
          <th><?php echo  _l('vehicle_name'); ?></th>
          <th><?php echo  _l('inspection_form'); ?></th>
          <th><?php echo  _l('addedfrom'); ?></th>
          <th><?php echo  _l('datecreated'); ?></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

  </div>
</div>
</div>
</div>

<div class="modal fade" id="add_new_inspections" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
         <span class="add-title hide"><?php echo _l('inspections'); ?></span>
         <span class="edit-title"><?php echo _l('inspections'); ?></span>
       </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <?php echo form_open(admin_url('fleet/add_inspection'),array('id'=>'inspections-form')); ?>
     <div class="modal-body">
      <?php 
        echo form_hidden('id');
        echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', '', ['required' => true]);
        echo render_select('inspection_form_id', $inspection_forms, array('id', 'name'), 'inspection_form', '', ['required' => true]);
      ?>
      <div class="inspection-form-content">
        
      </div>
    </div>
    <div class="modal-footer">
       <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
    </div>
    <?php echo form_close(); ?>                 
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
