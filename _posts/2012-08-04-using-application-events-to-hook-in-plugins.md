---
layout: post
title: Using Application Events to Hook in Plugins 
description: How to use application level events to encapsulate core code from add-on code. 
tags: [events, plugins, add-ons, modules]
author: Chris Saylor
nickname: cjsaylor
---

In many instances, having a plugin system (even for closed-source applications) is a convenient and safe approach to adding functionality to a product.  It minimizes risk by not having to modify the core of the source.  In this article, I'll be discussing how we implemented a plugin system for our cart software to allow for plugins.

### Benefits of Plugins versus Adding the functionality in Place

* It prevents gargantuan classes to handle every situation that your software might need to handle.
* Allows for easier testing of the individual plugins.
* Provides various ways of including the plugins (including ways for filtering in specific situations).

### Event Horizon

Application events come in many shapes and sizes.  We chose to utilize a static class for "registering" the event to a callback method.

<script src="https://gist.github.com/efc61cb87783055d3c9e.js"> </script>

This adds a callable entry to the events array per event "tag".  Notice that `$events` can be an array, so assigning multiple events to the same callback is very easy to do.  Now all we need is a way to trigger the events we register to this class at runtime.

<script src="https://gist.github.com/36bd768ec37fdd697e81.js"> </script>

When triggering an event, we simply pass an array of data to the callback that was registered.  So all our callbacks should have a signature similar to: `public function someCallback($data = array())`.

Now we have all the tools we need in order to start registering and triggering events.

Many frameworks have started to provide this kind of application runtime events (which inspired this kind of system), such as [CakePHP 2.x](http://book.cakephp.org/2.0/en/core-libraries/events.html), as well as ORMs such as [Doctrine2](http://doctrine-orm.readthedocs.org/en/latest/reference/events.html).

### Plug and Play

Now that we have our event system in place, it's time to use it for our plugins.  There are many ways to include a "plugin" structure that I won't cover here.  What I will cover is once you have your plugin included, how to use our event system to call it.

We have several uses for plugins for our cart system. Chief among them is refreshing the status of the items in the cart on certain actions, such as when adding an item to the cart.  When structuring our plugin using an event system, we just need to expose a registration method that registers its own callbacks to all the events that it should listen for and react to when operations occur on the cart.  For example:

<script src="https://gist.github.com/9acaa7d1504e57ece36e.js"> </script>


### Conclusion

With this type of setup, when we need additional things to happen on certain actions, we don't have to go back and modify the core part of the app and risk introducing regression errors.  We simply write a plugin, register the event, and can concentrate the unit tests on the plugin callbacks themselves.