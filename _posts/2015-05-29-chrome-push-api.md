---
layout: post
title: W3C Push API Crash Course
description: This is how we do CSS at Zumba.
tags: [technology, push, web, w3c, javascript]
author: nkcmr
---
W3C’s [Push API](http://www.w3.org/TR/push-api/) is exciting. Almost as exciting as all the possibilities that arise from having a persistent presence in your users browser. At Zumba, we already have ideas for it, and I was in charge of doing the gritty work of getting notifications to show up in the browser, but also developing a way to manage who gets what notifications. I had a lot of questions along the way, and I will lay them out and give you straight answers. Let's get pushing already!

## The ServiceWorker
The [**ServiceWorker**](https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorker) is where the Push API lives. A **ServiceWorker** is a JavaScript file that defines activities that are allowed to run continuously, well after the life-cycle of a web-page. If you have heard of [**WebWorkers**](https://developer.mozilla.org/en-US/docs/Web/API/Worker/Worker), ServiceWorkers are quite similar but like I said, they will continue to work in the background even after a user has closed the web-page, which is obviously key to being available to show notifications.

### ServiceWorker Registration
Now before we get started with registering you need to set up a Google Application that can be used with Google Cloud Messaging to actually send the notifications, it is free for development and takes about 2-3 minutes.

#### Google Application Setup
1. Go to [Google Developer Console](https://console.developers.google.com) and **create** a new application.
2. Note your new applications **Project Number**:
<img src="/img/blog/google-api-console-app-id.png" alt="Google API Project Number" class="img-responsive"/>
3. Go to the new application and under **APIs & auth** click **APIs** and look for "messaging" and enable:
  - *Google Cloud Messaging for Chrome*
  - *Google Cloud Messaging for Android*
4. Under the same sidebar menu, go to **Credentials** and generate new **Public API access** keys for **server**. Keep them handy for a little later on.

#### manifest.json
Google Chrome relies on a simple JSON file to detect your websites Google Cloud app. It is placed in the root of your website and it goes a little something like this:
{% gist 81e37636d6b0a55788f1 manifest.json %}
Replace `application_project_number` with the project number of your Google App from the steps above. Moving on!

---

#### ServiceWorker Life-Cycle
ServiceWorkers have a registration process that goes through the following steps:

- **install**: currently being installed
- **waiting**: waiting on registration
- **active**: registered and running

---

#### Scope
ServiceWorkers also have a *scope* which is set to the directory under which it can be found. For example, if your service worker script is located at `/static/js/muh/scripts/ServiceWorker.js` Then its *scope* will be: `/static/js/muh/scripts/`. This will not work; your users will not be doing their browsing in your static assets, so placing this script further up the directory tree is highly recommended. Service Workers also will not install if not served over HTTPS.

#### Registering
Now that you know what to expect with setting up a suitable environment for your service worker let’s get it installed.

Now, a good installation script should also consider that their might be a service worker already in place and running. A lot of other examples want to go straight to registering a service worker, but that will give you a bunch of redundant service workers. To check for that let’s do the following:
{% gist 81e37636d6b0a55788f1 check-sw-reg.js %}
Now that we have the installation status we know if we need to register a service worker or not. So let's say we do. Then we do this:

{% gist 81e37636d6b0a55788f1 reg-sw.js %}

**ServiceWorkerRegistrations** are important to push because they hold the key to our next step which is the **PushManager**. Once we have a reliable way to either register a ServiceWorker or retrieve an existing ServiceWorker's registration, we can continue to...

### The PushManager
The **PushManager** is a creatively named API that manages our push subscriptions. The entry point for it can be found on that `ServiceWorkerRegistration` I mentioned above. You should take the same approach with this as with service worker registrations. The functions you should know about are: `getSubscription` and `subscribe`.
{% gist 81e37636d6b0a55788f1 pm-get-sub.js %}
As you can see here, we check for an existing push subscription, then if one is not found we attempt to get permission for one. This attempt is when the user is prompted to approve notifications.

### Putting It Together
So, putting the two together, you probably end up with something like this:

{% gist 81e37636d6b0a55788f1 sw-pm-together.js %}

This will auto-register a service-worker and will subscribe your website to push notifications and send the push subscription to your server.

#### PushSubscription
Providing that everything went well, and the user agreed to be notified, you will be given a **PushSubscription** object that will contain details about how to execute a push notification. ([PushSubscription](http://www.w3.org/TR/push-api/#idl-def-PushSubscription)) This object contains an `endpoint` attribute which is the entry point for push notifications. (The Push API is still in flux, but I would recommend keeping the `endpoint`; Google is the only one running a W3C compliant push server but I am sure there will be more to come and this will be what distinguishes them.)

What will distinguish this user is the `subscriptionId`, this is like a device ID of sorts and will be how you reach this user in particular with your push notifications.

#### Using the PushSubscription
Once you have the `subscriptionId`, you can send it to Google Cloud Messaging endpoint like so:

{% gist 81e37636d6b0a55788f1 gcm-send-req.sh %}

Put your Google Cloud project API key next to `key=` and put the users `subscriptionId` in `registration_ids` and this will send notifications but we need to tell the service worker how to receive them, and what to do with them.

#### Receiving Notifications with ServiceWorker
Obviously, ServiceWorkers run in a completely different global context than a DOMWindow. The global object in a ServiceWorker is `self`, and the event to look out for is `onpush`. A very simple notifier service worker will look something like this:

{% gist 81e37636d6b0a55788f1 simple-service-worker.js %}

This will extract that push data out of the event and show it as a notification.

### The Bad News
W3C's Push API is very new. Google Chrome is the only browser to begin working on implementation and it still isn't finished. With that in mind, the Chromium development team has intentionally blocked arbitrary data from being sent through the Push API for now [(chromium issue #449184)](https://code.google.com/p/chromium/issues/detail?id=449184). The reason stated is that as of right now, the API does not mandate encryption of incoming push messages. Without mandatory encryption, anyone can easily use a [Man-in-the-middle attack](https://en.wikipedia.org/wiki/Man-in-the-middle_attack) to put bad data into push messages.

As stated in the linked chromium issue, push messages are really just fancy pings at this point. But those pings *can* be used to tell clients to fetch the latest data from your servers.

---

I will continue to follow the Push API and keep this article updated if any important developments occur. Drop me a line on [twitter](https://twitter.com/nkcmr) if you have any questions. Happy pushing!

#### Other Helpful Resources:
- [Introduction to Service Worker](http://www.html5rocks.com/en/tutorials/service-worker/introduction/)
- [MDN: ServiceWorker API](https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorker_API)
- [Jake Archibald: The ServiceWorker is coming, look busy \| JSConf EU 2014](https://www.youtube.com/watch?v=SmZ9XcTpMS4)
