var admin_url = $('input[name="site_url"]').val();
(function(){
	"use strict";
	var fnServerParams = {
		"from_date": "[name='from_date_filter']",
		"to_date": "[name='to_date_filter']"
	}
	$( document ).ready(function() {
$('.select2').select2();
  setDatePicker("#from_date_filter");
  setDatePicker("#to_date_filter");
     admin_url = $('input[name="site_url"]').val();

	initDataTable('.table-inspections', admin_url + 'fleet/inspections_table', '', '', fnServerParams, [1, 'desc']);
	$('input[name="from_date_filter"], input[name="to_date_filter"]').on('change', function(){
		$('.table-inspections').DataTable().ajax.reload();
	});

	$(document).on("click","#mass_select_all",function() {
		var favorite = [];
		if($(this).is(':checked')){
			$('.individual').prop('checked', true);
			$.each($(".individual"), function(){ 
				favorite.push($(this).data('id'));
			});
		}else{
			$('.individual').prop('checked', false);
			favorite = [];
		}

		$("input[name='check']").val(favorite);
	});

	$('select[name="inspection_form_id"]').on('change', function() {
		var id = $('#add_new_inspections input[name="id"]').val();
		requestGet(admin_url+'fleet/get_inspection_form_content/' + $(this).val()+'/'+id).done(function(response) {
	        $('.inspection-form-content').html(response);

		     var survey_fields_required = $('#inspections-form').find('[data-required="1"]');
		     $.each(survey_fields_required, function() {
		       $(this).rules("add", {
		         required: true
		       });
		       var name = $(this).data('for');
		       var label = $(this).parents('.form-group').find('[for="' + name + '"]');
		       if (label.length > 0) {
		         if (label.find('.req').length == 0) {
		           label.prepend(' <small class="req text-danger">* </small>');
		         }
		       }
		     });
	    });
    });
	});
})(jQuery);

/**
 * add asset
 */
 function add_inspections(){
 	"use strict";
 	$('#add_new_inspections').modal('show');
 	$('#add_new_inspections .add-title').removeClass('hide');
 	$('#add_new_inspections .edit-title').addClass('hide');
 	$('#add_new_inspections input[name="id"]').val('');
 	$('#add_new_inspections select').val('').change();
 }

/**
 * edit
 */
 function edit_inspections(id){
 	"use strict";
 	$('#add_new_inspections').modal('show');
 	$('#add_new_inspections .add-title').addClass('hide');
 	$('#add_new_inspections .edit-title').removeClass('hide');
 	$('#add_new_inspections input[name="id"]').val(id);
 	var requestURL = admin_url+'fleet/get_data_inspections/' + (typeof(id) != 'undefined' ? id : '');
 	requestGetJSON(requestURL).done(function(response) {

 		$('select[name="vehicle_id"]').val(response.vehicle_id).change();
 		$('select[name="inspection_form_id"]').val(response.inspection_form_id).change();

 	}).fail(function(data) {
 		alert_float('danger', 'Error');
 	});
 }
