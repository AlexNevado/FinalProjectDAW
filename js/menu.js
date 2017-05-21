$(document).ready(function () {
  $('#confirm').click(function () {
    $(".sales-message")
        .animate({
          marginTop: '-=400px',
          opacity: 0
        }, 'slow');
  });
  $('.shopList .glyphicon').mousedown(function () {
    $(this).css({"font-size": "1.4em"});
  });
  $('.shopList .glyphicon').mouseup(function () {
    $(this).css({"font-size": "1.7em"});
  });
  $('.shopList .glyphicon').click(function () {
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
    $('#options').fadeOut(500);
    $('#mainMenu').delay(600).fadeIn(300);
  });
  $('#profileButton').click(function () {
    $('#mainMenu').fadeOut(500);
    $('#user').delay(600).fadeIn(300);
    $.get( "profile.php", function( data ) {
      $( "#itemsData" ).html( data );
    });
  });
  $('#optionsButton').click(function () {
    $('#mainMenu').fadeOut(500);
    $('#options').delay(600).fadeIn(300);
  });
  $('.glyphicon-play').click(function () {
    mainMenuTheme.play();
  });
  $('.glyphicon-pause').click(function () {
    mainMenuTheme.pause();
  });
  $('.glyphicon').mousedown(function () {
    $(this).css({"font-size": "1.5em"});
  });
  $('.glyphicon').mouseup(function () {
    $(this).css({"font-size": "2em"});
  });
  $('[data-toggle="tooltip"]').tooltip();
});
$(function () {
  var volume = readCookie('volumen');
  $("#slider-range-max").slider({
    range: "max",
    min: 0,
    max: 10,
    value: volume !== 'undefined' ? volume * 10 : 1,
    slide: function (event, ui) {
      $("#amount").val(ui.value);
      mainMenuTheme.volume = (ui.value / 10).toPrecision(1);
      createCookie("volumen", (ui.value / 10).toPrecision(1), 500);
    }
  });
  mainMenuTheme.volume = volume;
  $("#amount").val($("#slider-range-max").slider("value"));
});