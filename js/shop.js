$(document).ready(function () {
  $('#confirm').click(function () {
    $(".sales-message")
        .animate({
          marginTop: '-=400px',
          opacity: 0
        }, 'slow');
  });
  $('.glyphicon').mousedown(function () {
    $(this).css({"font-size": "1.4em"});
  });
  $('.glyphicon').mouseup(function () {
    $(this).css({"font-size": "1.7em"});
  });
  $('.glyphicon').click(function () {
    var id = $(this).attr('id').substr(4, 1);
    var value = $(this).attr('id').substr(0, 4) == 'plus' ? 1 : -1;
    var newValue = parseInt($('#item' + id).val()) + value;
    newValue = newValue > 0 ? newValue : 0;
    $('#item' + id).val(newValue);
    var totalValue = 0;
    $('input[id^=item]').each(function () {
      var id = $(this).attr('id').substr(4, 1);
      var itemValue = parseInt($('input[id^=price' + id + ']').val());
      var amount = parseInt($(this).val());
      totalValue += itemValue * amount;
    });
    $('#totalSale').val(totalValue);
  });
  $('#shopButton').click(function () {
    $('#mainMenu').fadeOut(500);
    $('#shop').delay(600).fadeIn(300);
  });
  $('.backMenu').click(function () {
    $('#user').fadeOut(500);
    $('#shop').fadeOut(500);
    $('#mainMenu').delay(600).fadeIn(300);
  });
  $('#perfil').click(function () {
    $('#mainMenu').fadeOut(500);
    $('#user').delay(600).fadeIn(300);
  });
});
