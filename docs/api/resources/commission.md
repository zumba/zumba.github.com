---
layout: default
title: Zumba API Commission Resource - Documentation
description: Commission resource documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li><a href="{{site_url}}/docs/api/resources">Resources</a></li>
	<li class="active">Commission</li>
</ul>

**TOC**

* [GET /commission](#getCommission)
* [GET /commission/next](#getNextCommission)

<hr>

<span id="getCommission"></span>

### `GET /commission` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Retrieve a history of commission payments.

**Parameters**

{:.table}
*Name* | *Description* | *Notes*
--- | --- | ---
`start_date` | <span class="label label-warning">Required</span> Date to begin looking for records. | 
`end_date` | Date to stop looking for records. | 
`type` | <span class="label label-warning">Required</span> Commission type (`?type=nutrition`) | `nutrition` type response requires nutrition scope permission.
`offset` | Number of records to offset on the request. | 
`max` | Number of records to return in the response. | 

**Response**

~~~
[
	{
		"date": "YYYY-MM-DD",
		"amount": Float,
		"currency": "USD",
		"commission_events": Integer,
		"status": Integer
	}
]
~~~

**Response Headers**

See [pagination documentation]({{site_url}}/docs/api/pagination.html) for the pagination handling mechanism.

<hr>

<span id="getNextCommission"></span>

### `GET /commission/next` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Retrieve info about the next commission payment.

**Parameters**

{:.table}
*Name* | *Description* | *Notes*
--- | --- | ---
`type` | <span class="label label-warning">Required</span> Commission Type (`?type=nutrition`) | `nutrition` type commission response requires nutrition scope permission.

**Response**

~~~
{
    "date": "YYYY-MM-DD",
    "amount": Float,
    "currency": "USD",
    "commission_events": Integer,
    "status": Integer
}
~~~

<hr>
