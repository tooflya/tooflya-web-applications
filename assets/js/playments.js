$('.close').on('click', function() {
  $('.payments').remove();
  Tooflya.api.callbacks.payments.cancel();
});
$('.payment').on('click', function() {
  $('#promo-code').removeClass('error');
  Tooflya.api.call('promo.get', {
    purchase: p,
    code: $('#promo-code').val()
  }, {
    success: function() {
      $('.payments').remove();
      Tooflya.api.callbacks.payments.success();
    },
    error: function() {
      $('#promo-code').addClass('error');
    }
  });
});
