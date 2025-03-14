
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<?php if(is_admin() || hr_has_permission('hr_profile_can_create_organizational_chart')){ ?>
							<a href="#" onclick="new_department(); return false;" class=" mright5 btn btn-info pull-left display-block text-white"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo app_lang('hr_new_unit'); ?>
							</a>
						<?php } ?>
						<a href="#" onclick="view_department_chart(); return false;" class="mright5 btn btn-default pull-left display-block"><span data-feather="eye" class="icon-16"></span>
							<?php echo app_lang('hr_view_department_chart'); ?>
						</a>
					</div>
				</div>
				<div class="row ml2 mr5">
					<div  class="col-md-3 pull-right">
						<input type="text" id="dep_tree" name="dep_tree" class="selectpicker" placeholder="<?php echo app_lang('dropdown_non_selected_tex'); ?>" autocomplete="off">
						<input type="hidden" name="dept" id="dept"/>
					</div> 
				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						app_lang('hr_hr_id'),
						app_lang('hr_department_name'),
						app_lang('hr_parent_unit'),
						app_lang('hr_manager_unit'),
						"<i data-feather='menu' class='icon-16'></i>",
					),'departments'); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="department" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<span class="edit-title"><?php echo app_lang('hr_edit_unit'); ?></span>
					<span class="add-title"><?php echo app_lang('hr_new_unit'); ?></span>
				</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?php echo form_open(site_url('hr_profile/department')); ?>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div id="additional"></div>
						<!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
						<?php echo render_input1('title','unit_name', '', '', [], [], '', '', true); ?>
						<?php echo render_select1('manager_id', $list_staff,array('id', array('first_name', 'last_name')),'hr_manager_unit'); ?>
						<?php echo render_select1('parent_id',$list_department ,array('id','title'),'hr_parent_unit'); ?>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('hr_close'); ?></button>
				<button type="submit" class="btn btn-info text-white"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('submit'); ?></button>

			</div>
			<?php echo form_close(); ?>                 
		</div>
	</div>
</div>

<!-- view chart in sidebar start -->
<div class="modal fade" id="department_chart_view" tabindex="-1" role="dialog">
	<div class="modal-dialog organizational_chart_dialog  modal-lg app-modal-body mw100p">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<span class="edit-title"><?php echo app_lang('hr_organizational_chart'); ?></span>
				</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" id="dp_chart">
						<div id="department_chart"></div>
					</div>
				</div>
			</div>                 
		</div>
	</div>
</div>
<!-- view chart in sidebar end -->


<?php require 'plugins/Hr_profile/assets/js/organizational/organizational_js.php';?>
</body>
</html>
