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

    var animationTimer = Math.floor((Math.random()*100)+1),
        animationFrame = 0,
        animationReverse = 0,
        animationType = 0;
    setInterval(function() {
      if(animationFrame == 0)
        animationTimer++;

      if(animationTimer%100 != 0) {
        return false;
      } else {
        if(animationType == 0) {
          animationType = Math.floor((Math.random()*2)+1);
        }
      }

      if(animationType == 1)
      {
        if(animationReverse == 0) {
          $('div.logo-hero').removeClass('animation-' + animationFrame).addClass('animation-' + (animationFrame + 1));
          animationFrame++;
        } else {
          $('div.logo-hero').removeClass('animation-' + animationFrame).addClass('animation-' + (animationFrame - 1));
          animationFrame--;
        }

        if(animationFrame == 5) {
          animationReverse = 1;
        } else if(animationFrame == 0) {
          if(animationReverse == 1) {
            animationType = 0;
          }

          animationReverse = 0;
        }
      }

      if(animationType == 2)
      {
        if(animationReverse == 0) {
          $('div.logo-hero').removeClass('animation-' + (animationFrame + 5)).addClass('animation-' + (animationFrame + 6));
          animationFrame++;
        } else {
          $('div.logo-hero').removeClass('animation-' + (animationFrame + 5)).addClass('animation-' + (animationFrame + 4));
          animationFrame--;
        }

        if(animationFrame == 15) {
          animationReverse = 1;
        } else if(animationFrame == 0) {
          if(animationReverse == 1) {
            $('div.logo-hero').removeClass('animation-5').addClass('animation-1');
            animationType = 0;
          }

          animationReverse = 0;
        }
      }
    }, 80);
});