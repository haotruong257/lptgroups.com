<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(!isset($column)){
  $column = 'col-md-5ths';
}
?>
<div class="panel-group">
  <div class="panel panel-info">
   <div class="panel-heading"><?php echo app_lang('hr_logged_time'); ?></div>
   <div class="panel-body">
    <div class="staff_logged_time" data-toggle="tooltip" data-title="<?php echo app_lang('task_timesheets'); ?>" data-placement="left">
     <div class="<?php echo html_entity_decode($column); ?> col-sm-6 col-xs-12 total-column">
       <div class="panel_s">
        <div class="panel-body">
         <h3 class="text-muted _total">
           <?php echo seconds_to_time_format($logged_time['total']); ?>
         </h3>
         <span class="staff_logged_time_text text-success"><?php echo app_lang('hr_staff_stats_total_logged_time'); ?></span>
       </div>
     </div>
   </div>
   <div class="<?php echo html_entity_decode($column); ?> col-sm-6 col-xs-12 total-column">
     <div class="panel_s">
      <div class="panel-body">
       <h3 class="text-muted _total">
         <?php echo seconds_to_time_format($logged_time['last_month']); ?>
       </h3>
       <span class="staff_logged_time_text text-info"><?php echo app_lang('hr_staff_stats_last_month_total_logged_time'); ?></span>
     </div>
   </div>
 </div>
 <div class="<?php echo html_entity_decode($column); ?> col-sm-6 col-xs-12 total-column">
   <div class="panel_s">
    <div class="panel-body">
     <h3 class="text-muted _total">
      <?php echo seconds_to_time_format($logged_time['this_month']); ?>
    </h3>
    <span class="staff_logged_time_text text-success"><?php echo app_lang('hr_staff_stats_this_month_total_logged_time'); ?></span>
  </div>
</div>
</div>
<div class="<?php echo html_entity_decode($column); ?> col-sm-6 col-xs-12 total-column">
 <div class="panel_s">
  <div class="panel-body">
   <h3 class="text-muted _total">
     <?php echo seconds_to_time_format($logged_time['last_week']); ?>
   </h3>
   <span class="staff_logged_time_text text-info"><?php echo app_lang('hr_staff_stats_last_week_total_logged_time'); ?></span>
 </div>
</div>
</div>
<div class="<?php echo html_entity_decode($column); ?> col-sm-6 col-xs-12 total-column">
 <div class="panel_s">
  <div class="panel-body">
   <h3 class="text-muted _total">
     <?php echo seconds_to_time_format($logged_time['this_week']); ?>
   </h3>
   <span class="staff_logged_time_text text-success"><?php echo app_lang('hr_staff_stats_this_week_total_logged_time'); ?></span>
 </div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
