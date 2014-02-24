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
* [GET /class/checkins](#getClassCheckins)

<hr>

<span id="getClass"></span>
### `GET /class/:id` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

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

<span id="getClassStudents"></span>
### `GET /class/:id/students` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Retrieve student list with statuses for all students associated to an instructor's class.

**Response**

```json
[
  {
    "user_id": String,
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

<span id="getClassCheckins"></span>
### `GET /class/checkins` <span class="label label-info">Proposed</span><span class="label label-danger">Incomplete</span>

> Retrieve a user's checkin history.

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
`start_date` | <span class="label label-warning">Required</span> Date to begin looking for records.
`offset` | Number of records to offset on the request.
`max` | Number of records to return in the response. 

**Response**

```
{
  "id": String,
  "class_id": String,
  "source": String,
  "type": String,
  "datetime": "0000-00-00T00:00:00+00:00",
  "location": {
    "city": String,
    "state": String,
    "country": String
  },
  "_uris": {
    "class": "https://apiv3.zumba.com/class/:id"
  }
}
```

**Response Headers**

See [pagination documentation]({{site_url}}/docs/api/pagination.html) for the pagination handling mechanism.