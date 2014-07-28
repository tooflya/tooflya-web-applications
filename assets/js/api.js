$(document).ready(function() {
  $(document).delegate(".show-example", "click", function() {
    var data = $(this).data("call");

    $('#'+data).slideToggle();
  });
});