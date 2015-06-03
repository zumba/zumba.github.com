// assuming 'registration' is an install service worker registration
registration.pushManager
  .getSubscription()
  .then(function (pushSubscription) {
    if (!pushSubscription) {
      return registration.pushManager.subscribe();
    } else {
      return pushSubscription;
    }
  })
  .then(function (pushSubscription) {
    // yay! a push subscription
  })
  .catch(function () {
    // hmm, something went wrong
  })