$(document).ready(function() {
  data = {
    loading: $('#loading-template').html(),
    error: $('#error-template').html()
  };
  function update() {
    ajaxRequest.send({
      url: '//games.tooflya.com/',
      success: function(e) {
        $('#games-status').html(e.response);
      },
      error: function(e) {
        $('#games-status').html(data.error);
      }
    });
  }

  $(document).delegate(".update", "click", function() {
    $('#games-status').html(data.loading);

    window.setTimeout(function() {
      update();
    }, 1000);
  });

  window.setTimeout(function() {
    update();
  }, 1000);
});
