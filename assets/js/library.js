(function($){
  $.fn.shuffle = function() {
    return this.each(function(){
      var items = $(this).children();
      return (items.length) 
        ? $(this).html($.shuffle(items)) 
        : this;
    });
  }
   
  $.shuffle = function(arr) {
    for(
      var j, x, i = arr.length; i; 
      j = parseInt(Math.random() * i), 
      x = arr[--i], arr[i] = arr[j], arr[j] = x
    );
    return arr;
  } 
})(jQuery);
$(document).ready(function() {
  var startPosition = -1732;
  var count = 0;
  var now = 3;
  $('#slider').shuffle();
    $('#slider li').each(function(index, element) {
      count++;
      if(count != 3) {
        $(element).css({'left': startPosition});
      } else {
        $(element).removeClass('banner');
        startPosition += 140;
        $(element).css({'left': 60});
      }
      startPosition += 861;
   });
    $('a#slider-left').live('click', function(e) {
      
    });
    $('a.slider-right').live('click', function(e) {

    });

    $('ul.control-links li').live('click', function() {
      $('ul.control-links li').each(function(index, element) {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
    });
});