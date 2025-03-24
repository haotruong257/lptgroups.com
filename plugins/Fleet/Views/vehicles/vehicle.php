<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
        <div class="row">
            <div class="col-md-3">
                <?php if (isset($vehicle)) { ?>
                <h4 class="tw-text-lg tw-font-semibold tw-text-neutral-800 tw-mt-0">
                    <div class="tw-space-x-3 tw-flex tw-items-center">
                        <span class="tw-truncate">
                            #<?php echo new_html_entity_decode($vehicle->id . ' ' . $title); ?>
                        </span>
                        <?php if (has_permission('fleet_vehicle', '', 'delete') || is_admin()) { ?>
                        <div class="btn-group">
                            <a href="#" class="dropdown-toggle btn-link" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <?php if (has_permission('fleet_vehicle', '', 'delete')) { ?>
                                    <a href="<?php echo admin_url('fleet/delete_vehicle/' . $vehicle->id); ?>"
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

            <?php if (isset($vehicle)) { ?>
            <div class="col-md-3">
               <?php  echo view('Fleet\Views\vehicles/tabs'); ?>
            </div>
            <?php } ?>

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($vehicle) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($vehicle)) { ?>
                        <?php echo form_hidden('isedit'); ?>
                        <?php echo form_hidden('vehicleid', $vehicle->id); ?>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <div>
                            <div class="tab-content">
                                <?php  echo view('Fleet\Views\vehicles/'.(isset($tab) ? $tab['view'] : 'groups/details')); ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($group == 'details' || $group == 'lifecycle' || $group == 'financial' || $group == 'specifications') { ?>
                    <div class="card-footer text-right tw-space-x-1" id="profile-save-section">
                    <?php if ((isset($vehicle) && fleet_has_permission('fleet_can_edit_vehicle')) || (!isset($vehicle) && fleet_has_permission('fleet_can_create_vehicle'))) { ?>
                        <button class="btn btn-info text-white vehicle-form-submiter"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
                    <?php } ?>

                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
</div>


<?php require 'plugins/Fleet/assets/js/vehicles/vehicle_js.php';?>

