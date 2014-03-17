---
layout: default
title: Zumba API Errors - Documentation
description: Errors documentation
author: juliancc
---

<ul class="breadcrumb">
  <li><a href="{{site_url}}/docs">Documentation</a></li>
  <li><a href="{{site_url}}/docs/api">API</a></li>
  <li class="active">Errors</li>
</ul>

Sending invalid fields will result in a 400 Bad Request.

For all failure cases throughout the API, there is a common format:


- `message` (string) Message explaining the type of error
- `errors` (Array of Objects) Optional
  - `field` (string) The field that the error affects
  - `code` (string) The error
  - `message` (string) Localized display message that will be shown to user  (eg. "Email address is required")

HTTP/1.1 400 Bad Request
```
{
  message: 'The API endpoint does not exist',
}
```

HTTP/1.1 400 Bad Request
```
{
  "message": "Validation Failed",
  "errors": [
    {
      "field": "email",
      "code": "missing_field",
      "message" : "Email address is required"
    }
  ]
}
```

All error objects have field properties so that your client can tell what the problem is.
There’s also an error code to let you know what is wrong with the field. These are the possible validation error codes:

{:.table}
Error Name | Description
---------- | -----------
missing | This means a resource does not exist. |
missing_field | This means a required field on a resource has not been set.
invalid	| This means the formatting of a field is invalid. The documentation for that resource should be able to give you more specific information.
already_exists | This means another resource has the same value as this field. This can happen in resources that must have some unique key (such as Label names).

If resources have custom validation errors, they will be documented with the resource.
