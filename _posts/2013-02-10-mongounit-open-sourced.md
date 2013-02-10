---
layout: post
title: Mongounit Project Open Sourced 
description: Zumba&reg;'s second open source project, Mongounit, has been open sourced. 
tags: [phpunit, extensions, mongodb, open-source, mongounit]
author: cjsaylor
---

Introducing [Mongounit](https://github.com/zumba/mongounit).

Mongounit is a PHPUnit extension modeled after dbunit that allows for fixture-based unit testing of mongo db backed code.

One of our more recent projects has given the team exposure to MongoDB. As such, we needed an easy way to test the models that utilize mongo in a similar fashion to how we test models that talk to mysql. Using this framework, it's easy to implement mongo test cases to easily create fixture data in collections, or simply clear collections between test cases.

See an example [Testcase](https://github.com/zumba/mongounit/blob/master/Samples/PizzaTest.php)

### More info

* Repository - [Mongounit](https://github.com/zumba/mongounit)
* License - MIT
* CI Build - [Travis CI](https://travis-ci.org/zumba/mongounit)