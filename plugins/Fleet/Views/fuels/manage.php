<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-fuel <?php if(!fleet_has_permission('fleet_can_create_fuel')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
                <?php 
                $fuel_type = [
                  ['id' => 'compressed_natural_gas', 'name' => _l('compressed_natural_gas')],
                  ['id' => 'diesel', 'name' => _l('diesel')],
                  ['id' => 'gasoline', 'name' => _l('gasoline')],
                  ['id' => 'propane', 'name' => _l('propane')],
                ];
                echo render_select('_fuel_type', $fuel_type, array('id', 'name'), 'fuel_type');
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
          <table class="table table-fuel scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('vehicle'); ?></th>
                 <th><?php echo _l('date'); ?></th>
                 <th><?php echo _l('vendor'); ?></th>
                 <th><?php echo _l('odometer'); ?></th>
                 <th><?php echo _l('gallons'); ?></th>
                 <th><?php echo _l('price'); ?></th>
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
<div class="modal fade" id="fuel-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('fuel')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open(admin_url('fleet/add_fuel'),array('id'=>'fuel-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
        
         <div class="modal-body">
                <?php echo render_select('vehicle_id',$vehicles,array('id','name'),'vehicle', '', ['required' => true]); ?>
                <?php echo render_datetime_input('fuel_time','fuel_time', '', ['required' => true]); ?>
                <?php echo render_input('odometer', 'odometer', '', 'number') ?>
                <?php echo render_input('gallons', 'gallons', '', 'text', ['required' => true]) ?>
                <?php echo render_input('price', 'price', '', 'text', $arrAtt) ?>
                <?php echo render_select('fuel_type', $fuel_type, array('id', 'name'), 'fuel_type', '', ['required' => true]); ?>
                <?php echo render_select('vendor_id', $vendors, array('userid', 'company'), 'vendor'); ?>
                <?php echo render_input('reference', 'reference') ?>
                <?php echo render_textarea('notes','notes') ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>  
      </div>
   </div>
</div>
<div class="modal fade bulk_actions" id="fuel_bulk_actions" tabindex="-1" role="dialog" data-table=".table-fuel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <?php if(has_permission('fleet_fuel_history','','detele')){ ?>
               <div class="checkbox checkbox-danger">
                  <input type="checkbox" name="mass_delete" id="mass_delete">
                  <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
               </div>
            <?php } ?>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <a href="#" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></a>

      </div>
   </div>
   <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php require 'plugins/Fleet/assets/js/fuels/manage_js.php'; ?>
