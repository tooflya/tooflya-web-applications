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
  var startPosition = -940;
  $('#slider').shuffle();

  var count = 0;
  $('#slider li').each(function(index, element) {
    $(element).css({'left': startPosition});

    if(count != 1) {
      $(element).css({'opacity': 0.5});
      //$(element).css({'transform': 'scale(0.8)'});
    }

    startPosition += 1000;
    count++;
  });


  $('#slider-left').click(function() {
    if(sliderCount <=0) return;

    sliderCount--;

    if(twoTimes) {sliderCount--;}
  count = 0;
  $('#slider li').each(function(index, element) {
    $(element).animate({'left': $(element).position().left+ (twoTimes ? 2000 : 1000)});



     $(element).css({'opacity': 0.5});

      if(count == sliderCount) {
       $(element).css({'opacity': 1});
      }

      count++;
    });twoTimes=false;

  var c = 0;
$('.control-links li').each(function(index, element) {
  if(c==sliderCount) {
    $(element).addClass('active');
  } else {
    $(element).removeClass('active');
  }
  c++;
});
  });

  $('#slider-right').click(function() {
    if(sliderCount >= 2) return;

    sliderCount++;

    if(twoTimes) {sliderCount++;}

  count = 0;
  $('#slider li').each(function(index, element) {
    $(element).animate({'left': $(element).position().left-(twoTimes ? 2000 : 1000)});

      $(element).css({'opacity': 0.5});
      //$(element).css({'transform': 'scale(0.8)'});

      if(count == sliderCount) {
        $(element).css({'opacity': 1});
        //$(element).css({'transform': 'scale(1)'});
      }

      count++;
    });
twoTimes=false;

var c = 0;
$('.control-links li').each(function(index, element) {
  if(c==sliderCount) {
    $(element).addClass('active');
  } else {
    $(element).removeClass('active');
  }
  c++;
});
  
  });

    $('#languages-select').change(function() {
      $('#languages').submit();
    });
    $('a#slider-left').live('click', function(e) {
      
    });
    $('a.slider-right').live('click', function(e) {

    });

    $('ul.control-links li').live('click', function() {
        index = $(this).data('index')-sliderCount;

if(Math.abs(index)>1) {
  twoTimes = true;
}
          if(index>0) {
            $('#slider-left').click();
          } else if(index <0) {
            $('#slider-right').click();
          }
        

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
      $('div[class=mask]').fadeIn(0);
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
          $('div[class=mask]').fadeOut(0);
        }

        $('a').tooltip({
          placement: 'bottom'
        });
        $('table').tablesorter();
      }
    });
  }
};

(function poll(){
    $.ajax({
      url: "/ajax/events.php",
      async: true,
      cache: true,
      dataType: "json",
      timeout: 30000,
      success: function(e) {
        if(e.response == 2) return;
        e = $.parseJSON(e.response);
        $.each(e, function(i, item) {
          var eventMessage;
          switch(i) {
            case 'online':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile">User is <b>online</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname}).prependTo("div.events");
                $('div#event-'+eventID).fadeIn(700);
                setTimeout(function() {
                  $('div#event-'+eventID).fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
                if(event.sex == 1) {
                  eventMessage = "<b>entered</b> into the system.";
                } else {
                  eventMessage = "<b>entered</b> into the system.";
                }
                $.tmpl('<tr class="event" data-id="{$some.id}"><td class=""><img src="/assets/img/corp/${avatar}" width="25" height="25" class="avatar"></td><td class=""><span class="name">${name} ${surname}</span> ' + eventMessage + '</td><td class="events-time">Недоступно</td></tr>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname}).prependTo("tbody.events-body");
              });
            break;
            case 'offline':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile">User is <b>offline</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname}).prependTo("div.events");
                $('div#event-'+eventID).fadeIn(700);
                setTimeout(function() {
                  $('div#event-'+eventID).fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
                if(event.sex == 1) {
                  eventMessage = "<b>left</b> the system.";
                } else {
                  eventMessage = "<b>left</b> the system.";
                }
                $.tmpl('<tr class="event" data-id="{$some.id}"><td class=""><img src="/assets/img/corp/${avatar}" width="25" height="25" class="avatar"></td><td class=""><span class="name">${name} ${surname}</span> ' + eventMessage + '</td><td class="events-time">Недоступно</td></tr>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname}).prependTo("tbody.events-body");
              });
            break;
          }
        });
      },
      error: function(e) {
      },
      complete: function(e) {
        setTimeout(function() {
          poll();
        }, 500);
      }
    });
})();

var signInID;
$('li.sign-in').live('click', function() {
  if($(this).hasClass('save')) {
    $.each($('li[class*=sign-in]'), function(key, value) {
      $(this).removeClass('sign-in-blur').removeClass('save');
    });
    $('div.password').fadeOut(200);
  } else {
    /** TODO: Check input focus */
    $('#password').removeClass('error').focus();
    $('div.password').fadeIn(200).animate({top: $(this).offset().top + 15}).focus();
    $.each($('li[class*=sign-in]'), function(key, value) {
      $(this).removeClass('sign-in-blur').removeClass('save');
    });
    $(this).addClass('save');
    $.each($('li[class=sign-in]'), function(key, value) {
      $(this).addClass('sign-in-blur');
    });
    signInID = $(this).attr('data-id');
  }
});

$('#password').live('keypress', function(e) {
  $('#password').removeClass('error');
  if(e.which == 13) {
    e.preventDefault();
    ajaxRequest.send({
        url: '/ajax/permissions.php',
        data: 'id='+signInID+'&password='+$('#password').val()+"&type=login",
        preload: true,
        success: function(e) {
        if(e.response) {
          $('body').html(e.body);
        } else {
          $('#password').addClass('error');
        }
      }
    });
  }
});

$('tr.site').live('click', function() {
  ajaxRequest.send({
    url: '/ajax/sites.php',
    data: 'id='+$(this).attr('data-id'),
    preload: true,
    success: function(e) {
      $.each(e, function(key, value) {
        $(key).html(value);
      });
    }
  });
});

var siteDetailsID;
$('a.site-configure').live('click', function() {
  siteDetailsID = $(this).attr('data-id');
  $('#site-configure-approve-'+siteDetailsID).fadeIn(0);

  return false;
});
$('div[class*=site-configure-no]').live('click', function() {
  $('#site-configure-approve-'+siteDetailsID).fadeOut(0);
});
$('div[class*=site-configure-yes]').live('click', function() {
  $('#site-configure-approve-'+siteDetailsID).fadeOut(0);
  ajaxRequest.send({
    url: '/ajax/sites.php',
    data: 'type=update&id='+siteDetailsID,
    preload: true
  });
});
$('tr.site').live('contextmenu', function(e) {
  e.preventDefault();

  $.each($('tr.site'), function(key, value) {
    $(this).removeClass('hover');
  });
  $(this).addClass('hover');
  $('div.sites-context-menu').fadeIn(100).offset({left:e.pageX, top:e.pageY});

  siteDetailsID = $(this).attr('data-id');
});
$('a.show-site-details').live('click', function() {
  ajaxRequest.send({
    url: '/ajax/sites.php',
    data: 'id='+siteDetailsID,
    preload: true,
    success: function(e) {
      $.each(e, function(key, value) {
        $(key).html(value);
      });
    }
  });
});
$('a.delete-site').live('click', function() {
  $('span.site-delete-url').html($('tr[data-id='+siteDetailsID+']').attr('data-name'));
  $('div.site-delete-approve').fadeIn(0);
});
$('div[class*=site-delete-no]').live('click', function() {
  $('div.site-delete-approve').fadeOut(0);
});
$('div[class*=site-delete-yes]').live('click', function() {
  ajaxRequest.send({
    url: '/ajax/sites.php',
    data: 'type=remove&id='+siteDetailsID,
    preload: true,
    success: function(e) {
      $('tr[data-id='+siteDetailsID+']').remove();
    }
  });
  $('div.site-delete-approve').fadeOut(0);
});

$('a.link').live('click', function() {
  var preload = false;
  if($(this).attr('data-preload')) {
    preload = true;
  }
  ajaxRequest.send({
    url: '/ajax/' + $(this).attr('data-source') + '.php',
    data: $(this).attr('data-params'),
    preload: preload,
    success: function(e) {
      $.each(e, function(key, value) {
        $(key).html(value);
      });
    }
  });
});

$('a[class*=local]').live('click', function() {
  var rel = $(this).attr('rel');
  $.each($('div[class*=local-content]'), function(key, value) {
    $(value).fadeOut(0);
  });
  $.each($('a[class*=local]'), function(key, value) {
    $(value).parent().removeClass('active');
  });
  $('#content-'+rel).fadeIn(0);
  $(this).parent().addClass('active');
});

$(document).live('click', function() {
  $.each($('ul.dropdown-menu'), function(key, value) {
    //$(this).parent().removeClass('open');
    $('div.sites-context-menu').fadeOut(100);
    $.each($('tr.site'), function(key, value) {
      $(this).removeClass('hover');
    });
  });
});

var findSearchsCount = 0;
$('input[class*=sites-search-query]').live('keyup', function() {
  findSearchsCount++;
  $('a[rel=2]').click();
  $('div[class*=sites-search-query-pm]').fadeIn(0);
  ajaxRequest.send({
    url: '/ajax/sites.php',
    data: 'type=find&query=' + $(this).val(),
    success: function(e) {
      e = $.parseJSON(e.response);
      if(e.count < 1) {
        $('table#sites-list').fadeOut(0);
      } else {
        $('table#sites-list').fadeIn(0);
      }
      $('tbody.sites-body').html(e.html);
      findSearchsCount--;
      if(findSearchsCount == 0) {
        $('div[class*=sites-search-query-pm]').fadeOut(0);
      }
    }
  });
});

$('input[class*=show-error-sites]').live('change', function() {
  $('a[rel=2]').click();
});

$(function() {
  $('a').tooltip({
    placement: 'bottom'
  });
  $().collapse({
    toggle: false
  });
  $('table').tablesorter();
});