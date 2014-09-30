var playtest = {
  information: false
};

function fade(b) {
  if(b) {
    $('div.canvas').fadeIn(0);
  } else {
    $('div.canvas').fadeOut(0);
  }
};
function available() {
  return window['App'] != undefined;
};

window.addEventListener("load", function() {
  $(document).delegate('#online-users-switch', 'click', function() {
    $('#users-online-block').fadeToggle(0);
  });

  /** vk.com **/
  window.vkAsyncInit = function() {
    VK.init({
      apiId: 3239022
    });

    VK.Widgets.Like("vk-like", {type: "button", height: 20});

    VK.Auth.launch = function(id) {
      VK.Api.call('users.get', {id: id, fields: 'photo_medium'}, function(e) {
        playtest.information = e.response[0];
        if(available()) {
          App.launch(false, {
            platform: 'vk',
            language: 1
          });
        }

        $('.mask').fadeOut(0);
        $('#vk').fadeOut(0);

        fade(true);
      });
    };
    VK.Auth.getLoginStatus(function(e) {
      if(e.session) {
        VK.Auth.launch(e.session.mid);
      } else {
        if(available() && App.launched()) return false;

        $('.mask').fadeIn(0);
        $('#vk').fadeIn(0);

        fade();

        $(document).delegate('#vk-login', 'click', function() {
          VK.Auth.login(function(e) {
            if(e.session) {
              VK.Auth.launch(e.session.mid);
            }
          }, VK.access.FRIENDS | VK.access.WALL);
        });
      }
    });
  };

  /** fb.com */
  window.fbAsyncInit = function() {
    FB.init({
      appId: 285942464946044,
      xfbml: true,
      version: 'v2.1'
    });

    FB.launch = function() {
      FB.api('/me', function(e) {
        playtest.information = e;

        FB.api('/me/picture', {
          "width": "100",
          "height": "100",
          "type": "normal"
        }, function(e) {
          playtest.information.photo_medium = e.data.url;

          if(available()) {
            App.launch(false, {
              platform: 'fb',
              language: 0
            });
          }

          $('.mask').fadeOut(0);
          $('#vk').fadeOut(0);

          fade(true);
        });
      });
    };
    FB.getLoginStatus(function(response) {
      if(response.status === 'connected') {
        FB.launch();
      } else {
        if(available() && App.launched()) return false;

        $('.mask').fadeIn(0);
        $('#vk').fadeIn(0);

        fade();

        $(document).delegate('#fb-login', 'click', function() {
          FB.login(function(e) {
            if(e.status === 'connected') {
              FB.launch();
            }
          }, {scope: 'user_friends'});
        });
      }
    });
  };

  /** twitter.com */
  !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

  setTimeout(function() {
    VK = false;
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "//vk.com/js/api/openapi.js?115";
    el.async = true;
    document.getElementById("vk_api_transport").appendChild(el);
  }, 1000);

  setTimeout(function() {
    FB = false;
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "//connect.facebook.net/en_US/sdk.js";
    el.async = true;
    document.getElementById("fb-root").appendChild(el);
  }, 1000);
});
