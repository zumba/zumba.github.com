var reg;
navigator.serviceWorker
  .getRegistration()
  .then(function (registration) {
    if (!registration) {
      return navigator.serviceWorker.register('/path/to/service-worker.js')
    } else {
      return registration
    }
  })
  .then(function (registration) {
    reg = registration;
    return reg.pushManager.getSubscription()
  })
  .then(function (pushSubscription) {
    if (!pushSubscription) {
      return reg.pushManager.subscribe();
    } else {
      return pushSubscription;
    }
  })
  .then(function (pushSubscription) {
    // save the pushSubscription in your database for later use
    return $http.post('/push/registration', pushSubscription)
  })