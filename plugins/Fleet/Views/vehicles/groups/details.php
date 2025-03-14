<?php if (isset($vehicle)) { ?>
<h4 class="customer-profile-group-heading"><?php echo _l('details'); ?></h4>
<?php } ?>

<?php echo form_open(get_uri('fleet/vehicle'.(isset($vehicle) ? '/'.$vehicle->id : '')), ['autocomplete' => 'off', 'class'=>'vehicle-form general-form', "role" => "form"]); ?>

<h4><?php echo _l('identification'); ?></h4>
<?php $value = (isset($vehicle) ? $vehicle->name : ''); ?>
<?php echo render_input('name','name', $value,'text', array('required' => true)); ?>

<?php $value = (isset($vehicle) ? $vehicle->vin : ''); ?>
<?php echo render_input('vin','vin', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->license_plate : ''); ?>
<?php echo render_input('license_plate','license_plate', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->vehicle_type_id : ''); ?>
<?php echo render_select('vehicle_type_id',$vehicle_types, array('id', 'name'),'vehicle_type',$value, array('required' => true)); ?>

<?php $value = (isset($vehicle) ? $vehicle->year : ''); ?>
<?php echo render_input('year','year', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->make : ''); ?>
<?php echo render_input('make','make', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->model : ''); ?>
<?php echo render_input('model','model', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->trim : ''); ?>
<?php echo render_input('trim','trim', $value); ?>

<?php $value = (isset($vehicle) ? $vehicle->registration_state : ''); ?>
<?php echo render_input('registration_state','registration_state', $value); ?>

<hr>
<h4><?php echo _l('classification'); ?></h4>
<?php 
    $status = [
       ['id' => 'active', 'name' => _l('active')],
       ['id' => 'inactive', 'name' => _l('inactive')],
       ['id' => 'in_shop', 'name' => _l('in_shop')],
       ['id' => 'out_of_service', 'name' => _l('out_of_service')],
       ['id' => 'sold', 'name' => _l('sold')],
    ];
 ?>

<?php $value = (isset($vehicle) ? $vehicle->status : ''); ?>
<?php echo render_select('status',$status, array('id', 'name'),'status',$value, array('required' => true)); ?>

<?php $value = (isset($vehicle) ? $vehicle->vehicle_group_id : ''); ?>
<?php echo render_select('vehicle_group_id',$vehicle_groups, array('id', 'name'),'vehicle_group',$value); ?>

<?php 
    $ownership = [
       ['id' => 'owner', 'name' => _l('owner')],
       ['id' => 'leased', 'name' => _l('leased')],
       ['id' => 'rented', 'name' => _l('rented')],
       ['id' => 'customer', 'name' => _l('customer')],
    ];
 ?>

<?php $value = (isset($vehicle) ? $vehicle->ownership : ''); ?>
<?php echo render_select('ownership',$ownership, array('id', 'name'),'ownership',$value, array('required' => true)); ?>
<hr>
<h4><?php echo _l('additional_details'); ?></h4>

<?php $value = (isset($vehicle) ? $vehicle->color : ''); ?>
<?php echo render_input('color','color', $value); ?>

<?php 
    $body_type = [
       ['id' => 'conventional', 'name' => _l('conventional')],
       ['id' => 'full_size', 'name' => _l('full_size')],
       ['id' => 'hatchback', 'name' => _l('hatchback')],
       ['id' => 'pickup', 'name' => _l('pickup')],
       ['id' => 'sedan', 'name' => _l('sedan')],
    ];
 ?>

<?php $value = (isset($vehicle) ? $vehicle->body_type : ''); ?>
<?php echo render_select('body_type', $body_type, array('id', 'name'), 'body_type',$value); ?>

<?php 
    $body_subtype = [
       ['id' => 'cargo', 'name' => _l('cargo')],
       ['id' => 'crew_cab', 'name' => _l('crew_cab')],
       ['id' => 'sleeper_cab', 'name' => _l('sleeper_cab')],
    ];
 ?>

<?php $value = (isset($vehicle) ? $vehicle->body_subtype : ''); ?>
<?php echo render_select('body_subtype', $body_subtype, array('id', 'name'),'body_subtype',$value); ?>
<i class="fa-regular fa-circle-question pull-left tw-mt-0.5 tw-mr-1" data-toggle="tooltip"
                            data-title="<?php echo _l('msrp_note'); ?>"></i>
<?php $value = (isset($vehicle) ? $vehicle->msrp : ''); ?>
<?php echo render_input('msrp','msrp', $value); ?>

<button group="submit" class="btn btn-info text-white vehicle-form-btn-submit hide"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
<?php echo form_close(); ?>

