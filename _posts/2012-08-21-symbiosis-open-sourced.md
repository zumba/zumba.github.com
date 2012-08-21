---
layout: post
title: Symbiosis Project Open Sourced 
description: Zumba&reg;'s first open source project, Symbiosis, has been open sourced. 
tags: [events, plugins, add-ons, modules, open-source, symbiosis]
author: cjsaylor
---

I'm excited to announce that we have open-sourced our first project: [Symbiosis](https://github.com/zumba/symbiosis).  [Symbiosis](https://github.com/zumba/symbiosis) is a PHP library that allows for easy integration of an event driven plugin system to any PHP project.  It also allows the event system to be used stand-alone from the plugin system.

### Plug Me In

In a [previous post]({{ site.url }}/2012/08/04/using-application-events-to-hook-in-plugins/), I described how we used a rudamentary event system to modularize our cart system.  Now, we've taken a big step in making that sort of modularization easy to implement in many of our projects, and hopefully many of yours.  There are many differences between our example in the [previous post]({{ site.url }}/2012/08/04/using-application-events-to-hook-in-plugins/) and our open-sourced version:

1. The event that gets passed to the listeners is now an object.  Instead of just passing an array of data, we pass an event object. Not only is the data available, but several key flow control methods as well.  Such as stopping propagation of the event, suggesting the client prevent further actions, as well as an easy way to trigger the event.
2. We've included the plugin system.  Prior, we wrote off how to include the plugin, but with an event driven mechanism, I realized that this was an important step.  The plugin manager included with [Symbiosis](https://github.com/zumba/symbiosis) includes a couple of key attributes.  While developing with a rudamentary version of the plugin manager, I quickly realized that we needed to be able to control the order of some plugins.  I've added a priority order to the plugin framework that allows you to set the order in which the plugins are executed.  I've also added the ability to disable plugins from startup.

### Example of Symbiosis in Action

With a few lines of code, you can see how easy it is to include a plugin system in your PHP project:

First we construct our plugin:

<script src="https://gist.github.com/3414629.js?file=application_plugin.php"> </script>
<noscript>All example code is available in a github gist: https://gist.github.com/3414629</noscript>

The plugin must extend `\Zumba\Symbiosis\Framework\Plugin` to implement all the proper methods and have default attributes.

Next, we register the plugins in the application bootstrap:

<script src="https://gist.github.com/3414629.js?file=application_bootstrap.php"> </script>

And finally, somewhere in our application, we need to trigger the event that the plugin is listening:

<script src="https://gist.github.com/3414629.js?file=application_somewhere.php"> </script>

When the event is triggered, the anonymous function we registered in our sample plugin should execute:

<script src="https://gist.github.com/3414629.js?file=output.txt"> </script>

### Conclusion

We found this project useful in our own applications, and we hope that you may find it useful as well.  We've included a way of installation either via a git submodule, [download](https://github.com/zumba/symbiosis/downloads), or a [composer](http://getcomposer.org/) install.  The project has 100% code coverage in [PHPUnit](http://www.phpunit.de/manual/current/en/) tests, and we feel comfortable with it's stability.

You can see more examples and full documentation on the [Symbiosis Wiki](https://github.com/zumba/symbiosis/wiki).

If you see anything that could be improved, let us know by opening an issue in the github project, or submit a patch.