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
* [POST /class/:id/student](#postClassStudent)
* [GET /class/:id/students](#getClassStudents)

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

<span id="postClassStudent"></span>
### `POST /class/:id/student` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Generates notification for user to create account


**Post Parameters**

{:.table}
*Field* | *Type* | *Requirement*
--- | --- | ---
email_address | String | <span class="label label-warning">Required</span>
first_name | String | <span class="label label-warning">Required</span>
last_name | String | <span class="label label-warning">Required</span>

**Response**
* HTTP 200 (success) - If the user already exists and it will return the response from <a href="{{site_url}}/docs/api/resources/user.html#getUser">GET /user</a>
* HTTP 201 (created) - If the user did not exist. An event will be created that will trigger the email notification for a user to create account.


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
