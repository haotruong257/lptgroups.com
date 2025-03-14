var admin_url = $('input[name="site_url"]').val();
(function($) {
  "use strict";

  $( document ).ready(function() {
       admin_url = $('input[name="site_url"]').val();

$.get(admin_url + 'fleet/get_data_inspection_submissions_summary_chart').done(function(res) {
  res = JSON.parse(res);

  Highcharts.chart('container_chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Submissions by User'
    },
    xAxis: {
        categories: res.data_inspection_submissions_summary.categories,
        crosshair: true
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    credits: {
        enabled: false
    },
    series: [{
  name: 'Total',
  data: res.data_inspection_submissions_summary.data
  }]
  });
});
});
})(jQuery);