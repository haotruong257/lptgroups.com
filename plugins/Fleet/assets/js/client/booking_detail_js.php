<script>
var SetRatingStar = function() {
"use strict";
  var $star_rating = $('.star-rating .a-rating');
  return $star_rating.each(function() {
    if (parseInt($star_rating.siblings('input[name="rating"]').val()) >= parseInt($(this).data('rating'))) {
      return $(this).addClass('checked');
    } else {
      return $(this).removeClass('checked');
    }
  });
};
var SetRatingViewStar = function() {
"use strict";
  var $star_rating_view = $('.star-rating-view .a-rating');
  return $star_rating_view.each(function() {
    if (parseInt($star_rating_view.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
      return $(this).addClass('checked');
    } else {
      return $(this).removeClass('checked');
    }
  });
};

(function($) {
"use strict";
     console.log('123');

$(document).ready(function () {
  $('.star-rating .a-rating').on('click', function() {
     $('.star-rating .a-rating').siblings('input[name="rating"]').val($(this).data('rating'));
    return SetRatingStar();
  });
  SetRatingViewStar();
  SetRatingStar();
  });
})(jQuery);

function rating() {
  "use strict";
  $('#rating-modal').modal('show');
}

</script>


