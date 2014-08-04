var playtest = {
  information: false
};

window.addEventListener("load", function() {
  window.vkAsyncInit = function() {
    VK.init({
      apiId: 3239022
    });

    VK.Auth.launch = function(id) {
      VK.Api.call('users.get', {id: id}, function(e) {
        playtest.information = e.response[0];
        App.launch();

        $('.mask').fadeOut(500);
        $('#vk').fadeOut(500);
      });
    };
    VK.Auth.getLoginStatus(function(e) {
      if(e.session) {
         VK.Auth.launch(e.session.mid);
      } else {
        $('.mask').fadeIn(500);
        $('#vk').fadeIn(500);
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

  setTimeout(function() {
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "http://vk.com/js/api/openapi.js??115";
    el.async = true;
    document.getElementById("vk_api_transport").appendChild(el);
  }, 1000);
});