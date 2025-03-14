<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="page-title clearfix">
          <h1><?php echo html_entity_decode($title); ?></h1>
          <div class="title-button-group">
              <a href="#" class="btn btn-default mbot15 add-new-benefit_and_penalty <?php if(!fleet_has_permission('fleet_can_create_benefit_and_penalty')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
          </div>
          </div>
        <div class="card-body">
          <div class="row general-form">
            <div class="col-md-3">
             <?php 
             $type = [
               ['id' => 'benefit', 'name' => _l('benefit')],
               ['id' => 'penalty', 'name' => _l('penalty')],
             ];
             echo render_select('_type', $type, array('id', 'name'), 'type');
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
          
          <table class="table table-benefit_and_penalty scroll-responsive">
           <thead>
              <tr>
                 <th><?php echo _l('id'); ?></th>
                 <th><?php echo _l('subject'); ?></th>
                 <th><?php echo _l('driver'); ?></th>
                 <th><?php echo _l('type'); ?></th>
                 <th><?php echo _l('date'); ?></th>
              </tr>
           </thead>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $arrAtt = array();
      $arrAtt['data-type']='currency';

      $formality = [
               ['id' => 'commend', 'name' => _l('commend')],
               ['id' => 'bonus_money', 'name' => _l('bonus_money')],
             ];

      $formality2 = [
               ['id' => 'remind', 'name' => _l('remind')],
               ['id' => 'indemnify', 'name' => _l('indemnify')],
             ];
?>
<div class="modal fade" id="benefit_and_penalty-modal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('benefit_and_penalty')?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php echo form_open_multipart(admin_url('fleet/add_benefit_and_penalty'),array('id'=>'benefit_and_penalty-form', 'class' => 'general-form'));?>
         <?php echo form_hidden('id'); ?>
         <div class="modal-body">
               <?php echo render_select('type', $type, array('id', 'name'), 'type', '', ['required' => true], [], '', '', false); ?>
                <?php echo render_input('subject', 'subject', '', 'text',['required' => true]) ?>
                <?php echo render_select('criteria_id',$criterias,array('id','name'),'criteria'); ?>
                <?php echo render_date_input('date','date', '', ['required' => true]); ?>
               <?php echo render_select('driver_id',$drivers, array('id', array('first_name', 'last_name')),'driver', '', ['required' => true]); ?>
               <div class="benefit_type">
                <?php echo render_select('benefit_formality', $formality, array('id', 'name'), 'formality', '', [], [], '', '', false); ?>
                  <div class="benefit_amount_div hide">
                   <?php echo render_input('reward', 'reward', '', 'text', $arrAtt) ?>
                  </div>
               </div>

               <div class="penalty_type hide">
                <?php echo render_select('penalty_formality', $formality2, array('id', 'name'), 'formality', '', [], [], '', '', false); ?>
                  <div class="penalty_amount_div hide row">
                     <div class="col-md-6">
                     <?php echo render_input('amount_of_damage', 'amount_of_damage', '', 'text', $arrAtt) ?>
                     </div>
                     <div class="col-md-6">
                     <?php echo render_input('amount_of_compensation', 'amount_of_compensation', '', 'text', $arrAtt) ?>
                     </div>
                  </div>
               </div>

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

<?php require 'plugins/Fleet/assets/js/benefit_and_penalty/manage_js.php'; ?>
