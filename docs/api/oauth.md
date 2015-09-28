---
layout: default
title: Zumba API OAuth - Documentation
description: OAuth documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li class="active">OAuth2</li>
</ul>

When making requests to the API on behalf of a Zumba user, the OAuth2 protocol is used for authorization and access.
You can read more about the OAuth2 protocol [here](http://oauth.net/2/).

## Web Application Flow

### Initial Linkage

The following steps are required in order get access to the API on the user's behalf.

> Redirect users to request Zumba access.

~~~
GET https://www.zumba.com/oauth/authorize
~~~

**URL Parameters**

{:.table}
*Name* | *Description*
--- | ---
client_id | `Required` The client ID you receive from Zumba.
redirect_uri | `Required` The URL to redirect to after the user has given permission.
scope | `Required` A list separated by __spaces__ of scopes that your application needs for permission.
state | `Required` A random string used to verify the redirect and auth code came from Zumba.

<br>

> Zumba redirects to your application with an authorization code and the state passed.

The redirect occurs if the user authorizes your application's permissions.
The redirect will include a `code` parameter and the `state` your application originally passed.

<br>

> Exchange authorization code for an access token.

~~~
POST https://www.zumba.com/oauth/access_token
~~~

**Content-Type**: `application/x-www-form-urlencoded`

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
client_id | `Required` The client ID you receive from Zumba.
client_secret | `Required` The client secret you receive from Zumba.
code | `Required` The authorization code passed from the redirect.
redirect_uri | `Required` The URL to redirect to after the user has given permission.

**Response**

~~~
{
    "access_token": "e86285803dd51b76ca3656f3c8f7afe460c29bd3",
    "expires_in": 31536000,
    "token_type": "Bearer",
    "scope": "basic",
    "refresh_token": "c706b0a739c75b1eab1c68a736b9ca8cf68d51e9"
}
~~~

---

### Get an access token from a `refresh_token`

All access tokens are set to expire. When you encounter an access token that is going to expire, you can
use the `refresh_token` returned in the original access token request to create a new access token. To do so,
post to the access token endpoint with the refresh token on hand and specifying the grant type as `refresh_token`.

~~~
POST https://www.zumba.com/oauth/access_token
~~~

**Content-Type**: `application/x-www-form-urlencoded`

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
client_id | `Required` The client ID you receive from Zumba.
client_secret | `Required` The client secret you receive from Zumba.
refresh_token | `Required` The refresh_token from the original access token request.
grant_type | `Required` Specify `refresh_token` as the grant type allows the `refresh_token` to be used.


**Response**

~~~
{
	"access_token": "71999997080999adfb1e614dd65697fdef6243e7",
	"expires_in": 31536000,
	"token_type": "Bearer",
	"scope": "basic"
}
~~~

---

### Using the access token with the API

In order to make requests to the API on behalf of the user, pass your access token as an `Authorization` header:

~~~
curl -H "Authorization: Bearer e86285803dd51b76ca3656f3c8f7afe460c29bd3" https://apiv3.zumba.com/...
~~~
