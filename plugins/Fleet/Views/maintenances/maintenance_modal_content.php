       <input type="hidden" name="id">
       <div class="row">
        <div class="col-md-12">
          <?php if(isset($vehicle)){
            echo form_hidden('redirect', 'vehicle');
            echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', $vehicle->id, ['required' => true]);
          }else{
            echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', '', ['required' => true]);
          } ?>
        </div>
      </div>
      
       <?php echo render_select('garage_id', $garages, array('id', 'name'), 'garage', '', ['required' => true]); ?>

      <div class="row">
        <div class="col-md-12">
          <?php
          $maintenances = [
            ['id' => 'maintenance', 'maintenance_name' => _l('fe_maintenance')],
            ['id' => 'repair', 'maintenance_name' => _l('fe_repair')],
          ];
          echo render_select('maintenance_type', $maintenances, array('id', 'maintenance_name'), 'maintenance_type', '', ['required' => true]); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <?php echo render_input('title', 'maintenance_service_name', '', 'text', ['required' => true]); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?php echo render_date_input('start_date', 'start_date', '', ['required' => true]); ?>
        </div>
        <div class="col-md-6">
          <?php echo render_date_input('completion_date', 'completion_date'); ?>
        </div>
      </div>
       <?php echo render_select('parts[]', $parts, array('id', 'name'), 'parts','', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
     
      <div class="row">
        <div class="col-md-12">
         <div class="form-group">
          <label for="gst"><?php echo _l('fe_cost'); ?></label>            
          <div class="input-group">
            <input data-type="currency" class="form-control" name="cost" value="">
            <span class="input-group-addon p-2"><?php echo new_html_entity_decode($currency_name); ?></span>
          </div>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col-md-12">
      <?php echo render_textarea('notes','fe_notes') ?>
    </div>
  </div>