---
layout: default
title: Zumba API Pagination - Documentation
description: API pagination documentation
author: cjsaylor
---

<ul class="breadcrumb">
	<li><a href="{{site_url}}/docs">Documentation</a></li>
	<li><a href="{{site_url}}/docs/api">API</a></li>
	<li class="active">Pagination</li>
</ul>

When making requests to end points that may have paginated responses, the `Link` and `X-Total` response headers are used
to indicate what the client should request to get responses for the next, previous, and other positional requests and
the total number of results for the request.

### `Link` Header

A `Link` header will indicate to the client how to traverse the paginated results. A `Link` header may look something like:

```
Link: <https://apiv3.zumba.com/parties/search?location=Miami&offset=200&max=100>; rel="next", <https://apiv3.zumba.com/parties/location=Miami&offset=0&max=100>; rel="prev"
```

It is important to always rely on the `Link` header to provide you with navicable pagination requests.

**Possible `rel` links**

{:.table}
*rel* | *Description*
--- | ---
`next` | URL of the next page of results.
`prev` | URL of the previous page of results.
`first` | URL of the first page of results.
`last` | URL of the last page of results.

### `X-Total` Header

An `X-Total` header will indicate to the client how many total results are available. A `X-Total` header may look something like:

```
X-Total: 1021
```
