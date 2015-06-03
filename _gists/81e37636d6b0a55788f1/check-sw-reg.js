// the service worker api entry point is navigator.serviceWorker
navigator.serviceWorker
  .getRegistration()
  .then(function (registration) {
    // 'registration' is an instance of ServiceWorkerRegistration, see here:
    // http://www.w3.org/TR/service-workers/#service-worker-registration-interface
    if (!registration) {
      // there is no service worker installed!
    } else {
      // there is one installed, and it is either 'waiting'
      // or 'active', so no need to re-register
      return registration
    }
  })