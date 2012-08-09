---
layout: post
title: Frisby.js or: How I Learned to Stop Worrying and Love the Service Test
description: Using Frisby.js to test API endpoints at the request level.
tags: [frisby.js, nodejs, node-jasmine, BDD, unit testing]
author: Chris Saylor
nickname: cjsaylor
---

Writing a public facing API can be a daunting task, and making sure your endpoints behave how your customers and partners expect is always a challenge.  In this article, I will go over how to use [NodeJS](http://nodejs.org/), [Frisby.js](http://frisbyjs.com/), and [Jasmine-node](https://github.com/mhevery/jasmine-node/) to test your API, and how to involve your customers and partners in the process.

### Behavior Driven Development

Frisby.js and Jasmine are very conducive to the idea of <abbr title="Behavior Driven Development">BDD</abbr>.  When creating an API (especially in conjunction with a partner), <abbr title="Behavior Driven Development">BDD</abbr> is a fantastic way to drive coordination between <del>business requirements</del> user stories and code.  Frisby.js gives a nice set of methods to turn a user story into a functioning test case.

### Writing Frisby.js Test Cases

Suppose you have a user story about getting a user's profile by ID and returning some basic information.  The test you would write would be similar to this:

<script src="https://gist.github.com/297ca7d642b380867188.js"> </script>

To execute the above test, execute the following from the command line:

`jasmine-node --verbose`

### Integrating with Partners and Customers

Communicating problems, changes, and features of an API to a partner or customer can be problematic.  Our approach was to separate this kind of testing framework for the API from our internal API repository.  This way, we can share the API test repository, allow the tests to show some example uses of the API, and provide an avenue for partners to report an issue.

With the use of [Github](https://github.com), a partner can fork our testing repo at any time, write a test case for the issue they are having, and submit a pull request.  We can then verify by reproducing the issue from their pull request test case and truely know that we've resolved the partner's issue when their own test case passes with the fix.

### Caveats

There is a small drawback to service-level testing (as opposed to unit testing).  Since you'll be making actual requests to your API, you don't have the luxery of fixtures creating clean databases after the test case is run.  So, depending on the data changed in the request, you'd have to chain a cleanup method after the test case is run.

Also, as opposed to unit tests, the failed test will not pinpoint in the code where the error happens, so you'd need to rely on other tools, such as logging, to find the issue in the source.

### Conclusion

With a BDD approach and the use of some clever testing tools, it's easier than ever to test an externally available service for full coverage and to provide a better channel of communication with partners to resolve bugs and implement features.