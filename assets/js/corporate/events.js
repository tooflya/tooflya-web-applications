(function poll(){
    $.ajax({
      url: "/ajax/events.php",
      async: true,
      cache: false,
      dataType: "json",
      timeout: 30000,
      success: function(e) {
        if(e.response == 2) return;
        e = $.parseJSON(e.response);
        $.each(e, function(i, item) {console.log(e);
          var eventMessage;
          switch(i) {
            case 'online':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>online</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'offline':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>offline</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'add-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">Added <b>new task</b> to the service.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'remove-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile"><b>Remove task</b> from service.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'edit-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile"><b>Change a task</b> in the service.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'start-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>took</b> up the task.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'check-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>send a task</b> to upprove.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'cancel-checking-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile"><b>Cancel approve proccess</b> task.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
              });
            break;
            case 'complete-task':
              $.each(item, function(j, event) {
                var eventID = event.eventID;
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile"><b>Successfully complete</b> a task.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
                    $(this).remove();
                  });
                }, 5000);
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
        }, 100);
      }
    });
})();