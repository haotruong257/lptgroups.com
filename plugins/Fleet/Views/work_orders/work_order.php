<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          
          </div>
        <div class="card-body">

        <?php $arrAtt = array();
      $arrAtt['data-type']='currency';
?>
         <?php echo form_open_multipart(get_uri('fleet/work_order'.(isset($work_order) ? '/'.$work_order->id : '')),array('id'=>'work-order-form', 'class' => 'general-form')) ;?>
            <div class="row">
               
            <div class="col-md-6">
               <?php $value = (isset($work_order) ? $work_order->vehicle_id : ''); ?>
                <?php echo render_select('vehicle_id', $vehicles, array('id', 'name'), 'vehicle', $value, ['required' => true]); ?>

               <?php $value = (isset($work_order) ? $work_order->issue_date : ''); ?>
               <?php echo render_date_input('issue_date', 'issue_date', $value, ['required' => true]); ?>

               <?php $value = (isset($work_order) ? $work_order->start_date : ''); ?>
               <?php echo render_date_input('start_date', 'start_date', $value); ?>

               <?php $value = (isset($work_order) ? $work_order->complete_date : ''); ?>
               <?php echo render_date_input('complete_date', 'complete_date', $value); ?>

               <?php 
                  $statuss = [
                     ['id' => 'open', 'name' => _l('open')],
                     ['id' => 'in_progress', 'name' => _l('in_progress')],
                     ['id' => 'parts_ordered', 'name' => _l('parts_ordered')],
                     ['id' => 'complete', 'name' => _l('complete')],
                  ];
               ?>

               <?php $value = (isset($work_order) ? $work_order->status : ''); ?>
               <?php echo render_select('status',$statuss, array('id', 'name'),'status',$value, ['required' => true]); ?>

               <?php $value = (isset($work_order) ? explode(',',$work_order->parts) : ''); ?>
               <?php echo render_select('parts[]', $parts, array('id', 'name'), 'parts',$value, array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
            </div>
            <div class="col-md-6">
              <?php $value = (isset($work_order) ? $work_order->vendor_id : ''); ?>
                <?php echo render_select('vendor_id', $vendors, array('userid', 'company'), 'vendor', $value, ['required' => true]); ?>

                <?php $value = (isset($work_order) ? $work_order->total : ''); ?>
                <?php echo render_input('total', 'work_order_price', $value, 'text', array_merge($arrAtt, ['required' => true])); ?>
                <div class="row">
                  <div class="col-md-6">
                    <?php $value = (isset($work_order) ? $work_order->odometer_in : ''); ?>
                    <?php echo render_input('odometer_in', 'odometer_in', $value, 'text', $arrAtt); ?>
                  </div>
                  <div class="col-md-6">
                    <?php $value = (isset($work_order) ? $work_order->odometer_out : ''); ?>
                    <?php echo render_input('odometer_out', 'odometer_out', $value, 'text', $arrAtt); ?>
                  </div>
                </div>
                <?php $work_requested = (isset($work_order) ? $work_order->work_requested : ''); ?>
               <?php echo render_textarea('work_requested', 'work_requested', $work_requested); ?>
            </div>
         </div>
         <div class="row text-right">
            <hr>
                <div class="title-button-group">
                     <a href="<?php echo admin_url('fleet/work_orders'); ?>" class="btn btn-default"><i data-feather="x" class="icon-16"></i> <?php echo _l('back'); ?></a>
                     <button type="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
                </div>
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>
