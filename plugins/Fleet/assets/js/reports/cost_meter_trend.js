var admin_url = $('input[name="site_url"]').val();
(function($) {
  "use strict";

  $( document ).ready(function() {
       admin_url = $('input[name="site_url"]').val();

      setDatePicker("#from_date");
      setDatePicker("#to_date");
      filter_form_handler();
  });

})(jQuery);


function filter_form_handler() {
  "use strict";
    var form = document.getElementById('filter-form');
    var formURL = form.action;
    var formData = new FormData($(form)[0]);
    //show box loading
    var html = '';
      html += '<div class="Box">';
      html += '<span>';
      html += '<span></span>';
      html += '</span>';
      html += '</div>';
      $('#box-loading').html(html);

    $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
    }).done(function(response) {
      $('#DivIdToPrint').html(response);

    //hide boxloading
      $('#box-loading').html('');
      $('button[id="uploadfile"]').removeAttr('disabled');
    }).fail(function(error) {
        alert_float('danger', JSON.parse(error.mesage));
    });

    var from_date = $('input[name="from_date"]').val();
    var to_date = $('input[name="to_date"]').val();

    $.get(admin_url + 'fleet/get_data_cost_meter_trend_chart?from_date='+ from_date+'&to_date='+to_date).done(function(res) {
        res = JSON.parse(res);

        Highcharts.chart('container_chart', {
      chart: {
          type: 'area'
      },
      title: {
          text: 'Event Stats'
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
      series: res.data_cost_meter_trend
    });
      });

    return false;
}
