'use strict';

self.onpush = function receivePush (event) {
  event.waitUntil(
    self.registration.showNotification(event.data.myNotificationTitle, {
      body: event.data.myNotificationMessage,
      tag: event.data.myNotificationTag
    })
  )  
}
