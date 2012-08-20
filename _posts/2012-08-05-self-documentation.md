---
layout: post
title: Creating Self Documentation to your API
description: Show an idea how to self document the API endpoints using code
tags: [api, documentation, annotation]
author: jrbasso
---

When we started our internal web-service we had a problem between the team that works in
the web-service application and the front end developers because the front end
developers didn't know exactly what was the expected parameters, endpoints, HTTP verb,
etc. This increased the delay in delivery features and in some cases caused a few bugs.

Looking at the problem, [Chris Saylor](https://github.com/cjsaylor) had a great
idea to use the controller annotation and generate a page with that. He started with
some proof of concept, which was very well accepted by the front end developers and than
Chris and I improved that page content and layout.

As part of the page content improvement, we started to use our own annotations, similar
many projects do, ie:
- [PHPDoc](http://www.phpdoc.org/docs/latest/for-users/list-of-tags.html)
- [PHPUnit](http://www.phpunit.de/manual/current/en/appendixes.annotations.html)
- [Doctrine](http://doctrine-orm.readthedocs.org/en/latest/reference/annotations-reference.html)
- [Symfony](http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html#annotations-for-controllers)

We created tags like `@inputParam`, `@optionalInputParam`, `@returnParam`, etc. It helped
us to create a more useful documentation page, with more relevant information for front end
developers instead of a regular PHP documentation that doesn't help front end developers at all.

In our web-service we created a method that reponse HTML or JSON, depending of
`Accept` header. If the browser requests the site, it accepts `text/html` and we provide a
HTML page using [Twitter Bootstrap](http://twitter.github.com/bootstrap/) with
[jQuery](http://jquery.com) and make an AJAX request to the same URL, getting the JSON version
(that is usually what our web-service response) and generating the HTML with all URI and
parameters required for that.

Below is an example of our JSON response:
{% gist 3266700 %}

With jQuery we loop thru all the controllers and actions and generate the page. Also we
have a search with jQuery to filter results, making the life much easier to front end
developers.

<img src="{{ site.url }}/img/blog/service_documentation.png" alt="Service Documentation Sample View">

Before you ask why we separate the HTML in one file and the content in an AJAX, the answer is
simple. Our web-service is designed to performance and always response in JSON (yes, we can
support different outputs, but it is our internal web-service and we don't want to add more
complexity). The HTML portion is a static file, not a PHP file. Another reason is make
this method reusable, like we have for our web test interface (I will describe in another
post).

<script type="text/javascript">
	// Hack to fix the reddit link, because this link was inserted without the end slash
	reddit_url = 'http://engineering.zumba.com/2012/08/05/self-documentation';
</script>
