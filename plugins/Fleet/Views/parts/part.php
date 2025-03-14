<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
        <div class="row">
            <div class="col-md-3">
                <?php if (isset($part)) { ?>
                <h4 class="tw-text-lg tw-font-semibold tw-text-neutral-800 tw-mt-0">
                    <div class="tw-space-x-3 tw-flex tw-items-center">
                        <span class="tw-truncate">
                            #<?php echo new_html_entity_decode($part->id . ' ' . $title); ?>
                        </span>
                        <?php if (has_permission('fleet_part', '', 'delete') || is_admin()) { ?>
                        <div class="btn-group">
                            <a href="#" class="dropdown-toggle btn-link" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <?php if (has_permission('fleet_part', '', 'delete')) { ?>
                                    <a href="<?php echo admin_url('fleet/delete_part/' . $part->id); ?>"
                                        class="text-danger delete-text _delete p-2"><i class="fa fa-remove"></i>
                                        <?php echo _l('delete'); ?>
                                    </a>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </h4>
                <?php } ?>
            </div>
            <div class="clearfix"></div>

            <?php if (isset($part)) { ?>
            <div class="col-md-3">
                <?php echo view('Fleet\Views\parts/tabs'); ?>
            </div>
            <?php } ?>

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($part) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php if (isset($part)) { ?>
                        <?php echo form_hidden('isedit'); ?>
                        <?php echo form_hidden('partid', $part->id); ?>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <div>
                            <div class="tab-content">
                                <?php echo view('Fleet\Views/'.(isset($tab) ? $tab['view'] : 'parts/groups/details')); ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($group == 'details') { ?>
                    <div class="panel-footer text-right tw-space-x-1" id="profile-save-section">
                    <?php if ((isset($part) && fleet_has_permission('fleet_can_edit_part')) || (!isset($part) && fleet_has_permission('fleet_can_create_part'))) { ?>
                        <button class="btn btn-primary only-save part-form-submiter">
                            <?php echo _l('submit'); ?>
                        </button>
                    <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

</div>

<?php require 'plugins/Fleet/assets/js/parts/part_js.php';?>

