var fnServerParams;
var admin_url = $('input[name="site_url"]').val();
(function($) {
		"use strict";

		fnServerParams = {
    };
    $( document ).ready(function() {
    admin_url = $('input[name="site_url"]').val();
    init_inspection_forms_table();
    
   
    });
})(jQuery);

function init_inspection_forms_table() {
  "use strict";

  if ($.fn.DataTable.isDataTable('.table-inspection-forms')) {
    $('.table-inspection-forms').DataTable().destroy();
  }
  initDataTable('.table-inspection-forms', admin_url + 'fleet/inspection_forms_table', false, false, fnServerParams);
}

