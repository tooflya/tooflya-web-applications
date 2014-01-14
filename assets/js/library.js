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

var sliderCount = 1;
var twoTimes = false;
$(document).ready(function() {
    $('#languages-select').change(function() {
      $('#languages').submit();
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
          animationType = Math.floor((Math.random()*3)+1);
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

      if(animationType == 3)
      {
        if(animationReverse == 0) {
          $('div.logo-hero').removeClass('animation-' + (animationFrame + 20)).addClass('animation-' + (animationFrame + 21));
          animationFrame++;
        } else {
          $('div.logo-hero').removeClass('animation-' + (animationFrame + 20)).addClass('animation-' + (animationFrame + 19));
          animationFrame--;
        }

        if(animationFrame == 10) {
          animationReverse = 1;
        } else if(animationFrame == 0) {
          if(animationReverse == 1) {
            $('div.logo-hero').removeClass('animation-20').addClass('animation-1');
            animationType = 0;
          }

          animationReverse = 0;
        }
      }
    }, 80);
});
var ajaxRequest = {
  dataToSend: '',
  debug: false,
  error: function(e) {
  },
  send: function(Params) {
    if(Params.preload) {
      $('div[class*=mask]').fadeIn(500);
    }
    if(Params.button) {
      var text = $(Params.button).html();
      $(Params.button).removeClass('btn-primary').addClass('btn-info').html(Params.text);
    }
    $.ajax({
      url: Params.url,
      type: 'POST',
      dataType: 'json',
      data: Params.data,
      async: true,
      cache: false,
      success: function(e) {
        if(Params.history) {
          if(Params.history.state.params) {
            if(!Params.history.state.params.pop) {
              history.pushState(Params.history.state, null, '/' + location.href.split('/')[3] + Params.history.url);
            }
          } else {
            history.pushState(Params.history.state, null, '/' + location.href.split('/')[3] + Params.history.url);
          }
        }

        if(Params.button) {
          $(Params.button).removeClass('btn-info').addClass('btn-primary').html(text);
        }
        if(Params.success) {
          try {
            Params.success(e);
          } catch(exception) {
            ajaxRequest.error(exception);
          }
        }
      },
      error: function(e) {
        if(Params.error) {
          Params.error(e);
        } else {
          ajaxRequest.error(e);
        }
      },
      complete: function(e) {
        if(Params.complete) {
          Params.complete(e);
        }
        if(Params.preload) {
          $('div[class*=mask]').fadeOut(500);
        }
      }
    });
  }
};

y = 1;
y2 = 7;

$(function() {
    $('#slider').shuffle();
    $('#center-slider').shuffle();
    $('ul.control-links li').click(function(e) {
      $.each($('ul.control-links li'), function(i, item) {
        $(item).removeClass('active');
      });
      $(this).addClass('active');
    });
    $(".center-slider").jCarouselLite({
      btnNext: "#center-slider-right",
      btnPrev: "#center-slider-left",
      visible: 1,
      auto: false,
      speed: 1000
    });
    $(".slider").jCarouselLite({
        btnNext: "#slider-right",
        btnPrev: "#slider-left",
        speed: 600,
        btnGo:
        [".control-links .1", ".control-links .2",
        ".control-links .3",
        ".control-links .4",
        ".control-links .5"]
    });

    $('#slider-left').click(function(e) {
      y--;
      if(y < 0) y = y2;

      yy();
    });

    $('#slider-right').click(function(e) {
      y++;
      if(y > y2) y = 1;

      yy();
    });
});

function yy()
{
  $.each($('ul.control-links li'), function(i, item) {
    $(item).removeClass('active');

    if(i == y-1) $(item).addClass('active');
  });
}