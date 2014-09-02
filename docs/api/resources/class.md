---
layout: default
title: Zumba API Class Resource - Documentation
description: Class resource documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li><a href="{{site_url}}/docs/api/resources">Resources</a></li>
	<li class="active">Class</li>
</ul>

**TOC**

* [GET /class/:id](#getClass)
* [GET /class/:id/students](#getClassStudents)
* [POST /class/:id/invite](#postClassInvite)

<hr>

<span id="getClass"></span>
### `GET /class/:id`

> Retrieve information about a class

**Response**

```
{
  "id": String,
  "start_time": "00:00:00+00:00",
  "end_time": "00:00:00+00:00",
  "day_of_week": Integer,
  "type": String,
  "instructor": {
    "user_id": String,
    "first_name": String,
    "last_name": String,
    "email_address": String
  },
  "location": {
    "name": String,
    "street": String,
    "street_2": String,
    "city": String,
    "state": String,
    "country": String,
    "postal_code": String
  }
}
```

<hr>

<span id="getClassStudents"></span>
### `GET /class/:id/students`

> Retrieve student list with statuses for all students associated to an instructor's class.

**Response**

```json
[
  {
    "user_id": String,
    "first_name": String,
    "last_name": String,
    "email_address": String,
    "status": Integer
  }
]
```

`status` can be:

{:.table}
*Status* | *Description*
--- | ---
`0` | Not current in payment.
`1` | Current in payment.

<hr>

<span id="postClassInvite"></span>
### `POST /class/:id/invite` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Generates an invitation to a class


**Post Parameters**

{:.table}
*Field* | *Type* | *Requirement*
--- | --- | ---
email_address | String | <span class="label label-warning">Required</span>
first_name | String | <span class="label label-warning">Required</span>
last_name | String | <span class="label label-warning">Required</span>

**Response**
* HTTP 201 (Created) - An event will be created that will trigger the email invitation if user does not exist or it's not associated to a class
* HTTP 409 (Conflict) - If the user is already registered in a class of the same type.

