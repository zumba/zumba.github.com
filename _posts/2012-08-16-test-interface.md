---
layout: post
title: Creating a testing interface for your API
description: Tired to use curl, crap scripts, remember fields to test your API? Make a simple interface to make it easily.
tags: [api, annotation, test, tools]
author: jrbasso
---

Couple months ago we started an integration with [Ooyala](http://www.ooyala.com), using JSON API.
They provide the [documentation](http://support.ooyala.com/developers/documentation/concepts/book_api.html) to the methods
and I saw they have a simple interface to test their methods: [Ooyala API Scratchpad](https://api.ooyala.com/docs/api_scratchpad?url=/assets&method=GET).
This interface was very useful while we integrate with them and I thought: *"Why we don't have one interface like that for our API?"*

I started a page with [Twitter Bootstrap](http://twitter.github.com/bootstrap/) to have a similar functionality, which the goal
was to get an interface easy to developers see the response for multiple HTTP protocols, set the parameters, etc.
The initial page looks like this:

![API Test Page]({{ site.url }}/img/blog/test-interface-1.png)

For the request, I used [jQuery](http://jquery.com) AJAX. It means that some HTTP methods (usually `PUT` and `DELETE`)
are not supported by old browsers, but we don't care as it is an internal tool and everybody uses Chrome or Firefox.
Doing the request you get a JSON response formatted, like that:

![API Test Page Response]({{ site.url }}/img/blog/test-interface-2.png)

Developers liked this page, but it wasn't good enough to me. Then I get the response from
[Creating Self Documentation to your API]({{ site.url }}/2012/08/05/self-documentation/) (also thru AJAX) and made an
autocomplete integrated with the parameters generation. Resulting something like that:

![API Test Page Autocomplete]({{ site.url }}/img/blog/test-interface-3.png)
![API Test Page Parameters]({{ site.url }}/img/blog/test-interface-4.png)

This exemplifies how the annotations are important. We get all the API methods, method descriptions, method parameters,
HTTP method, etc. from the annotation and generate nice pages like that.

The productivity of using this page was greatly improved with not having to toggle between the tester and the documentation.
As it is an internal tool, why not complement adding some request log in this tool to show possible errors or behaviors?!
I got some help from [ChromePHP](http://www.chromephp.com/) (that put log messages on the response header), integrated
with our log system and then parsed it from the response, showing in the page as well.

![API Test Page Logs]({{ site.url }}/img/blog/test-interface-5.png)

After have it in our API, we started this blog and looking the [Disqus API](http://disqus.com/api/docs/) I saw they have
a similar tool called [Disqus Console](http://disqus.com/api/console/). Again, it helped me with some integration.
If you have an API, make this type of tool for you client. He definitely will like it.

### Conclusion

I spent one day to create this tool and people are saving time every day. It means sometimes you should take a break
and spend some time doing simple tools to gain in long term.

You can see what annotations, some open source projects and few lines of code are able to do. Use it! As I told
in the annotations post, it is a simple thing with many benefits.

Do you want the code of that page? Sure, why not?! <https://gist.github.com/3365894>.
