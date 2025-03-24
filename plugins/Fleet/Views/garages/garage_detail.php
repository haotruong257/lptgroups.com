<div id="wrapper">
<div id="page-content" class="page-wrapper clearfix">
    <?php echo form_hidden('site_url', get_uri()); ?>
    <div class="card">
        <div class="card-body">
                <div class="row">
                    <h4 class="h4-color"><?php echo _l('general_infor'); ?></h4>
                    <hr class="hr-color">
                  </div>

                            <div class="col-md-7 panel-padding">
                              <table class="table border table-striped table-margintop">
                                  <tbody>
                                     <tr class="project-overview">
                                        <td class="bold"  width="30%"><?php echo _l('name'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->name) ; ?></td>
                                     </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('address'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->address) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('city'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->city) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('state'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->state) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('country'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->country) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('zip'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->zip) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('note'); ?></td>
                                        <td><?php echo new_html_entity_decode($garage->notes) ; ?></td>
                                     </tr>
                                    

                                    </tbody>
                              </table>

                          </div>
                            <ul data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                                <li><a role="presentation" data-bs-toggle="tab" href="javascript:void(0);" data-bs-target="#maintenance_team"><?php echo app_lang('maintenance_team'); ?></a></li>
                                <li><a role="presentation" data-bs-toggle="tab" href="javascript:void(0);" data-bs-target="#maintenances"><?php echo app_lang('maintenances'); ?></a></li>
                            </ul>
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade" id="maintenance_team">
                                <div class="page-title clearfix">
                                    <div class="title-button-group">
                                    <a href="#" class="btn btn-default mbot15 add-new-team <?php if(!fleet_has_permission('fleet_can_edit_garage')){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></a>
                                    </div>
                                    </div>
                                    <?php
                                    $table_data = array(
                                      _l('name'),
                                      _l('email'),
                                      _l('role'),
                                      _l('last_login'),
                                      _l('active'),
                                      );
                                  
                                    render_datatable($table_data,'maintenance-team');
                                    ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="maintenances">
                                    <table class="table table-maintenances scroll-responsive">
                                       <thead>
                                         <tr>
                                          <th>ID</th>
                                          <th><?php echo  _l('vehicle'); ?></th>
                                          <th><?php echo  _l('maintenance_type'); ?></th>
                                          <th><?php echo  _l('title'); ?></th>
                                          <th><?php echo  _l('start_date'); ?></th>
                                          <th><?php echo  _l('completion_date'); ?></th>
                                          <th><?php echo  _l('notes'); ?></th>
                                          <th><?php echo  _l('cost'); ?></th>
                                        </tr>
                                      </thead>
                                      <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="maintenance-team-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo _l('driver')?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php echo form_open_multipart(admin_url('fleet/add_maintenance_team'),array('id'=>'driver-form' , 'class' => 'general-form'));?>
      <div class="modal-body">
        <?php echo form_hidden('garage_id', $garage->id); ?>
        <?php echo render_select('staffid',$staffs, array('id', array('first_name', 'last_name')),'staff'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div>

<?php require 'plugins/Fleet/assets/js/garages/garage_detail_js.php';?>
