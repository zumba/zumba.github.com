---
layout: post
title: Schema.org Product Microdata and Breadcrumbs
description: How to solve the problem of breadcrumbs inside product page
tags: [schema.org, microdata, ecommerce, breadcrumbs, seo]
author: jrbasso
---

This week I was looking to improve our shop <abbr title="Search Engine Optimization">SEO</abbr> and
one of the things was the [microdata for HTML5](http://www.w3.org/TR/2011/WD-microdata-20110525/).
It is really cool feature from HTML5, helping crawlers to understand more about the site and providing
a better results for users. For example, Google shows rich snippets in their results, so you can see
page author, breadcrumbs, review information, product prices, etc. You can see few examples on
[Google Rich Snippets Testing Tool](http://www.google.com/webmasters/tools/richsnippets).

Looking the [Google Webmaster](http://support.google.com/webmasters/bin/answer.py?hl=en&answer=1211158)
documentation, they recommend do use the microdata from [schema.org](http://schema.org), which is a
schema made by search providers like Bind, Google, Yahoo! and Yandex. The schema contains a lot of types
useful for you website. This works very well in many cases, but some times it requires layout changes to
fit well.

Before I explain the problem, a little description of microdata in HTML5. Most of HTML tags can have the
attributes `itemprop`, `itemscope`, `itemtype`. The `itemprop` define the property name and usually the
content of the tag is the value, for example a name. `itemscope` define a block of properties, for example
a product. `itemtype` contains the URL which contais the definition of the `itemscope`.

It means that if you want to describe a product, you create a some `itemscope` with, for example, a `div`
and define all the properties there, like `name`, `price`, `reviews`, etc. It sounds great and worked for
almost everything in the page, except one thing: breadcrumbs! The [Product type](http://schema.org/Product)
do not have any property for categories or breadcrumbs, it is part from the
[WebPage type](http://schema.org/WebPage). But you can not define property for multiple scopes or in a
different scope with microdata.

Unfortunately I didn't find any solution with schema.org only, then I had to use schema.org and the
deprecated [data-vocabulary](http://www.data-vocabulary.org/). The code in the end was something similar
with that:

<script type="text/javascript" src="https://gist.github.com/4287cc6dbfefafac8bb2.js"> </script>

This is not the best solution, but it was the balance between do not change the layout because the
microdata and have a nice presentation in search provider results. I hope the schema.org cover it once
breadcrumbs are not restrict to WebPage type or any of the sub-types.

Do you have a better solution using microdata?