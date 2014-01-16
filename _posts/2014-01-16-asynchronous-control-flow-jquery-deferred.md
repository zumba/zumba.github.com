---
layout: post
title: Asynchronous Control Flow with jQuery.Deferred
description: How to adapt callback structures to callback queues using deferred objects (promises).
tags: [javascript, jquery, deferred-objects, promises, callbacks, dialogs, bootbox]
author: young-steveo
---

**Zumba&reg; Tech** is a big fan of javascript promises; they free our code from [callback hell](http://callbackhell.com/) by allowing us to use a more elegant and abstract structure.  With promises, asynchronous control flow becomes intuitive (first `a` and `b`, then `c`) and fun.  Today, I'll show you how to adapt a third party library that uses callbacks to a promise interface.

## We'll be using jQuery.Deferred
[Chris Saylor](https://github.com/cjsaylor) blogged about the node.js [async module](http://engineering.zumba.com/2013/11/06/handling-asynchronism-with-promises/) last November.  I'm going to focus on the client side for this post, but the principles apply to any environment.

There are many great promise libraries:

* [Q](https://github.com/kriskowal/q) &mdash; A tool for making and composing asynchronous promises
* [RSVP.js](https://github.com/tildeio/rsvp.js) &mdash; tools for organizing asynchronous code
* [when.js](https://github.com/cujojs/when) &mdash; the promise library from [cujoJS](http://cujojs.com/)

There's even a spec for [promises in ES6](https://github.com/domenic/promises-unwrapping).

However, until the native spec is fully supported we'll be using jQuery.Deferred <sup>[ [1] ](#footnote1)</sup> on the client.

## A Typical Scenario
We recently built a new internal app to handle some administrative tasks.  We used [Bootstrap](http://getbootstrap.com/) to get up and running quickly, and we stumbled upon a great library for handling our dialog boxes called [bootbox.js](http://bootboxjs.com/) from [Nick Payne](https://github.com/makeusabrew).

Here is a typical snippet of code, straight from bootbox:

<script src="https://gist.github.com/young-steveo/a5ee77a20aa2073b8693.js"></script>

With this code, bootbox will open a dialog containing the `"Hello world!"` text.  The callback is fired after the user clicks on the `"ok"` button and the `Example.show("Hello world callback");` code is executed.

This is already sweet, but soon we found ourselves writing a lot of boilerplate when we implemented the `confirm` dialogs:

<script src="https://gist.github.com/young-steveo/4f31aa607868c1e4b5bc.js#file-bootbox-confirm-example-js"></script>

That's not overly messy, but handling these conditions in every confirmation dialog with inline callbacks didn't appeal to us.

## Wrapping Bootbox With an Adapter
First we created a new object that wraps the bootbox logic.  We called it **Popper** (we're not always clever with lib naming).

<script src="https://gist.github.com/young-steveo/088f8cbd24b6d8da4368.js"></script>

### Returning a Deferred Object
The above snippet isn't very impressive.  However, now that we have a wrapper we can adapt the bootbox interface to use a deferred object:

<script src="https://gist.github.com/young-steveo/767257dcc8f02afed149.js"></script>

In effect, confirming the bootbox dialog will resolve the deferred object, and canceling the dialog will reject the deferred object.  Our implementation code now looks like this:

<script src="https://gist.github.com/young-steveo/2e738d200567bff63ea6.js"></script>

This has a couple of advantages:
* There are no more messy `if` blocks to parse; the code is more "flat".
* We've changed the flow of the application from using a single, multipurpose callback into using separate callbacks with unique concerns.

### jQuery.ajax returns a Deferred
There were many cases where we would fire off an ajax request after the user confirmed the dialog.  Since jQuery returns a deferred object from `$.ajax`, we were able to envelop that logic into our adapter as well:

<script src="https://gist.github.com/young-steveo/ef94a5f5efaed5daafca.js"></script>

## A Few Steps Further
The above code is nice, but there are still a few outstanding issues:
* `.done` and `.fail` are not very semantic method names for confirming or canceling a dialog.
* It would be nice to register callbacks that fire as soon as the buttons are clicked, and additional callbacks that fire after the ajax responds.

To solve these issues, we created a map of semantic method names (`ok` maps to `done`, `cancel` maps to `fail`, etc).  Popper's methods return a new object that contains these semantic methods, making our implementation code look beautiful:

<script src="https://gist.github.com/young-steveo/20f935fd9648865b6969.js"></script>

## The Source
Here's a link to the [full Popper.js source](https://gist.github.com/young-steveo/8463120).

## Conclusion
I hope I've expanded your toolbelt a little by showing you how to use a promise pattern in a real-world scenario.

Do you like the Popper lib?  Leave us a comment!

<a name="footnote1">[ 1 ]</a> <em> We know that [jQuery.Deferred](http://api.jquery.com/category/deferred-object/) objects are not Promise/A+ compliant, and we sympathize with why that's non-optimal.  However, since we are already using jQuery in most of our projects, jQuery.Deferred solves 95% of our needs without requiring us to depend on an additional library.</em>