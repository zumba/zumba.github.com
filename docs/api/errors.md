---
layout: default
title: Zumba API Errors - Documentation
description: Errors documentation
author: juliancc
---

# Client Errors #

Sending invalid fields will result in a 422 Unprocessable Entity response.

For all failure cases throughout the API, there is a common format:


- `message` (string) Localized display message that will be shown to user  (eg. "Incorrect username or password")
- `errors` (int) HTTP error code; always 400.
  - `resource` (object) Optional: A dictionary of localized error messages whose keys are the names of request parameters whose values were invalid.
  - `resource` (object) Optional: A dictionary of localized error messages whose keys are the names of request parameters whose values were invalid.
  - `validation` (object) Optional: A dictionary of localized error messages whose keys are the names of request parameters whose values were invalid.
- `url` (string) relative URL of the endpoint that failed.

HTTP/1.1 422 Unprocessable Entity

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

All error objects have resource and field properties so that your client can tell what the problem is.
There’s also an error code to let you know what is wrong with the field. These are the possible validation error codes:


| Error Name 		| Description |
| ----------------- | ----------- |
| missing 			| This means a resource does not exist. |
| missing_field 	| This means a required field on a resource has not been set.
| invalid			| This means the formatting of a field is invalid. The documentation for that resource should be able to give you more specific information.
| already_exists 	| This means another resource has the same value as this field. This can happen in resources that must have some unique key (such as Label names).

If resources have custom validation errors, they will be documented with the resource.
