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
    
    $.get(admin_url + 'fleet/get_data_inspection_submissions_list_chart').done(function(res) {
    res = JSON.parse(res);

      Highcharts.chart('container_chart', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Inspection Submissions'
        },
        xAxis: {
            type: 'datetime',
            labels: {
                format: '{value:%Y-%m-%d}',
                rotation: 45,
                align: 'left'
            }
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        credits: {
            enabled: false
        },
        series: res.data_inspection_submissions_list
      });
  });
    
  init_email_log_table();
      });
})(jQuery);

function init_email_log_table() {
"use strict";

 if ($.fn.DataTable.isDataTable('.table-email-logs')) {
   $('.table-email-logs').DataTable().destroy();
 }
 initDataTable('.table-email-logs', admin_url + 'fleet/inspections_table', false, false, fnServerParams, [3, 'desc']);
}