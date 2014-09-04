---
layout: default
title: Zumba API Hypermedia - Documentation
description: Hypermedia documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li class="active">Hypermedia</li>
</ul>

For responses that have ID links which also have supported lookup APIs, a hypermedia link will be provided as part of the response
that can be used to get more information about that resource.

If a resource supports hypermedia, the response will include a `_uris` entry with a link to the resource for the resource type.

Example:

~~~
{
  "_uris": {
    "class": "https://apiv3.zumba.com/class/1209012750124124"
  }
}
~~~
