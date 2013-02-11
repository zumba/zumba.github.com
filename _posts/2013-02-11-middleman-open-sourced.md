---
layout: post
title: Middleman.js Project Open Sourced
description: A library giving you control over the execution of third party libs.
tags: [javascript, overloading, context, middleman]
author: young-steveo
---

We're on a roll this week, and it's only Monday! Yesterday Chris Saylor introduced [Mongounit](http://engineering.zumba.com/2013/02/10/mongounit-open-sourced/). Today I am going to show you another open source project we've written called [Middleman.js](https://github.com/zumba/middleman.js)

Middleman is a javascript library that can be used in a browser or as a node.js module.  It allows you to hook into the execution of any function to apply prefiltering to that function's arguments; globally change the function's execution context; pipe that function's arguments to several others; or, overload the function to behave differently.  It does all this for you seamlessly, so you can simply call the original function as you normally would.

### Example
For a practical example we need to start with some assumptions: You have a new mobile project that communicates with a RESTful server API.  After a few weeks of development some project requirements change and now every ajax url must start with `/api`.

1. You don't want to manually find every ajax call in the project and prepend the url strings with `/api`.
2. You don't want to force your team to remember to do this as you develop.
3. You want to implement this new requirement as seamlessly as possible.

jQuery's powerful ajax methods are well known, but let's say you're working with a more simplified library like [Zepto.js](http://zeptojs.com) which was built for mobile. Middleman.js can solve this problem with just a few lines:

<script src="https://gist.github.com/young-steveo/be236d9dee00f9f0f088.js?file=middleman-example.js"> </script>

### Seamless
You can call `$.ajax` as you normally would.  The filter method will be executed first, and the array `args` that is returned by the filter method will be passed to the original `$.ajax` method as parameters.

Object *references* are passed by value in Javascript, which is why you don't see me doing anything with the `ajaxSettings` variable after I've modified it's `url` property.  See [this](http://docstore.mik.ua/orelly/webprog/jscript/ch11_02.htm) for more details.

### Context
In the previous example, Middleman will use the `lib` object for context when executing the ajax method (in this case Zepto.js).  However, Middleman can also take an optional `context` parameter that will be used instead, like this:

<script src="https://gist.github.com/young-steveo/be236d9dee00f9f0f088.js?file=middleman-context-example.js"> </script>

Notice that the context of the `stringify` method became `Array`.  Had I passed `context : Object,` instead, the output would have been `[object Array]` instead of `a,b,c,d`.  You've probably seen this kind of behavior in other popular libraries like [Underscore.js](http://underscorejs.org/)'s `_.bind` method.

### Final word
Currently there is no way to disable Middleman's meddling once you've called the map function.  We're planning to incorporate an internal registery in a future release that will allow you to inspect the Middleman object to see what methods have been overloaded, and also make it easy for Middleman to flip it's filters on or off at a granular level.

* Repository - [Middleman.js](https://github.com/zumba/middleman.js)
* License - MIT