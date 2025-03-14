<script>
var commission_table,
report_from_choose,
fnServerParams,
commission_chart,
statistics_cost_of_purchase_orders;
var admin_url = $('input[name="site_url"]').val();

(function($) {
  "use strict";

  commission_table = $('#commission_table');
  commission_chart = $('#commission-chart');
  report_from_choose = $('#report-time');
  fnServerParams = {
    "products_services": '[name="products_services"]',
    "staff_filter": '[name="staff_filter"]',
    "client_filter": '[name="client_filter"]',
    "products_services_chart": '[name="products_services_chart"]',
    "staff_filter_chart": '[name="staff_filter_chart"]',
    "client_filter_chart": '[name="client_filter_chart"]',
    "report_months": '[name="months-report"]',
    "year_requisition": "[name='year_requisition']",
    "is_client": "[name='is_client']",
  }

     gen_reports();
})(jQuery);


// Main generate report function
function gen_reports() {
  "use strict";
 if (!commission_table.hasClass('hide')) {
 }
}

function booking_status_mark_as(status, booking_id) {
  "use strict"; 
  
  var url = admin_url+ 'fleet/booking_status_mark_as/' + status + '/' + booking_id;
  $("body").append('<div class="dt-loader"></div>');

  requestGetJSON(url).done(function (response) {
    $("body").find('.dt-loader').remove();
    if (response.success === true || response.success == 'true') {
      alert_float('success','Status changed');
        setTimeout(function(){location.reload();},1500);
    }
  });
}
</script>


