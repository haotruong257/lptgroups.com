<li>

	<span data-feather="key" class="icon-14 ml-20"></span>
	<h5><?php echo app_lang("can_access_fleet"); ?></h5>

	<div>
		<label for=""><strong><?php echo app_lang("dashboard"); ?></strong></label>
		<div class="ml15">
			<div>
				<?php
				echo form_checkbox("fleet_can_view_dashboard", "1", $fleet_can_view_dashboard ? true : false, "id='fleet_can_view_dashboard' class='form-check-input'");
				?>
				<label for="fleet_can_view_dashboard"><?php echo app_lang("view"); ?></label>
			</div>
		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("vehicle"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_vehicle", "1", $fleet_can_view_vehicle ? true : false, "id='fleet_can_view_vehicle' class='form-check-input'");
				?>
				<label for="fleet_can_view_vehicle"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_vehicle", "1", $fleet_can_create_vehicle ? true : false, "id='fleet_can_create_vehicle' class='form-check-input'");
				?>
				<label for="fleet_can_create_vehicle"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_vehicle", "1", $fleet_can_edit_vehicle ? true : false, "id='fleet_can_edit_vehicle' class='form-check-input'");
				?>
				<label for="fleet_can_edit_vehicle"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_vehicle", "1", $fleet_can_delete_vehicle ? true : false, "id='fleet_can_delete_vehicle' class='form-check-input'");
				?>
				<label for="fleet_can_delete_vehicle"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("transaction"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_transaction", "1", $fleet_can_view_transaction ? true : false, "id='fleet_can_view_transaction' class='form-check-input'");
				?>
				<label for="fleet_can_view_transaction"><?php echo app_lang("view"); ?></label>
			</div>
		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("driver"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_driver", "1", $fleet_can_view_driver ? true : false, "id='fleet_can_view_driver' class='form-check-input'");
				?>
				<label for="fleet_can_view_driver"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_driver", "1", $fleet_can_create_driver ? true : false, "id='fleet_can_create_driver' class='form-check-input'");
				?>
				<label for="fleet_can_create_driver"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_driver", "1", $fleet_can_edit_driver ? true : false, "id='fleet_can_edit_driver' class='form-check-input'");
				?>
				<label for="fleet_can_edit_driver"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_driver", "1", $fleet_can_delete_driver ? true : false, "id='fleet_can_delete_driver' class='form-check-input'");
				?>
				<label for="fleet_can_delete_driver"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("work_performance"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_work_performance", "1", $fleet_can_view_work_performance ? true : false, "id='fleet_can_view_work_performance' class='form-check-input'");
				?>
				<label for="fleet_can_view_work_performance"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_work_performance", "1", $fleet_can_create_work_performance ? true : false, "id='fleet_can_create_work_performance' class='form-check-input'");
				?>
				<label for="fleet_can_create_work_performance"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_work_performance", "1", $fleet_can_edit_work_performance ? true : false, "id='fleet_can_edit_work_performance' class='form-check-input'");
				?>
				<label for="fleet_can_edit_work_performance"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_work_performance", "1", $fleet_can_delete_work_performance ? true : false, "id='fleet_can_delete_work_performance' class='form-check-input'");
				?>
				<label for="fleet_can_delete_work_performance"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("benefit_and_penalty"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_benefit_and_penalty", "1", $fleet_can_view_benefit_and_penalty ? true : false, "id='fleet_can_view_benefit_and_penalty' class='form-check-input'");
				?>
				<label for="fleet_can_view_benefit_and_penalty"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_benefit_and_penalty", "1", $fleet_can_create_benefit_and_penalty ? true : false, "id='fleet_can_create_benefit_and_penalty' class='form-check-input'");
				?>
				<label for="fleet_can_create_benefit_and_penalty"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_benefit_and_penalty", "1", $fleet_can_edit_benefit_and_penalty ? true : false, "id='fleet_can_edit_benefit_and_penalty' class='form-check-input'");
				?>
				<label for="fleet_can_edit_benefit_and_penalty"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_benefit_and_penalty", "1", $fleet_can_delete_benefit_and_penalty ? true : false, "id='fleet_can_delete_benefit_and_penalty' class='form-check-input'");
				?>
				<label for="fleet_can_delete_benefit_and_penalty"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("event"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_event", "1", $fleet_can_view_event ? true : false, "id='fleet_can_view_event' class='form-check-input'");
				?>
				<label for="fleet_can_view_event"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_event", "1", $fleet_can_create_event ? true : false, "id='fleet_can_create_event' class='form-check-input'");
				?>
				<label for="fleet_can_create_event"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_event", "1", $fleet_can_edit_event ? true : false, "id='fleet_can_edit_event' class='form-check-input'");
				?>
				<label for="fleet_can_edit_event"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_event", "1", $fleet_can_delete_event ? true : false, "id='fleet_can_delete_event' class='form-check-input'");
				?>
				<label for="fleet_can_delete_event"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("work_orders"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_work_orders", "1", $fleet_can_view_work_orders ? true : false, "id='fleet_can_view_work_orders' class='form-check-input'");
				?>
				<label for="fleet_can_view_work_orders"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_work_orders", "1", $fleet_can_create_work_orders ? true : false, "id='fleet_can_create_work_orders' class='form-check-input'");
				?>
				<label for="fleet_can_create_work_orders"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_work_orders", "1", $fleet_can_edit_work_orders ? true : false, "id='fleet_can_edit_work_orders' class='form-check-input'");
				?>
				<label for="fleet_can_edit_work_orders"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_work_orders", "1", $fleet_can_delete_work_orders ? true : false, "id='fleet_can_delete_work_orders' class='form-check-input'");
				?>
				<label for="fleet_can_delete_work_orders"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("garage"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_garage", "1", $fleet_can_view_garage ? true : false, "id='fleet_can_view_garage' class='form-check-input'");
				?>
				<label for="fleet_can_view_garage"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_garage", "1", $fleet_can_create_garage ? true : false, "id='fleet_can_create_garage' class='form-check-input'");
				?>
				<label for="fleet_can_create_garage"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_garage", "1", $fleet_can_edit_garage ? true : false, "id='fleet_can_edit_garage' class='form-check-input'");
				?>
				<label for="fleet_can_edit_garage"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_garage", "1", $fleet_can_delete_garage ? true : false, "id='fleet_can_delete_garage' class='form-check-input'");
				?>
				<label for="fleet_can_delete_garage"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("maintenance"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_maintenance", "1", $fleet_can_view_maintenance ? true : false, "id='fleet_can_view_maintenance' class='form-check-input'");
				?>
				<label for="fleet_can_view_maintenance"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_maintenance", "1", $fleet_can_create_maintenance ? true : false, "id='fleet_can_create_maintenance' class='form-check-input'");
				?>
				<label for="fleet_can_create_maintenance"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_maintenance", "1", $fleet_can_edit_maintenance ? true : false, "id='fleet_can_edit_maintenance' class='form-check-input'");
				?>
				<label for="fleet_can_edit_maintenance"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_maintenance", "1", $fleet_can_delete_maintenance ? true : false, "id='fleet_can_delete_maintenance' class='form-check-input'");
				?>
				<label for="fleet_can_delete_maintenance"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("fuel"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_fuel", "1", $fleet_can_view_fuel ? true : false, "id='fleet_can_view_fuel' class='form-check-input'");
				?>
				<label for="fleet_can_view_fuel"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_fuel", "1", $fleet_can_create_fuel ? true : false, "id='fleet_can_create_fuel' class='form-check-input'");
				?>
				<label for="fleet_can_create_fuel"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_fuel", "1", $fleet_can_edit_fuel ? true : false, "id='fleet_can_edit_fuel' class='form-check-input'");
				?>
				<label for="fleet_can_edit_fuel"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_fuel", "1", $fleet_can_delete_fuel ? true : false, "id='fleet_can_delete_fuel' class='form-check-input'");
				?>
				<label for="fleet_can_delete_fuel"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("part"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_part", "1", $fleet_can_view_part ? true : false, "id='fleet_can_view_part' class='form-check-input'");
				?>
				<label for="fleet_can_view_part"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_part", "1", $fleet_can_create_part ? true : false, "id='fleet_can_create_part' class='form-check-input'");
				?>
				<label for="fleet_can_create_part"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_part", "1", $fleet_can_edit_part ? true : false, "id='fleet_can_edit_part' class='form-check-input'");
				?>
				<label for="fleet_can_edit_part"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_part", "1", $fleet_can_delete_part ? true : false, "id='fleet_can_delete_part' class='form-check-input'");
				?>
				<label for="fleet_can_delete_part"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("insurance"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_insurance", "1", $fleet_can_view_insurance ? true : false, "id='fleet_can_view_insurance' class='form-check-input'");
				?>
				<label for="fleet_can_view_insurance"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_insurance", "1", $fleet_can_create_insurance ? true : false, "id='fleet_can_create_insurance' class='form-check-input'");
				?>
				<label for="fleet_can_create_insurance"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_insurance", "1", $fleet_can_edit_insurance ? true : false, "id='fleet_can_edit_insurance' class='form-check-input'");
				?>
				<label for="fleet_can_edit_insurance"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_insurance", "1", $fleet_can_delete_insurance ? true : false, "id='fleet_can_delete_insurance' class='form-check-input'");
				?>
				<label for="fleet_can_delete_insurance"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("inspection"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_inspection", "1", $fleet_can_view_inspection ? true : false, "id='fleet_can_view_inspection' class='form-check-input'");
				?>
				<label for="fleet_can_view_inspection"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_inspection", "1", $fleet_can_create_inspection ? true : false, "id='fleet_can_create_inspection' class='form-check-input'");
				?>
				<label for="fleet_can_create_inspection"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_inspection", "1", $fleet_can_edit_inspection ? true : false, "id='fleet_can_edit_inspection' class='form-check-input'");
				?>
				<label for="fleet_can_edit_inspection"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_inspection", "1", $fleet_can_delete_inspection ? true : false, "id='fleet_can_delete_inspection' class='form-check-input'");
				?>
				<label for="fleet_can_delete_inspection"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("booking"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_booking", "1", $fleet_can_view_booking ? true : false, "id='fleet_can_view_booking' class='form-check-input'");
				?>
				<label for="fleet_can_view_booking"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_booking", "1", $fleet_can_create_booking ? true : false, "id='fleet_can_create_booking' class='form-check-input'");
				?>
				<label for="fleet_can_create_booking"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_booking", "1", $fleet_can_edit_booking ? true : false, "id='fleet_can_edit_booking' class='form-check-input'");
				?>
				<label for="fleet_can_edit_booking"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_booking", "1", $fleet_can_delete_booking ? true : false, "id='fleet_can_delete_booking' class='form-check-input'");
				?>
				<label for="fleet_can_delete_booking"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("report"); ?></strong></label>
		<div class="ml15">
			<div>
				<?php
				echo form_checkbox("fleet_can_view_report", "1", $fleet_can_view_report ? true : false, "id='fleet_can_view_report' class='form-check-input'");
				?>
				<label for="fleet_can_view_report"><?php echo app_lang("view"); ?></label>
			</div>
		</div>
	</div>

	<div>
		<label for=""><strong><?php echo app_lang("setting"); ?></strong></label>
		<div class="ml15">
			
			<div>
				<?php
				echo form_checkbox("fleet_can_view_setting", "1", $fleet_can_view_setting ? true : false, "id='fleet_can_view_setting' class='form-check-input'");
				?>
				<label for="fleet_can_view_setting"><?php echo app_lang("view"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_create_setting", "1", $fleet_can_create_setting ? true : false, "id='fleet_can_create_setting' class='form-check-input'");
				?>
				<label for="fleet_can_create_setting"><?php echo app_lang("fleet_create"); ?></label>
			</div>
			
			<div>
				<?php
				echo form_checkbox("fleet_can_edit_setting", "1", $fleet_can_edit_setting ? true : false, "id='fleet_can_edit_setting' class='form-check-input'");
				?>
				<label for="fleet_can_edit_setting"><?php echo app_lang("fleet_edit"); ?></label>
			</div>
			<div>
				<?php
				echo form_checkbox("fleet_can_delete_setting", "1", $fleet_can_delete_setting ? true : false, "id='fleet_can_delete_setting' class='form-check-input'");
				?>
				<label for="fleet_can_delete_setting"><?php echo app_lang("fleet_delete"); ?></label>
			</div>

		</div>
	</div>

</li>