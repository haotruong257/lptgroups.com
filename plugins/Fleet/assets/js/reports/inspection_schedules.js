var fnServerParams;
var admin_url = $('input[name="site_url"]').val();
(function($) {
  "use strict";

  $( document ).ready(function() {
       admin_url = $('input[name="site_url"]').val();

    fnServerParams = {
      "is_report": '[name="is_report"]',
    };

  init_email_log_table();
  });
})(jQuery);

function init_email_log_table() {
"use strict";

 if ($.fn.DataTable.isDataTable('.table-email-logs')) {
   $('.table-email-logs').DataTable().destroy();
 }
 initDataTable('.table-email-logs', admin_url + 'fleet/inspection_schedules_table', false, false, fnServerParams, [3, 'desc']);
}