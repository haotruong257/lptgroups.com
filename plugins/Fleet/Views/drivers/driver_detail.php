<div id="page-content" class="page-wrapper clearfix">
<?php echo form_hidden('site_url', get_uri()); ?>

        <div class="row">
            <div class="col-md-3">
                <?php if (isset($driver)) { 
                    ?>
                <h4 class="tw-text-lg tw-font-semibold tw-text-neutral-800 tw-mt-0">
                    <div class="tw-space-x-3 tw-flex tw-items-center">
                        <span class="tw-truncate">
                            #<?php echo new_html_entity_decode($driver->id . ' ' . $title); ?>
                        </span>
                    </div>
                </h4>
                <?php } ?>
            </div>
            <div class="clearfix"></div>

            <?php if (isset($driver)) { ?>
            <div class="col-md-3">
                <?php echo view('Fleet\Views\drivers/tabs'); ?>
            </div>
            <?php } ?>

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($driver) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php if (isset($driver)) { ?>
                        <?php echo form_hidden('isedit'); ?>
                        <?php echo form_hidden('driverid', $driver->id); ?>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <div>
                            <div class="tab-content">
                                <?php echo view('Fleet\Views/'. (isset($tab) ? $tabs['view'] : 'drivers/groups/general')); ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($group == 'profile') { ?>
                    <div class="panel-footer text-right tw-space-x-1" id="profile-save-section">
                        <?php if (!isset($driver)) { ?>
                        <button class="btn btn-default save-and-add-contact customer-form-submiter">
                            <?php echo _l('save_customer_and_add_contact'); ?>
                        </button>
                        <?php } ?>
                        <button class="btn btn-primary only-save customer-form-submiter">
                            <?php echo _l('submit'); ?>
                        </button>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

</div>

<?php require 'plugins/Fleet/assets/js/drivers/driver_js.php';?>
