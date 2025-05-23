	<div class="page-title clearfix">
	    <h1><?php echo _l('hr_hr_company_training'); ?></h1>
	</div>

	<table class="table dt-table" >
		<thead>
			<th class="sorting_disabled hide"><?php echo _l('ID'); ?></th>
			<th class="sorting_disabled"><?php echo _l('name'); ?></th>
			<th class="sorting_disabled"><?php echo _l('hr_training_result'); ?></th>
			<th class="sorting_disabled"><?php echo _l('hr_status_label'); ?></th>
		</thead>
		<tbody>
			<?php $index = 1;?>
			<?php if (isset($training_data)) {
	?>
				<?php foreach ($training_data as $key => $value) {?>

				<tr>
					<td class="hide"><b><?php echo new_html_entity_decode($index); ?></b></td>
					<td><b><?php echo new_html_entity_decode(isset($value['list_training_allocation']['training_name']) ? $value['list_training_allocation']['training_name'] : ''); ?></b></td>

					<td>
						<?php
echo get_type_of_training_by_id(isset($value['list_training_allocation']['training_type']) ? $value['list_training_allocation']['training_type'] : '');

		echo ': ' . new_html_entity_decode(isset($value['training_program_point']) ? $value['training_program_point'] : '') . '/' . new_html_entity_decode(isset($value['training_allocation_min_point']) ? $value['training_allocation_min_point'] : '');
		?>
					</td>
					<td>
						<?php
if (isset($value['complete']) && $value['complete'] == 0) {
			echo ' <span class="label label-success "> ' . _l('hr_complete') . ' </span>';
		} else {
			echo ' <span class="label label-primary"> ' . _l('hr_not_yet_complete') . ' </span>';
		}
		?>
					</td>
				</tr>
				<?php $index++;?>

				<?php if (isset($value['staff_training_result'])) {
			?>
				<?php foreach ($value['staff_training_result'] as $r_key => $r_value) {?>
					<tr>
						<td class="hide"><b><?php echo new_html_entity_decode($index); ?></b></td>
						<td>

							<?php if (isset($value['list_training_allocation']['time_to_start']) || isset($value['list_training_allocation']['time_to_end'])) {?>

								<?php
$current_date = date('Y-m-d');

				if ($value['list_training_allocation']['time_to_start'] != null && $value['list_training_allocation']['time_to_end'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($value['list_training_allocation']['time_to_start']) && strtotime(date('Y-m-d')) <= strtotime($value['list_training_allocation']['time_to_end'])) {

						$show_training = true;

					} else {
						$show_training = false;
					}
				} elseif ($value['list_training_allocation']['time_to_start'] != null) {
					if (strtotime(date('Y-m-d')) >= strtotime($value['list_training_allocation']['time_to_start'])) {

						$show_training = true;

					} else {
						$show_training = false;
					}

				} elseif ($value['list_training_allocation']['time_to_end'] != null) {
					if (strtotime(date('Y-m-d')) <= strtotime($value['list_training_allocation']['time_to_end'])) {

						$show_training = true;

					} else {
						$show_training = false;
					}
				} else {
					$show_training = true;
				}

				?>

								<?php if ($show_training == true) {?>
									<a href="<?php echo admin_url('hr_profile/participate/index/' . $r_value['training_id'] . '/' . hr_get_training_hash($r_value['training_id'])); ?>"><?php echo '&nbsp;&nbsp;&nbsp;+' . new_html_entity_decode($r_value['training_name']); ?></a>
								<?php } else {?>
									<a href="#" class="text-danger" title="<?php echo _l('training_over_due'); ?>"><?php echo '&nbsp;&nbsp;&nbsp;+' . new_html_entity_decode($r_value['training_name']); ?></a>

								<?php }?>

							<?php } else {?>
								<a href="<?php echo admin_url('hr_profile/participate/index/' . $r_value['training_id'] . '/' . hr_get_training_hash($r_value['training_id'])); ?>"><?php echo '&nbsp;&nbsp;&nbsp;+' . new_html_entity_decode($r_value['training_name']); ?></a>

							<?php }?>
						</td>
						<td>
							<?php echo _l('hr_point') . ': ' . new_html_entity_decode($r_value['total_point']) . '/' . new_html_entity_decode($r_value['total_question_point']); ?>

						</td>
						<td></td>

					</tr>
					<?php $index++;?>

			<?php }}}?>

		<?php }?>

		</tbody>
	</table>

	<div class="page-title clearfix">
	    <h1><?php echo _l('hr_hr_more_training'); ?></h1>
	    <div class="title-button-group">
	        <a href="#" onclick="create_trainings();" class="btn btn-default mbot15<?php if($driver->status != 'active'){echo 'hide';} ?>"><span data-feather="plus-circle" class="icon-16"></span> <?php echo app_lang('hr_more_training_sessions'); ?></a>
	    </div>
	</div>
		<?php
$table_data = array(
	_l('hr_training_programs_name'),
	_l('hr_hr_training_places'),
	_l('hr_time_to_start'),
	_l('hr_time_to_end'),
	_l('hr_training_result'),
	_l('hr_degree'),
	_l('hr_notes'),
);
render_datatable($table_data, 'table_education', array(), array('data-page-length' => '10'));
?>

	<div class="modal fade" id="education_sidebar" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">
						<span class="edit-title-training"><?php echo _l('hr_update_training_sessions'); ?></span>
						<span class="add-title-training"><?php echo _l('hr_more_training_sessions'); ?></span>
					</h4>
        			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<?php echo form_open_multipart(admin_url('fleet/save_update_education'), array('class' => 'save_update_education general-form')); ?>
				<div class="modal-body">
					<input type="hidden" name="id" value="">
					<input type="hidden" name="staff_id" value="<?php echo new_html_entity_decode($member->id); ?>">
					<div class="row">
						<div class="col-md-12">
							<?php echo render_input('training_programs_name', 'hr_training_programs_name', '', 'text', ['required' => true]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php echo render_input('training_places', 'hr_hr_training_places', '', 'text', ['required' => true]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 pl-0">
							<?php echo render_datetime_input('training_time_from', 'hr_time_to_start', '', ['required' => true]); ?>
						</div>
						<div class="col-md-6 pr-0">
							<?php echo render_datetime_input('training_time_to', 'hr_time_to_end', '', ['required' => true]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php echo render_textarea('training_result', 'hr_training_result', '', array(), array(), '', 'tinymce'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php echo render_input('degree', 'hr_degree', '', 'text'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php
								echo render_textarea('notes', 'hr_notes', '');
								?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
      				<button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

