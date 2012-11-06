---
layout: post
title: Some CakePHP optimizations
description: Few tips in how optimize CakePHP applications to get better response times and save money
tags: [optimization, performance, cakephp, seo]
author: jrbasso
---

Our site and system has a lot of throughput and it make us use more instances and try to reduce the load
in every part. It makes the company happy (save money) and also make the customer happy (faster load).
On this article I will go over few things in terms of architecture and some code changes/strategies that
could make your application faster as well.

### Architecture

All our infra-structure is hosted by Amazon AWS. So, some tips are only for Amazon, but others can be
reused by other hosting.

1) Install [APC](http://php.net/apc) or any other opcode cache. It is kind of trivial, but just to make
sure.

2) Move things out of the box. We moved all our assets to [S3](http://aws.amazon.com/s3/) and
[CloudFront](http://aws.amazon.com/cloudfront/). It helps in two ways: 1) reduce the load in host boxes
([EC2](http://aws.amazon.com/ec2/)), giving more CPU and memory for the PHP applications 2) Allow the
browser to make more concurrent requests, once the host is usually different (ok, you can do the same
with the same box).

3) Scale a little vertical before go horizontal. We had an experience of using many boxes of small size
in Amazon EC2. But after some math and tests, we identified that getting few large instances is better
than many small instances. The server handle more request simultaneously and it is faster, and cheaper.
The cheaper is kind of weird to hear, because these boxes are expensive, but it is true. You can
replace like 5 medium instances (m1.medium) by one high-memory extra large (m2.xlarge).

4) Avoid network requests. They could be fast, but you always have the overhead of the protocol,
transmission, etc. I will give one example on the code portion.

### Code

1) Store the cake caches locally. All our cache is based on [Memcached](http://memcached.org/). The
internal cake caches (``_cake_core_`` and ``_cake_model_``) wasn't different. But these caches don't
change that often, so why use network for that? So we simply changed these 2 caches to use APC instead
of Memcache. It reduced couple milliseconds on each request with a ridiculous change.

2) Do you change your files often in production? Do you have an automatized deployment process? Do
you restart your webserver every deploy? If you answered yes for these questions, you may disable
the configuration ``apc.stat`` on production. This configuration, when enabled, makes the APC check
every request if the file you are trying to load was modified to re-create the opcode cache. If you
don't change the files in production, why re-check it? Disabling it make your code run mostly in memory
only.

3) Check your APC configurations. Don't let APC run out of memory enough to cache all your code.

4) Do you use cake query cache or cached view based on the model? If no, create a method on your
``AppModel`` called ``_clearCache`` and make it returns ``true``. Why? By default Cake do some
inflections and try loop thru the caches on the ``app/tmp/cache/`` folder to delete the cached files when
you make some database change operation (INSERT/UPDATE/DELETE). We did that and we got a huge improvement.
One reason is because our sessions are stored in database, causing a insert/update in every single request.

5) View cache. You can use cake view cache or other system, like [Varnish](https://www.varnish-cache.org/).
Depending of your system cake view cache is enough and give more flexibility, once you can still add some
PHP in the caches. Just be careful with restrict pages. Sometimes the cache will make it public for people
with the URL. See more details on [CakePHP Documentation](http://book.cakephp.org/2.0/en/core-libraries/helpers/cache.html).

6) ``requestAction`` and elements. Most of the sites has some dynamic content which need to render several
times, for example the site menu. Usually the content comes from database and you have to add the request
to the model into the ``AppController``. It causes one or more query per request, which probably is
unnecessary to do in all requests, once it will be the same for few minutes or even hours. The solution is
use the [``requestAction``](http://book.cakephp.org/2.0/en/controllers.html#Controller::requestAction)
inside the element and use the [cache element](http://book.cakephp.org/2.0/en/views.html#caching-elements).
All built-in CakePHP and very simple to use. In the end, after the first request (which could be a little
bit slower than usual because the ``requestAction``) the code will get the raw html rendered from the cache,
saving a good time and CPU from your database.

### Conclusion

The changes above show few actions you could do to improve your site performance and save money with your
hosting. There is much more tips to say, but I guess these are the most simple to implement in short time
and take advantage of the results.

Some of the tips or concept are valid for non-CakePHP sites as well. 