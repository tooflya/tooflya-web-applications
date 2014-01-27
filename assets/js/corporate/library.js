var signInID;

$('input').click(function(e) {
  e.preventDefault();

  return false;
});
$('li.sign-in').click(function() {
  if($(this).hasClass('save')) {
    $.each($('li[class*=sign-in]'), function(key, value) {
      $(this).removeClass('teammates-blur').removeClass('save');
    });
    $('div.teammates-password').fadeOut(0);
    $('div.teammates-info').fadeIn(0);
  } else {
    $('div.teammates-password').fadeOut(0);
    $('div.teammates-info').fadeIn(0);
    $(this).find('div.teammates-info').fadeOut(0);
    $(this).find('div.teammates-password').fadeIn(0).find('input').focus();
    $.each($('li[class*=sign-in]'), function(key, value) {
      $(this).removeClass('teammates-blur').removeClass('save');
    });
    $(this).addClass('save');
    $.each($('li[class=sign-in]'), function(key, value) {
      $(this).addClass('teammates-blur');
    });
    signInID = $(this).attr('data-id');
  }
});
$('#sign-out').click(function(e) {
  e.preventDefault();
  ajaxRequest.send({
      url: '/ajax/permissions.php',
      data: 'type=logout',
      preload: true,
      history: {
        url: '/corp/',
        state: {
          name: 'corp'
        }
      },
      success: function(e) {
      if(e.response) {
        $('#body').html(e.body);
      }
    }
  });
});
$('#add-task').click(function(e) {
  e.preventDefault();
  $('div[class*=teammates-tasks-add]').hide();
  $('div[class*=teammates-tasks-add-area]').show();
});
$('#edit-task').click(function(e) {
  checkCounts();
  e.preventDefault();
  $('div[class*=teammates-tasks-edit]').hide();
  $('div[class*=teammates-tasks-edit-area]').show();
});

var input;

$(document).on('click', '[class*=teammates-button]', function(e) {
  signin();
});
$(document).on('keypress', 'input, textarea', function(e) {
  $(this).removeClass('error');
});
$(document).on('change', 'select', function(e) {
  $(this).removeClass('error');
});
$('input[id*=teammates-password-input]').keypress(function(e) {
  if(e.which == 13) {
    signin();
  }
});
$('li.teammates-user').click(function() {
  update('user', {
    id: $(this).attr('data')
  });
});
$('#show-profile').click(function() {
  update('user', {
    id: 0
  });
});
$('.teammates-task').click(function() {
  update('task', {
    id: $(this).attr('data')
  });
});
$('[class*=task-change-status]').click(function() {
  update('task-change-status', {
    id: $(this).attr('data'),
    status: $(this).attr('status')
  });
  update('task', {
    id: $(this).attr('data')
  });
});
$('#show-total-events').click(function() {
  update('events', {
    user: false
  });
});
$('#show-user-events').click(function() {
  update('events', {
    user: true
  });
});
$('#show-settings').click(function() {
  update('settings', {
  });
});
$('[class*=delete-task]').click(function() {
  update('delete-task', {
    id: $(this).attr('data')
  });
});

signin = function() {
  var input = $('#teammates-password-input-'+signInID);
  ajaxRequest.send({
    url: '/ajax/permissions.php',
    history: {
      url: '/corp/',
      state: {
        name: 'user'
      }
    },
    data: 'id='+signInID+'&password='+$(input).val()+"&type=login",
    preload: true,
    success: function(e) {
      if(e.response) {
        $('#body').html(e.body);
      } else {
        $(input).addClass('error');
      }
    }
  });
};

var lastEventState;
$(window).bind('popstate', function(e) {
  e = e.originalEvent;

  if(JSON.stringify(e.state) == JSON.stringify(lastEventState)) return;
  lastEventState = e.state;

  if(e.state) {
    if(!e.state.params) {
      e.state.params = {
        pop: true
      };
    } else {
      e.state.params.pop = true;
    }

    update(e.state.name, e.state.params);
  } else {
    history.replaceState(true, null, window.location.pathname);
  }
});

var counts = {
  requirements: 0,
  requirements_ids:0,
  risks: 0,
  risks_ids:0
};

$('#add-requirements').bind('click', function() {
  counts.requirements++;
  counts.requirements_ids++;

  $.tmpl($('div#requirements-template').html(), {id: counts.requirements_ids}).appendTo("div#requirements");

  if(counts.requirements >= 10) {
    $('#add-requirements').hide();
  } else {
    $('#add-requirements').show();
  }
});
$('#add-risks').bind('click', function() {
  counts.risks++;
  counts.risks_ids++;

  $.tmpl($('div#risks-template').html(), {id: counts.risks}).appendTo("div#risks");

  if(counts.risks >= 10) {
    $('#add-risks').hide();
  } else {
    $('#add-risks').show();
  }
});

$(document).on('click', 'a[class*=remove-requirements]', function() {
  counts.requirements--;

  var id = $(this).attr('data');

  $('#requirements-'+id).fadeOut(function() {
    $('#requirements-'+id).remove();
  });

  if(counts.requirements >= 10) {
    $('#add-requirements').hide();
  } else {
    $('#add-requirements').show();
  }
});
$(document).on('click', 'a[class*=remove-risks]', function() {
  counts.risks--;

  var id = $(this).attr('data');

  $('#risks-'+id).fadeOut(function() {
    $('#risks-'+id).remove();
  });

  if(counts.risks >= 10) {
    $('#add-risks').hide();
  } else {
    $('#add-risks').show();
  }
});

$('#save-task').click(function() {
  var post = "";
  var id = $('#task-receiver').val();
  var name = $('#task-name').val();
  var description = $('#task-description').val();
  var type = $('#task-type').val();
  var priority = $('#task-priority').val();
  var number = $('#task-number').val();

  post += '&name=' + name;
  post += '&description=' + description;
  post += '&task_type=' + type;
  post += '&priority=' + priority;
  if(number) post += '&number=' + number;

  if(!name) { $('#task-name').addClass('error').focus(); return; }
  if(!description) { $('#task-description').addClass('error').focus(); return; }
  if(type < 1 || type > 5) { $('#task-type').addClass('error').focus(); return; }
  if(priority < 1 || priority > 3) { $('#task-priority').addClass('error').focus(); return; }

  for(var i = 1; i < counts.requirements_ids + 1; i++) {
    if(!$('#requirements-'+i).html()) continue;

    var name = $('#requirement-name-'+i).val();
    var description = $('#requirement-description-'+i).val();
    var points = $('#requirement-points-'+i).val();
    var priority = $('#requirement-priority-'+i).val();

    post += '&requirement-name-'+i+'=' + name;
    post += '&requirement-description-'+i+'=' + description;
    post += '&requirement-points-'+i+'=' + points;
    post += '&requirement-priority-'+i+'=' + priority;

    if(!name) { $('#requirement-name-'+i).addClass('error').focus(); return; }
    if(!description) { $('#requirement-description-'+i).addClass('error').focus(); return; }
    if(points < 1 || points > 10) { $('#requirement-points-'+i).addClass('error').focus(); return; }
    if(priority < 1 || priority > 3) { $('#requirement-priority-'+i).addClass('error').focus(); return; }
  }

  for(var i = 1; i < counts.risks_ids + 1; i++) {
    if(!$('#risks-'+i).html()) continue;

    var name = $('#risk-name-'+i).val();
    var description = $('#risk-description-'+i).val();
    var points = $('#risk-points-'+i).val();

    post += '&risk-name-'+i+'=' + name;
    post += '&risk-description-'+i+'=' + description;
    post += '&risk-points-'+i+'=' + points;

    if(!name) { $('#risk-name-'+i).addClass('error').focus(); return; }
    if(!description) { $('#risk-description-'+i).addClass('error').focus(); return; }
    if(points < 1 || points > 10) { $('#risk-points-'+i).addClass('error').focus(); return; }
  }

  ajaxRequest.send({
    url: '/ajax/corporate.php',
    data: "type=add-task&id="+id+""+post,
    preload: true,
    button: $('#save-task'),
    text: "Wait for a while...",
    success: function(e) {
      if(e.response) {
        $('#body').html(e.body);

        $('div[class*=teammates-tasks-add]').show();
        $('div[class*=teammates-tasks-add-area]').hide();

        update('user', {
          id: id
        });
      }
    }
  });
});

/* ================================================================================ */
/* =                                                                              = */
/* ================================================================================ */

function update(id, params) {
  switch(id) {
    case 'events':
      ajaxRequest.send({
        url: '/ajax/corporate.php',
        history: {
          url: params.user ? '/corp/events/user/' : '/corp/events/',
          state: {
            name: 'events',
            params: params
          }
        },
        data: params.user ? 'type=events&user=true' : 'type=events',
        preload: true,
        success: function(e) {
          if(e.response) {
            $('#body').html(e.body);
          }
        }
      });
    break;
    case 'user':
      ajaxRequest.send({
          url: '/ajax/corporate.php',
            history: {
              url: params.id ? '/corp/user/'+params.id+'/' : '/corp/',
              state: {
                name: 'user',
                params: params
              }
            },
          data: 'id='+params.id+'&type=profile',
          preload: true,
          success: function(e) {
          if(e.response) {
            $('#body').html(e.body);
          }
        }
      });
    break;
    case 'task':
      ajaxRequest.send({
          url: '/ajax/corporate.php',
            history: {
              url: params.id ? '/corp/task/'+params.id+'/' : '/corp/',
              state: {
                name: 'task',
                params: params
              }
            },
          data: 'id='+params.id+'&type=task',
          preload: true,
          success: function(e) {
          if(e.response) {
            $('#body').html(e.body);
          }
        }
      });
    break;
    case 'settings':
      ajaxRequest.send({
          url: '/ajax/corporate.php',
            history: {
              url: '/corp/settings/',
              state: {
                name: 'settings',
                params: params
              }
            },
          data: 'type=settings',
          preload: true,
          success: function(e) {
          if(e.response) {
            $('#body').html(e.body);
          }
        }
      });
    break;
    case 'delete-task':
      ajaxRequest.send({
        url: '/ajax/corporate.php',
        data: 'type=delete-task&id='+params.id,
        preload: true,
        success: function(e) {
          if(e.response) {
            update('user', {
              id: e.receiver
            });
          }
        }
      });
    break;
    case 'task-change-status':
      var comment = $('#task-review-comment').val();

      ajaxRequest.send({
        url: '/ajax/corporate.php',
        data: 'type=task-change-status&id='+params.id+'&status='+params.status+'&comment='+comment,
        preload: true,
        success: function(e) {
          if(e.response) {
            update('task', {
              id: params.id
            });
          }
        }
      });
    break;
  }
}