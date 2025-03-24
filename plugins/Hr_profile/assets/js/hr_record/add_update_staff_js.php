<script>
	$(function(){
		'use strict';
		$(".select2").select2();
		setDatePicker("#dob, #days_for_identity");

		$("#generate_password").click(function () {
            $("#password").val(getRndomString(8));
        });

		$("#show_hide_password").click(function () {
            var $target = $("#password"),
                    type = $target.attr("type");
            if (type === "password") {
                $(this).attr("title", "<?php echo app_lang("hide_text"); ?>");
                $(this).html("<span data-feather='eye-off' class='icon-16'></span>");
                feather.replace();
                $target.attr("type", "text");
            } else if (type === "text") {
                $(this).attr("title", "<?php echo app_lang("show_text"); ?>");
                $(this).html("<span data-feather='eye' class='icon-16'></span>");
                feather.replace();
                $target.attr("type", "password");
            }
        });


		$('input[name="email"]').on('change', function() {
			staff_email_exists();
		});


		$('select[name="role_v"]').on('change', function() {
			var roleid = $(this).val();
			init_roles_permissions_v2(roleid, true);
		});


		$("input[name='profile_image']").on('change', function() {
			readURL(this);
		});

		$("body").on('click', '.add_edit_member_submit', function (event, state) {
			"use strict";

			var data = {};
			data.email = $('input[name="email"]').val();
			data.id = $('input[name="id"]').val();

			if($('input[name="email"]').val() != ''){

				$.post("<?php echo get_uri("hr_profile/staff_email_exists") ?>", data).done(function(response) {
					response = JSON.parse(response);
					if(!response.success){
						appAlert.warning(response.message);
					}else{
						$("#add_edit_member").submit();
					}

				}).fail(function(data) {
					appAlert.warning(data.responseText);
				});

			}
		});


	});

	function staff_email_exists() {
		'use strict';
		
		var data = {};
		data.email = $('input[name="email"]').val();
		data.id = $('input[name="id"]').val();

		if($('input[name="email"]').val() != ''){

			$.post("<?php echo get_uri("hr_profile/staff_email_exists") ?>", data).done(function(response) {
				response = JSON.parse(response);
				if(!response.success){
					appAlert.warning(response.message);
				}else{
					appAlert.success("<?php echo app_lang('hr_valid_email') ?>", { duration: 1});
					
				}
			}).fail(function(data) {
				appAlert.warning(data.responseText);
			});

		}
	}


	function readURL(input) {
		"use strict";
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$("img[id='wizardPicturePreview']").attr('src', e.target.result).fadeIn('slow');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function hr_profile_update_staff(staff_id) {
		"use strict";

		$("#modal_wrapper").load("<?php echo admin_url('hr_profile/hr_profile/member_modal'); ?>", {
			slug: 'update',
			staff_id: staff_id
		}, function() {
			if ($('.modal-backdrop.fade').hasClass('in')) {
				$('.modal-backdrop.fade').remove();
			}
			if ($('#appointmentModal').is(':hidden')) {
				$('#appointmentModal').modal({
					show: true
				});
			}
			$('#appointmentModal div[app-field-wrapper="role_v"]').hide();
			$('#appointmentModal #div_hourly_rate').hide();

		});

		init_selectpicker();
		$(".selectpicker").selectpicker('refresh');
	}

</script>