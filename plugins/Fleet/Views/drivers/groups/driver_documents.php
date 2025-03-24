<?php if(isset($driver)){ ?>
<div class="page-title clearfix">
    <h1><?php echo _l('driver_documents'); ?></h1>
    <div class="title-button-group">
        <a href="<?php echo admin_url('fleet/driver_document?driver_id='.$driver->id); ?>" class="btn btn-default mbot15 <?php if((!fleet_has_permission('fleet_can_edit_driver') && !fleet_has_permission('fleet_can_edit_vehicle')) || $driver->status != 'active'){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
    </div>
</div>

<div class="clearfix"></div>
<?php echo view('Fleet\Views\driver_documents/table_html'); ?>
<?php } ?>
