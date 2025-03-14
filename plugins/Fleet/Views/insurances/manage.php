<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-insurance <?php if(!fleet_has_permission('fleet_can_create_insurance')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
              <?php echo render_date_input('from_date','from_date'); ?>
            </div>
            <div class="col-md-3">
              <?php echo render_date_input('to_date','to_date'); ?>
            </div>
          </div>
          <hr>
          <table class="table table-fuel scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('name'); ?></th>
                 <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('insurance_company'); ?></th>
                 <th><?php echo _l('status'); ?></th>
                 <th><?php echo _l('start_date'); ?></th>
                 <th><?php echo _l('end_date'); ?></th>
                 <th><?php echo _l('amount'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
<?php $arrAtt = array();
      $arrAtt['data-type']='currency';
      $arrAtt['required']=true;
?>
<div class="modal fade" id="insurance-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('insurance')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/insurance'),array('id'=>'insurance-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
       
         <div class="modal-body">
                <?php echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', '', ['required' => true]); ?>
                <?php echo render_input('name', 'name', '', 'text', ['required' => true]); ?>
                <?php echo render_select('insurance_company_id', $insurance_company, array('id', 'name'), 'insurance_company', '', ['required' => true]); ?>
                <?php echo render_select('insurance_status_id', $insurance_status, array('id', 'name'), 'insurance_status', '', ['required' => true]); ?>
                <?php echo render_select('insurance_category_id', $insurance_categorys, array('id', 'name'), 'insurance_category'); ?>
                <?php echo render_select('insurance_type_id', $insurance_types, array('id', 'name'), 'insurance_type'); ?>
                <div class="row">
                   <div class="col-md-6">
                     <?php echo render_date_input('start_date', 'start_date', '', ['required' => true]); ?>
                   </div>
                   <div class="col-md-6">
                     <?php echo render_date_input('end_date', 'end_date', '', ['required' => true]); ?>
                   </div>
                </div>
                <?php echo render_input('amount', 'amount', '', 'text', $arrAtt); ?>
                <?php echo render_textarea('description','description'); ?>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>
<?php require 'plugins/Fleet/assets/js/insurances/manage_js.php'; ?>
