<script>
	var purchase;

	(function($) {
		"use strict";  


	<?php if(isset($company_contributions_list)){?>
		var dataObject_pu = <?php echo html_entity_decode($company_contributions_list); ?>;
	<?php }else{ ?>
		var dataObject_pu = [];
	<?php } ?>

	//hansometable for purchase
	var row_global;
	var hotElement1 = document.getElementById('company_contributions_list_hs');

	purchase = new Handsontable(hotElement1, {
		licenseKey: 'non-commercial-and-evaluation',

		contextMenu: true,
		manualRowMove: true,
		manualColumnMove: true,
		stretchH: 'all',
		autoWrapRow: true,
		rowHeights: 30,
		defaultRowHeight: 100,
		minRows: 10,
		maxRows: 40,
		width: '100%',

		rowHeaders: true,
		colHeaders: true,
		autoColumnSize: {
			samplingRatio: 23
		},

		filters: true,
		manualRowResize: true,
		manualColumnResize: true,
		allowInsertRow: true,
		allowRemoveRow: true,
		columnHeaderHeight: 40,

		colWidths:  [40, 100, 50, 40, 60],
		rowHeights: 30,
		rowHeaderWidth: [44],
		minSpareRows: 1,
		hiddenColumns: {
			columns: [7],
			indicators: true
		},
		autoWrapCol: true,
		autoWrapRow: true,
		columns: [
				{
			type: 'text',
			data: 'code',
		},
		{
			type: 'text',
			data: 'description',
		},
		{
			type: 'numeric',
			data: 'rate',
			numericFormat: {
				pattern: '0,00',
			},
		},

		{
			type: 'text',
			data: 'basis',
		},

		{
			type: 'text',
			data: 'earn_inclusion',
			renderer: customDropdownRenderer,
			editor: "chosen",
			chosenOptions: {
				data: <?php echo json_encode($earn_inclusion); ?>
			}

		},
		{
			type: 'text',
			data: 'earn_exclusion',
		},
		{
			type: 'numeric',
			data: 'earnings_max',
			numericFormat: {
				pattern: '0,00',
			},
		},

		{
			type: 'text',
			data: 'id',
		},
		

		],

		colHeaders: [
		'<?php echo app_lang('salary_deduction_code'); ?>',
		'<?php echo app_lang('salary_deduction_name'); ?>',
		'<?php echo app_lang('salary_deduction_rate'); ?>',
		'<?php echo app_lang('salary_deduction_basis'); ?>',
		'<?php echo app_lang('earn_inclusion'); ?>',
		'<?php echo app_lang('earn_exclusion'); ?>',
		'<?php echo app_lang('earnings_max'); ?>',
		'<?php echo app_lang('id'); ?>',
		],

		data: dataObject_pu,
	});


})(jQuery);

function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
	"use strict";
	var selectedId;
	var optionsList = cellProperties.chosenOptions.data;
	
	if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
		Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
		return td;
	}

	var values = (value + "").split("|");
	value = [];
	for (var index = 0; index < optionsList.length; index++) {

		if (values.indexOf(optionsList[index].id + "") > -1) {
			selectedId = optionsList[index].id;
			value.push(optionsList[index].label);
		}
	}
	value = value.join(", ");

	Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
	return td;
}

var purchase_value = purchase;

$('.add_company_contributions_list').on('click', function() {
	'use strict';
	
	var valid_contract = $('#company_contributions_list_hs').find('.htInvalid').html();

	if(valid_contract){
		alert_float('danger', "<?php echo app_lang('data_must_number') ; ?>");
	}else{

		$('input[name="company_contributions_list_hs"]').val(JSON.stringify(purchase_value.getData()));   
		$('#add_company_contributions_list').submit(); 

	}
});


</script>