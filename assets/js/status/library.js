$(document).ready(function() {
  data = {
    loading: $('#server1-server-status').html(),
    error: $('#error-template').html()
  };
  function update() {
    ajaxRequest.send({
      url: 'https://status.tooflya.com/ajax/status.php?server=server1',
      success: function(e) {
        $('#server1-server-status').html(e.server1);
      },
      error: function(e) {
        $('#server1-server-status').html(data.error);
      }
    });
    ajaxRequest.send({
      url: 'https://status.tooflya.com/ajax/status.php?server=server2',
      success: function(e) {
        $('#server2-server-status').html(e.server2);
      },
      error: function(e) {
        $('#games-status').html(data.error);
      }
    });
    ajaxRequest.send({
      url: 'https://status.tooflya.com/ajax/status.php?server=server3',
      success: function(e) {
        $('#server3-server-status').html(e.server3);
      },
      error: function(e) {
        $('#server3-server-status').html(data.error);
      }
    });
    ajaxRequest.send({
      url: 'https://status.tooflya.com/ajax/status.php?server=server4',
      success: function(e) {
        $('#server4-server-status').html(e.server4);
      },
      error: function(e) {
        $('#server4-server-status').html(data.error);
      }
    });
    ajaxRequest.send({
      url: 'https://status.tooflya.com/ajax/status.php?server=games',
      success: function(e) {
        $('#games-status').html(e.games);
      },
      error: function(e) {
        $('#games-status').html(data.error);
      }
    });
  }

  $(document).delegate(".update", "click", function() {
    $('#server1-server-status').html(data.loading);
    $('#server2-server-status').html(data.loading);
    $('#server3-server-status').html(data.loading);
    $('#server4-server-status').html(data.loading);
    $('#games-status').html(data.loading);

    window.setTimeout(function() {
      update();
    }, 1000);
  });

  window.setTimeout(function() {
    update();
  }, 1000);
});
