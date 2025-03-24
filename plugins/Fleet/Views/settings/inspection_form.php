<div id="page-content" class="page-wrapper clearfix">
<?php echo form_hidden('site_url', get_uri()); ?>
<div class="row">
	<div class="col-md-5" id="training-add-edit-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<?php echo form_open(get_uri('fleet/inspection_form'.(isset($inspection_form) ? '/'.$inspection_form->id : '')), array('id'=>'inspection-form', 'class' => 'general-form')); ?>
					<div class="panel-body">
						<h4 class="no-margin">
							<?php echo new_html_entity_decode($title); ?>
						</h4>
						<hr class="hr-panel-heading" />
						<?php $value = (isset($inspection_form) ? $inspection_form->name : ''); ?>
						<?php $attrs = (isset($inspection_form) ? array() : array('autofocus'=>true)); ?>
						<?php echo render_input('name','name',$value,'text',$attrs); ?>
						<?php $value = (isset($inspection_form) ? $inspection_form->color : ''); ?>
      					<?php echo render_color_picker('color',_l('color'),$value); ?>

		               		<div class="row">
		               		<div class="col-md-12">
	                            <div class="form-group select-placeholder">
	                                <label for="recurring" class="control-label">
	                                    <?php echo _l('set_schedule'); ?>
	                                </label>
	                                <select class="select2 validate-hidden" data-width="100%" name="recurring"
	                                    data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" <?php
	                        // The problem is that this invoice was generated from previous recurring invoice
	                        // Then this new invoice you set it as recurring but the next invoice date was still taken from the previous invoice.
	                        if (isset($inspection_form) && !empty($inspection_form->is_recurring_from)) {
	                            echo 'disabled';
	                        } ?>>
	                                    <?php for ($i = 0; $i <= 12; $i++) { ?>
	                                    <?php
	                              $selected = '';
	                              if (isset($inspection_form)) {
	                                  if ($inspection_form->custom_recurring == 0) {
	                                      if ($inspection_form->recurring == $i) {
	                                          $selected = 'selected';
	                                      }
	                                  }
	                              }
	                              if ($i == 0) {
	                                  $reccuring_string = _l('invoice_add_edit_recurring_no');
	                              } elseif ($i == 1) {
	                                  $reccuring_string = sprintf(_l('invoice_add_edit_recurring_month'), $i);
	                              } else {
	                                  $reccuring_string = sprintf(_l('invoice_add_edit_recurring_months'), $i);
	                              }
	                              ?>
	                                    <option value="<?php echo new_html_entity_decode($i); ?>" <?php echo new_html_entity_decode($selected); ?>>
	                                        <?php echo new_html_entity_decode($reccuring_string); ?></option>
	                                    <?php } ?>
	                                    <option value="custom" <?php if (isset($inspection_form) && $inspection_form->recurring != 0 && $inspection_form->custom_recurring == 1) {
	                                  echo 'selected';
	                              } ?>><?php echo _l('recurring_custom'); ?></option>
	                                </select>
	                            </div>
	                        </div>
	                        	<div class="row recurring_custom <?php if ((isset($inspection_form) && $inspection_form->custom_recurring != 1) || (!isset($inspection_form))) {
                          echo 'hide';
                      } ?>">
                    <div class="col-md-6">
                        <?php $value = (isset($inspection_form) && $inspection_form->custom_recurring == 1 ? $inspection_form->recurring : 1); ?>
                        <?php echo render_input('repeat_every_custom', '', $value, 'number', ['min' => 1]); ?>
                    </div>
                    <div class="col-md-6">
                        <select name="repeat_type_custom" id="repeat_type_custom" class="select2 validate-hidden"
                            data-width="100%"
                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                            <option value="day" <?php if (isset($inspection_form) && $inspection_form->custom_recurring == 1 && $inspection_form->recurring_type == 'day') {
                          echo 'selected';
                      } ?>><?php echo _l('invoice_recurring_days'); ?></option>
                            <option value="week" <?php if (isset($inspection_form) && $inspection_form->custom_recurring == 1 && $inspection_form->recurring_type == 'week') {
                          echo 'selected';
                      } ?>><?php echo _l('invoice_recurring_weeks'); ?></option>
                            <option value="month" <?php if (isset($inspection_form) && $inspection_form->custom_recurring == 1 && $inspection_form->recurring_type == 'month') {
                          echo 'selected';
                      } ?>><?php echo _l('invoice_recurring_months'); ?></option>
                            <option value="year" <?php if (isset($inspection_form) && $inspection_form->custom_recurring == 1 && $inspection_form->recurring_type == 'year') {
                          echo 'selected';
                      } ?>><?php echo _l('invoice_recurring_years'); ?></option>
                        </select>
                    </div>
                </div>
                <div id="cycles_wrapper" class="<?php if (!isset($inspection_form) || (isset($inspection_form) && $inspection_form->recurring == 0)) {
                          echo ' hide';
                      }?>">
                    <div class="col-md-12">
                        <?php $value = (isset($inspection_form) ? $inspection_form->cycles : 0); ?>
                        <div class="form-group recurring-cycles">
                            <label for="cycles"><?php echo _l('recurring_total_cycles'); ?>
                                <?php if (isset($inspection_form) && $inspection_form->total_cycles > 0) {
                          echo '<small>' . _l('cycles_passed', $inspection_form->total_cycles) . '</small>';
                      }
                    ?>
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" <?php if ($value == 0) {
                        echo ' disabled';
                    } ?> name="cycles" id="cycles" value="<?php echo new_html_entity_decode($value); ?>" <?php if (isset($inspection_form) && $inspection_form->total_cycles > 0) {
                        echo 'min="' . ($inspection_form->total_cycles) . '"';
                    } ?>>
                                <div class="input-group-addon pt-2 ps-2 pe-2">
                                    <div class="checkbox">
                                        <input type="checkbox" <?php if ($value == 0) {
                        echo ' checked';
                    } ?> id="unlimited_cycles">
                                        <label
                                            for="unlimited_cycles"><?php echo _l('cycles_infinity'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
	                        </div>

						<?php $value = (isset($inspection_form) ? $inspection_form->description : ''); ?>
						<?php echo render_textarea('description','description',$value); ?>
						<div class="modal-footer">
							<a href="<?php echo admin_url('fleet/settings?group=inspection_forms'); ?>"  class="btn btn-default pull-right mright5 "><i data-feather="x" class="icon-16"></i> <?php echo _l('close'); ?></a>
					        <button group="submit" class="btn btn-info text-white"><i data-feather="check-circle" class="icon-16"></i> <?php echo _l('submit'); ?></button>
					      </div>               
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>

		</div>
	</div>
	<div class="col-md-7" id="training_questions_wrapper">
		<div class="panel_s">
			<div class="panel-body">
			<?php if(isset($inspection_form)){ ?>
				<ul class="nav nav-tabs tabs-in-body-no-margin" role="tablist">
					<li role="presentation" class="active">
						<a href="#survey_questions_tab" aria-controls="survey_questions_tab" role="tab" data-toggle="tab">
							<?php echo _l('items'); ?>
						</a>
					</li>
					<li class="toggle_view">
						<a href="#" onclick="training_toggle_full_view(); return false;" data-toggle="tooltip" data-title="<?php echo _l('toggle_full_view'); ?>">
							<i class="fa fa-expand"></i></a>
						</li>

					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="survey_questions_tab" >
							<div class="row mt-3">
								<div class="_buttons">
									<?php if(has_permission('fleet_setting','','edit') || has_permission('fleet_setting','','create')){ ?>
										<div class="btn-group pull-right">
											<button type="button" class="btn btn-info dropdown-toggle text-white " data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php echo _l('insert_field'); ?> <span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
												<li class="p-2">
				                                    <a href="#"
				                                        onclick="add_inspection_question('pass_fail',<?php echo new_html_entity_decode($inspection_form->id); ?>);return false;">
				                                        <?php echo _l('pass_fail'); ?></a>
				                                </li>
												<li class="p-2">
				                                    <a href="#"
				                                        onclick="add_inspection_question('checkbox',<?php echo new_html_entity_decode($inspection_form->id); ?>);return false;">
				                                        <?php echo _l('survey_field_checkbox'); ?></a>
				                                </li>
				                                <li class="p-2">
				                                    <a href="#"
				                                        onclick="add_inspection_question('radio',<?php echo new_html_entity_decode($inspection_form->id); ?>);return false;">
				                                        <?php echo _l('survey_field_radio'); ?></a>
				                                </li>
				                                <li class="p-2">
				                                    <a href="#"
				                                        onclick="add_inspection_question('input',<?php echo new_html_entity_decode($inspection_form->id); ?>);return false;">
				                                        <?php echo _l('survey_field_input'); ?></a>
				                                </li>
				                                <li class="p-2">
				                                    <a href="#"
				                                        onclick="add_inspection_question('textarea',<?php echo new_html_entity_decode($inspection_form->id); ?>);return false;">
				                                        <?php echo _l('survey_field_textarea'); ?></a>
				                                </li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="clearfix"></div>
								<?php
			                        $question_area = '<ul class="list-unstyled survey_question_callback general-form" id="survey_questions">';
			                        if (count($inspection_form->questions) > 0) {
			                            foreach ($inspection_form->questions as $question) {
			                                $question_area .= '<li>';
			                                $question_area .= '<div class="form-group question"><hr>';
			                                $question_area .= '<div class="checkbox checkbox-primary required">';
			                                if ($question['required'] == 1) {
			                                    $_required = ' checked';
			                                } else {
			                                    $_required = '';
			                                }
			                                $question_area .= '<input type="checkbox" id="req_' . $question['questionid'] . '" onchange="update_question(this,\'' . $question['boxtype'] . '\',' . $question['questionid'] . ');" data-question_required="' . $question['questionid'] . '" name="required[]" ' . $_required . ' class="form-check-input">';
			                                $question_area .= '<label for="req_' . $question['questionid'] . '">' . _l('survey_question_required') . '</label>';
			                                $question_area .= '</div>';
			                                $question_area .= '<input type="hidden" value="" name="order[]">';
			                                // used only to identify input key no saved in database
			                                $question_area .= '<label for="' . $question['questionid'] . '" class="control-label display-block col-md-12">' . _l('question_string') . '
			                             <a href="#" onclick="update_question(this,\'' . $question['boxtype'] . '\',' . $question['questionid'] . '); return false;" class="pull-right update-question-button ps-2"><i data-feather="refresh-cw" class="icon-18 text-success question_update"></i></a>
			                             <a href="#" onclick="remove_question_from_database(this,' . $question['questionid'] . '); return false;" class="pull-right text-danger"><i data-feather="x-circle" class="icon-18"></i></a>
			                         </label>';
			                                $question_area .= '<input type="text" onblur="update_question(this,\'' . $question['boxtype'] . '\',' . $question['questionid'] . ');" data-questionid="' . $question['questionid'] . '" class="form-control questionid" value="' . $question['question'] . '">';
			                                if ($question['boxtype'] == 'textarea') {
			                                    $question_area .= '<textarea class="form-control mtop20" disabled="disabled" rows="6">' . _l('survey_question_only_for_preview') . '</textarea>';
			                                } elseif ($question['boxtype'] == 'checkbox' || $question['boxtype'] == 'radio') {
			                                    $question_area .= '<div class="row">';
			                                    $x = 0;
			                                    foreach ($question['box_descriptions'] as $box_description) {
			                                        $box_description_icon_class = 'text-danger';
			                                        $box_description_icon = 'x-circle';
			                                        $box_description_function   = 'remove_box_description_from_database(this,' . $box_description['questionboxdescriptionid'] . '); return false;';
			                                        if ($x == 0) {
			                                        	$box_description_icon_class = '';
			                                            $box_description_icon = 'plus-circle';
			                                            $box_description_function   = 'add_box_description_to_database(this,' . $question['questionid'] . ',' . $question['boxid'] . '); return false;';
			                                        }
			                                        $question_area .= '<div class="box_area p-2">';

			                                        $question_area .= '<div class="col-md-12">';
			                                        $question_area .= '<div class="' . $question['boxtype'] . ' ' . $question['boxtype'] . '-primary display-inline-block">';
			                                        $question_area .= '<input type="' . $question['boxtype'] . '" disabled="disabled" class="form-check-input m-2"/>';
			                                        $question_area .= '
			                            <label>
			                                <input type="text" onblur="update_question(this,\'' . $question['boxtype'] . '\',' . $question['questionid'] . ');" data-box-descriptionid="' . $box_description['questionboxdescriptionid'] . '" value="' . $box_description['description'] . '" class="survey_input_box_description form-control">
			                            </label>';
			                                        $question_area .= '</div>';
			                                        $question_area .= '<a href="#" class="survey_add_more_box ' . ($x != 0 ? 'hide' : '') . '" onclick="' . $box_description_function . '"><i class="icon-18 m-2" data-feather="plus-circle"></i></a>';
			                                        $question_area .= '<a href="#" class="add_remove_action text-danger ' . ($x == 0 ? 'hide' : '') . '" onclick="' . $box_description_function . '"><i class="icon-18 m-2" data-feather="x-circle"></i></a>';
			                                        $question_area .= '</div>';
			                                        $question_area .= '</div>';
			                                        $x++;
			                                    }
			                                    // end box row
			                                    $question_area .= '</div>';
			                                } elseif($question['boxtype'] == 'pass_fail') {

			                                    $question_area .= '<div class="row">';
			                                    $x = 0;
			                                    foreach ($question['box_descriptions'] as $box_description) {
			                                        $_label  = _l('pass_label');
			                                        if ($box_description['is_fail'] == 1) {
			                                        	$_label  = _l('fail_label').'&nbsp;&nbsp;';
			                                        }
			                                        $question_area .= '<div class="box_area">';

			                                        $question_area .= '<div class="col-md-12 mtop10">';
			                                        $question_area .= '<div class="' . $question['boxtype'] . ' ' . $question['boxtype'] . '-primary">';
			                                        $question_area .= '<label >'.$_label.'&nbsp;&nbsp;&nbsp;</label>';
			                                        $question_area .= '
			                            <label>
			                                <input type="text" onblur="update_question(this,\'' . $question['boxtype'] . '\',' . $question['questionid'] . ');" data-box-descriptionid="' . $box_description['questionboxdescriptionid'] . '" value="' . $box_description['description'] . '" class="survey_input_box_description form-control">
			                            </label>';
			                                        $question_area .= '</div>';
			                                        $question_area .= '</div>';
			                                        $question_area .= '</div>';
			                                        $x++;
			                                    }
			                                    // end box row
			                                    $question_area .= '</div>';
			                                } else {
			                                    $question_area .= '<input type="text" class="form-control mtop20" disabled="disabled" value="' . _l('survey_question_only_for_preview') . '">';
			                                }
			                                $question_area .= '</div>';
			                                $question_area .= '</li>';
			                            }
			                        }
			                        $question_area .= '</ul>';
			                        echo new_html_entity_decode($question_area);
			                        ?>
							</div>

						<?php } else { ?>
							<p class="no-margin"><?php echo _l('hr_survey_create_first'); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require('plugins/Fleet/assets/js/settings/inspection_form_js.php'); ?>
