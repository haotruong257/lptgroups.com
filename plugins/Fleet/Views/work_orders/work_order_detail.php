<?php

if(fleet_has_permission('fleet_can_edit_work_orders')){
$status = fleet_render_status_html($work_order->id, 'work_order', $work_order->status, true);   
}else{
$status = fleet_render_status_html($work_order->id, 'work_order', $work_order->status, false);   
} 

?>
<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
   <div class="row">
    <div class="col-md-12">
      <div class="panel_s accounting-template estimate">
        <div class="panel-body">
          <div class="row">
              <div class="invoice accounting-template">
                <div class="col-md-12 fr1">
                <div class="col-12">
                    <a href="<?php echo admin_url('fleet/work_orders'); ?>" class="btn btn-default pull-right"><?php echo _l('close'); ?></a>
                    <?php if(!$work_order->expense_id > 0){ ?>
                      <a href="#"  onclick="create_expense(<?php echo new_html_entity_decode($work_order->id); ?>); return false;" id="btn-create-expense" class="btn btn-success pull-right mright10 <?php if(!fleet_has_permission('fleet_can_edit_work_orders')){echo 'hide';} ?>"><?php echo _l('create_expense'); ?></a>
                  <?php }else{ ?>
                    <a href="<?php echo admin_url('expenses#'.$work_order->expense_id); ?>" class="btn pull-right"><?php echo _l('view_expense'); ?></a>
                  <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-md-12">
                <hr>  
              </div>  
        </div> 
            <h4 class="h4-color"><?php echo _l('general_info'); ?></h4>
            <hr class="hr-color">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-striped  no-margin">
                    <tbody>
                    <?php echo form_hidden('_work_order_id', $work_order->id); ?>

                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('work_order_number'); ?></td>
                          <td><?php echo new_html_entity_decode($work_order->number) ; ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('status'); ?></td>
                          <td><?php echo new_html_entity_decode($status); ?></td>
                       </tr>
                        <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('issue_date'); ?></td>
                          <td><?php echo _d($work_order->issue_date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('start_date'); ?></td>
                          <td><?php echo _d($work_order->start_date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('complete_date'); ?></td>
                          <td><?php echo _d($work_order->complete_date) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('work_requested'); ?></td>
                          <td><?php echo new_html_entity_decode($work_order->work_requested) ; ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-striped no-margin">
                    <tbody>
                      <tr class="project-overview">
                          <td class="bold" width="30%"><?php echo _l('customer'); ?></td>
                          <td><a href="<?php echo admin_url('purchase/vendor/'.$work_order->vendor_id) ?>"><?php echo get_vendor_company_name($work_order->vendor_id); ?></a></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('work_order_price'); ?></td>
                          <td><?php echo to_currency($work_order->total, $currency) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('odometer_in'); ?></td>
                          <td><?php echo new_html_entity_decode($work_order->odometer_in) ; ?></td>
                       </tr>
                       <tr class="project-overview">
                          <td class="bold"><?php echo _l('odometer_out'); ?></td>
                          <td><?php echo new_html_entity_decode($work_order->odometer_out) ; ?></td>
                       </tr>
                      </tbody>
                </table>
              </div>
            </div>
            
            <div class="row mtop25">
            <div class="col-md-4">
                <div class="panel_s">
                  <div class="panel-heading">
                    <h4><?php echo _l('parts'); ?></h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-striped  no-margin">
                      <tbody>
                        <?php 
                        if($work_order->parts != null){
                          foreach(explode(',', $work_order->parts) as $part){ 
                              $part_name = fleet_get_part_name_by_id($part);

                            ?>
                            <tr class="project-overview">
                              <td width="30%"><a href="<?php echo site_url('fleet/part/' . $part); ?>" class="invoice-number"><?php echo new_html_entity_decode($part_name); ?></a></td>
                           </tr>
                          <?php } ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              </div>
 
  </div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="chosse" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="add-title"><?php echo _l('please_let_us_know_the_reason_for_canceling_the_order') ?></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <?php echo render_textarea('cancel_reason','cancel_reason',''); ?>
        </div>
      </div>
      <div class="clearfix">               
        <br>
        <br>
        <div class="clearfix">               
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          <button type="button" data-status="8" class="btn btn-danger cancell_order"><?php echo _l('cancell'); ?></button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div><!-- /.modal -->


<?php require 'plugins/Fleet/assets/js/work_performances/logbook_manage_js.php'; ?>