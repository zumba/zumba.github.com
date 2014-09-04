---
layout: default
title: Zumba API User Resource - Documentation
description: User resource documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li><a href="{{site_url}}/docs/api/resources">Resources</a></li>
	<li class="active">User</li>
</ul>

**TOC**

<ul>
	<li><a href="#getUser">GET /user</a></li>
	<li><a href="#postUser">POST /user</a></li>
	<li><a href="#getUserClasses">GET /user/classes</a></li>
	<li><a href="#getUserCheckins">GET /user/checkins</a></li>
	<li><a href="#getUserStudentClasses">GET /user/student/classes</a></li>
</ul>

<hr>

<span id="getUser"></span>


### `GET /user`

> Retrieve user info.

**Response**

~~~
{
	"id": String,
	"username": String,
	"email_address": String,
	"first_name": String,
	"last_name": String,
	"pid": String,
	"branch": String,
	"isZIN": Boolean,
	"isZES": Boolean,
	"isZJ": Boolean,
	"isGym": Boolean
}
~~~

If the scope of the OAuth token includes nutrition, then the response will include additionally:

{:.table}
*Field* | *Code* | *Description*
--- | --- | ---
`nutrition_status` | 0 | Inactive or No nutrition membership
`nutrition_status` | 1 | Active Nutrition Membership

~~~
{
	nutrition_status: Integer
}
~~~

<hr>

<span id="postUser"></span>


### `POST /user`

> Create a new user account


**Post Parameters**

{:.table}
*Field* | *Type* | *Requirement*
--- | --- | ---
username | String | <span class="label label-warning">Required</span>
password | String | <span class="label label-warning">Required</span>
email_address | String | <span class="label label-warning">Required</span>
first_name | String | <span class="label label-warning">Required</span>
last_name | String | <span class="label label-warning">Required</span>

**Response**

If successful this endpoint will return the response from <a href="#getUser">GET /user</a>.


<hr>

<span id="getUserClasses"></span>


### `GET /user/classes`

> Retrieve a list of an instructor's weekly classes.

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
type | Class type (`?type=nutrition`, or multiple: `?type[]=nutrition&type[]=zumba_toning`)

Note: `day_of_week` starts `0` = Sunday.

Note 2: `nutrition` type will only returns classes taught by the user. It will not include
classes where the user is attending. See endpoint `/user/student/classes`.

**Response**

~~~
[
	{
		"id": String,
		"start_time": String (format "hh:mm"),
		"end_time": String (format "hh:mm"),
		"start_date": Null (When class does not have an end date) or String (format "yyyy-mm-dd"),
		"end_date":  Null (When class does not have an end date) or String (format "yyyy-mm-dd"),
		"day_of_week": Integer,
		"type": String,
		"location": {
			"name": String,
			"type": String,
			"street": String,
			"street_2": String,
			"city": String,
			"state": String,
			"country": String,
			"postal_code": String,
			"lat": Float,
			"lng": Float
		},
		"_uris": {
			"class": "https://apiv3.zumba.com/class/:id"
		}
	}
]
~~~

<hr>

<span id="getClassCheckins"></span>

### `GET /user/checkins`

> Retrieve a user's checkin history.

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
`start_date` | <span class="label label-warning">Required</span> Date to begin looking for records.
`offset` | Number of records to offset on the request.
`max` | Number of records to return in the response.

**Response**

~~~
[
	{
		"id": String,
		"source": String,
		"datetime": String (format: YYYY-MM-DDThh:mm:ssTZD),
		"location": {
			"street": String,
			"street_2": String,
			"city": String,
			"state": String,
			"postal_code": String,
			"country": String,
			"name": String,
			"lat": Float,
			"lng": Float,
			"class": {
				id: String,
				start_time: String (format "hh:mm"),
				end_time: String (format "hh:mm"),
				type: String
			}
		},
		"_uris": {
			"class": "https://apiv3.zumba.com/class/:id"
		}
	}
]
~~~


**Response Headers**

See [pagination documentation]({{site_url}}/docs/api/pagination.html) for the pagination handling mechanism.

<hr>

<span id="getUserStudentClasses"></span>


### `GET /user/student/classes`

> Retrieve a list of student classes.

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
type | Class type (`?type=nutrition`, or multiple: `?type[]=nutrition&type[]=zumbini`)

Note: `day_of_week` starts `0` = Sunday.

**Response**

~~~
[
	{
		"id": String,
		"start_time": String (format "hh:mm"),
		"end_time": String (format "hh:mm"),
		"start_date": Null (When class does not have an end date) or String (format "yyyy-mm-dd"),
		"end_date":  Null (When class does not have an end date) or String (format "yyyy-mm-dd"),
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
			"type": String,
			"street": String,
			"street_2": String,
			"city": String,
			"state": String,
			"country": String,
			"postal_code": String,
			"lat": Float,
			"lng": Float
		},
		"_uris": {
			"class": "https://apiv3.zumba.com/class/:id"
		}
	}
]
~~~
