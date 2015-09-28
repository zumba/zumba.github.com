---
layout: default
title: Zumba API Membership Resource - Documentation
description: Membership resource documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li><a href="{{site_url}}/docs/api/resources">Resources</a></li>
	<li class="active">Class</li>
</ul>

**TOC**

* [GET /membership/status](#getMembershipStatus)

<hr>

<span id="getMembershipStatus"></span>


### `GET /membership/status`

> Retrieve a user's membership details.

**Scope required**: `membership_status`

**Response**

~~~
{
  "member_valid_until": String (format "YYYY-mm-dd"),
  "member_cancelled_on": String (format "YYYY-mm-dd") or `null`,
  "user_pid": String
}
~~~
