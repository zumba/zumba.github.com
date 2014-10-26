---
layout: post
title: Caching CakePHP 2.x routes
description: Tutorial of how to cache the CakePHP 2.x routes.
tags: [php, cakephp, caching, routes, router, optimization]
author: jrbasso
---

At Zumba we are continuously looking for optimization in our applications. These optimizations helps
to reduce the server loads, consequently reducing the number of servers and saving money. Besides
that, it gives a better user experience for the end user since the user gets the content
faster and in some cases save on bandwidth (specially for mobile users).

This week we profiled our app using [Xdebug profiler](http://www.xdebug.org/docs/profiler) and we could
identify the router was responsible by a big part of the request time. In our main app we use over 130
custom routes and it makes CakePHP to generate an object for each route, and consequently parse and generate
a regex for each route, consuming some time and many function calls to do it.

Thinking in optimize that, we started looking options in how to optimize our routing process. After
few researches and deep checking in ours and CakePHP's code we found we could cache the routes easily.
The solution we found is easily applicable for many other CakePHP applications. Basically it consists
in exporting the compiled routes into a file and loading it instead of connecting them on every
request to the Router. This strategy is similar of how [FastRoute](https://github.com/nikic/FastRoute/blob/v0.2.0/src/functions.php#L32-L61)
caches their routes.

First, we moved all the `Router::connect()` to another file called `routes.connect.php`. On the `routes.php`
we added the logic for the caching. So, in the end we ended with something like this:

<script src="https://gist.github.com/jrbasso/37a6938b752b726b0a32.js?file=routes.connect.php"> </script>

<script src="https://gist.github.com/jrbasso/37a6938b752b726b0a32.js?file=routes.php"> </script>

We had couple options here. For example, we used `var_export` instead of `serialize`. It changes how the
application caches the file and add some extra steps to the process. Using `serialize` you can just cache
in memory (using some cache engine like APC), avoiding writing routes to the disk and avoiding to change
the default route class.

We choose to use `var_export` and dump the output to a file because it allows PHP to opcache the file,
avoiding to re-parse everything again on every request. Using `serialize` it generate a string that needs
to be parsed and executed on every request. Depending of your app and the number of routes that you have,
the use of `serialize` is simpler and faster than `var_export`. Just give a try on both and compare
the performance between them.

Using `var_export` brings some consequences, which is the requirement of implementing the magic method
`__set_state`. It is not done in CakePHP core until the version 2.5. I opened the PR
[cakephp/cakephp#4953](https://github.com/cakephp/cakephp/pull/4953) to support it on CakePHP 2.6+.
So, to solve this problem in CakePHP we created a class that extends Cake's `CakeRoute` to implement
the magic method and this looks like it:

<script src="https://gist.github.com/jrbasso/37a6938b752b726b0a32.js?file=ZumbaRoute.php"> </script>

PS: This code is not compatible with PHP 5.2. If you are using PHP 5.2, stop everything and upgrade
your PHP version.

So, with this class and changing the default route class in the `routes.php` you can cache the routes
using `var_export`. If you have plugins with routes you may need to change some other things. If you
have plugins but these plugins doesn't have any route, Cake automatically create a route to it using
the `PluginShortRoute` (which also doesn't implement the magic method). It means you probably will
have to remove these classes from your routes before build the cache. Knowing these limitations you
can also workaround this type of issue by creating another extended classes.

If you are wondering why we create a temporary file and rename it to the final filename it is to avoid
a concurrent issue between one request writing the file and another request reading the file at the
same time. It could be avoided by using file lock, but it would stop all concurrent requests
until the cache is finally done and stored on the disk. Using a temporary a file and renaming it
is an atomic operation, so it is avoided. Thanks [Jose Diaz Gonzalez](http://josediazgonzalez.com/about/)
([@savant](https://twitter.com/savant)) for pointing it out.

By the way, if you noticed the `sha1_file()` it prevents to clear any kind of cache when you change any
route on your `routes.connect.php`. Everytime you change the file, the SHA1 of the file will change
and consequently it will generate another cache file. It helps in our case to not worry about it
on deployments. We can just deploy the code and the new cache file will be automatically generated.

I would like to present some numbers of these changes, but it is very subjective because depends a
lot from the hardware (specially the disk), the number and type of routes, etc. What I can say is
for our case the time to load the routes are half of the time from connecting on every request and
to generate an URL using `Router::url()` (or via some helper/controller) it is 4 times faster on
the first route that hits the last route (usually the generic one from Cake).

One interesting thing we found on the tests were that loading the cached file and routing to the
first route was faster than connecting all the routes via `Router::connect()` and matching the first
route (which just compile one route).

In summary, the changes to cache the routes are small for most of the applications. There is
different approaches that you have to test and decide which one fits better to your application.
Also, some limitations could block your cache, but probably there is a workaround for it. If you
can't find, contact me and I can try to help you.
