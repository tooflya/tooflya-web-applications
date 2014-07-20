$(document).ready(function() {
  ajaxRequest.send({
    url: 'https://status.tooflya.com/ajax/status.php',
    success: function(e) {
      if(e.response) {
        $('#server1-server-status').html(e.server1);
        $('#server2-server-status').html(e.server2);
      }
    }
  });
});
