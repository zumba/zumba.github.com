---
layout: default
title: Zumba API - Documentation - OAuth
description: OAuth documentation
author: cjsaylor
---

# Zumba OAuth Documentation

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li>API</li>
	<li class="active">OAuth2</li>
</ul>

When making requests to the API on behalf of a Zumba user, the OAuth2 protocol is used for authorization and access.
You can read more about the OAuth2 protocol [here](http://oauth.net/2/).

## Web Application Flow

The following steps are required in order get access to the API on the user's behalf.

<br>

* **Redirect users to request Zumba acess.**

```
GET https://www.zumba.com/oauth/authorize
```

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
client_id | `Required` The client ID you recieve from Zumba.
redirect_uri | `Required` The URL to redirect to after the user has given permission.
scope | A comma separated list of scopes that your application needs for permission.
state | `Required` A random string used to verify the redirect and auth code came from Zumba.

<br>

* **Zumba redirects to your application with an authorization code and the state passed.**

The redirect occurs if the user authorizes your application's permissions.
The redirect will include a `code` parameter and the `state` your application originally passed.

<br>

* **Exchange authorization code for an access token.**

```
POST https://www.zumba.com/oauth/access_token
```

**Parameters**

{:.table}
*Name* | *Description*
--- | ---
client_id | `Required` The client ID you recieve from Zumba.
client_secret | `Required` The client secret you recieve from Zumba.
code | `Required` The authorization code passed from the redirect.
redirect_uri | `Required` The URL to redirect to after the user has given permission.

**Response**

```json
{
    "access_token": "e86285803dd51b76ca3656f3c8f7afe460c29bd3",
    "expires_in": 31536000,
    "token_type": "Bearer",
    "scope": "basic",
    "refresh_token": "c706b0a739c75b1eab1c68a736b9ca8cf68d51e9"
}
```

<br>

* **Using the access token with the API.**

```bash
curl -H "Authorization: Bearer e86285803dd51b76ca3656f3c8f7afe460c29bd3" https://apiv3.zumba.com/...
```
