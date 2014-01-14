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
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>online</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
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
                $.tmpl('<div class="event" id="event-${eventID}"><img src="/assets/img/corp/${avatar}" width="50" height="50" class="avatar"><div class="left"><div class="profile-name">${name} ${surname}</div><div class="profile-post">${post}</div><div class="profile">User is <b>offline</b> now.</div></div><div class="clearfix"></div></div>',
                  {"id": event.id, "eventID": event.eventID, "avatar": event.avatar, "name": event.name, "surname": event.surname, "post": event.post}).prependTo("div.events");
                var eventDiv = $('div#event-'+eventID);

                eventDiv.fadeIn(700);
                setTimeout(function() {
                  eventDiv.fadeOut(700, function() {
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