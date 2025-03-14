var fnServerParams;
var admin_url = $('input[name="site_url"]').val();
(function($) {
	
  	"use strict";

		fnServerParams = {
      "from_date": '[name="from_date"]',
      "to_date": '[name="to_date"]',
    };

   $( document ).ready(function() {
    setDatePicker("#from_date");
  setDatePicker("#to_date");
     admin_url = $('input[name="site_url"]').val();

    $('input[name="from_date"]').on('change', function() {
    init_invoices_table();
    });

    $('input[name="to_date"]').on('change', function() {
      init_invoices_table();
    });
        init_invoices_table();
  });
    
})(jQuery);

function init_invoices_table() {
  "use strict";

  if ($.fn.DataTable.isDataTable('.table-fleet-invoices')) {
    $('.table-fleet-invoices').DataTable().destroy();
  }
  initDataTable('.table-fleet-invoices', admin_url + 'fleet/invoices_table', false, false, fnServerParams);
}
