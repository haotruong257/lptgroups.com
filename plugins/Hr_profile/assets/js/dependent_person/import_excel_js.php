<script>

	$(function(){
		'use strict';
		
		if('<?php echo html_entity_decode($active_language) ?>' == 'vietnamese')
		{
			$( "#dowload_file_sample" ).append( '<a href="<?php echo html_entity_decode($site_url) ?>/plugins/Hr_profile/Uploads/sample_file/Sample_import_hrm_dependent_person_file_vi.xlsx" class="btn btn-primary mright5" ><?php echo _l('hr_download_sample') ?></a>' );
			$( "#dowload_file_sample" ).append( '<a href="<?php echo admin_url('hr_profile/dependent_persons'); ?>" class=" mright5 btn btn-default" ><?php echo _l('hr__back') ?></a><hr>' );

		}else{
			$( "#dowload_file_sample" ).append( '<a href="<?php echo html_entity_decode($site_url) ?>/plugins/Hr_profile/Uploads/sample_file/Sample_import_hrm_dependent_person_file_en.xlsx" class="btn btn-primary mright5" ><?php echo _l('hr_download_sample') ?></a>' );
			$( "#dowload_file_sample" ).append( '<a href="<?php echo admin_url('hr_profile/dependent_persons'); ?>" class=" mright5 btn btn-default" ><?php echo _l('hr__back') ?></a><hr>' );
		}
		
	});

	function get_laguage() {
		'use strict';

		return $(".header-languages").find("li.active>").html();
	}


	function uploadfilecsv(){
		'use strict';

		if(($("#file_csv").val() != '') && ($("#file_csv").val().split('.').pop() == 'xlsx')){
			var formData = new FormData();
			formData.append("file_csv", $('#file_csv')[0].files[0]);
			formData.append("rise_csrf_token", $('input[name="rise_csrf_token"]').val());
			formData.append("leads_import", $('input[name="leads_import"]').val());

			//show box loading
			var html = '';
			html += '<div class="Box">';
			html += '<span>';
			html += '<span></span>';
			html += '</span>';
			html += '</div>';
			$('#box-loading').html(html);
			$(event).attr( "disabled", "disabled" );

			$.ajax({ 

				url: "<?php  echo get_uri('hr_profile/import_dependent_person_excel') ?>", 
				method: 'post', 
				data: formData, 
				contentType: false, 
				processData: false

			}).done(function(response) {
				response = JSON.parse(response);
				//hide boxloading
				$('#box-loading').html('');
				$(event).removeAttr('disabled')

				$("#file_csv").val(null);
				$("#file_csv").change();
				$(".panel-body").find("#file_upload_response").html();

				if($(".panel-body").find("#file_upload_response").html() != ''){
					$(".panel-body").find("#file_upload_response").empty();
				};

				if(response.total_rows){
					$( "#file_upload_response" ).append( "<h4><?php echo _l("_Result") ?></h4><h6><?php echo _l('import_line_number') ?> :"+response.total_rows+" </h6>" );
				}
				if(response.total_row_success){
					$( "#file_upload_response" ).append( "<h6><?php echo _l('import_line_number_success') ?> :"+response.total_row_success+" </h6>" );
				}
				if(response.total_row_false){
					$( "#file_upload_response" ).append( "<h6><?php echo _l('import_line_number_failed') ?> :"+response.total_row_false+" </h6>" );
				}
				if(response.total_row_false > 0)
				{
					$( "#file_upload_response" ).append( '<a href="'+response.site_url+'\\'+response.filename+'" class="btn btn-warning text-white"  ><?php echo _l('hr_download_file_error') ?></a>' );
				}
				if(response.total_rows < 1){
					appAlert.warning(response.message);
				}
			});
			return false;
		}else if($("#file_csv").val() != ''){
			appAlert.warning("<?php echo _l('_please_select_a_file') ?>");
		}

	}
</script>