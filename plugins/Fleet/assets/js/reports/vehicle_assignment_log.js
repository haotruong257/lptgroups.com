var fnServerParams;
var admin_url = $('input[name="site_url"]').val();
(function($) {
  "use strict";

  $( document ).ready(function() {
       admin_url = $('input[name="site_url"]').val();

    fnServerParams = {
      "is_report": '[name="is_report"]',
      "type": '[name="type"]',
    };
    
  init_email_log_table();
    });
})(jQuery);

function init_email_log_table() {
"use strict";

 if ($.fn.DataTable.isDataTable('.table-vehicle-assignments')) {
   $('.table-vehicle-assignments').DataTable().destroy();
 }
 initDataTable('.table-vehicle-assignments', admin_url + 'fleet/vehicle_assignments_table', false, false, fnServerParams, [3, 'desc']);
}