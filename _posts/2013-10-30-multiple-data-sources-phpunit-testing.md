---
layout: post
title: "Incorporating Mongounit into Multi-datasource Models with Traits"
description: Incorporating Mongounit into Multi-datasource Models with Traits
tags: [mongounit, phpunit, unit testing, mongodb]
author: cjsaylor
---

A while back we open sourced [Mongounit](https://github.com/zumba/mongounit), a PHPUnit extension for testing models utilizing mongodb. One key issue that we've discovered as we incorporate MongoDB into more of our data models is that extending Mongounit's TestCase class limits that unit test towards Mongo only as the datasource. Since only a portion of our data is in Mongo while the remaining is in MySQL, limiting a test case to work with one datasource or another is too limiting.

### Workarounds

The first workaround we employed (as we use PHPUnit's dbunit extension) was to separate the tests of methods that use MongoDB versus methods that use MySQL into separate unit test clases. This worked for a while until we encountered situations where it was either not convienient to split into separate unit tests, or a method was interacting (or calling via protected methods) both data sources.

The second workaround was to manually set and clear data in mongo in the test cases, which works of course, but causes a lot of duplicate code strewn throughout the test code base.

### Enter 5.4 and Traits

PHP does not support the concept of [multiple inheritance](http://en.wikipedia.org/wiki/Multiple_inheritance) which could have easily solved our problem. However, in PHP 5.4, a usable alternative is available. We are fortunate that our code base is workable on PHP 5.4, although not everyone is in the same position. For those not on PHP 5.3 and below, one of the above workarounds will have to suffice.

One of the nice features of 5.4 was the introduction of [traits](http://php.net/traits). Traits provide a simple way to re-use common methods and was a great solution to our lack of multiple inheritance. The first step was to actually create a useful trait in Mongounit to serve as means of attaching mongo support to test cases that extends the dbunit extension.

You can see Mongounit's trait implementation in [Gitub](https://github.com/zumba/mongounit/blob/master/src/Zumba/PHPUnit/Extensions/Mongo/TestTrait.php) available as of version 1.1.3.

The next step was to use the trait in our dbunit based test case. This means seting up the "setup" and "teardown" methods from the trait as well as implementing the abstract methods required for connecting to mongo and retrieving fixture data. These methods are the same as what is available in the [TestCase](https://github.com/zumba/mongounit/blob/master/src/Zumba/PHPUnit/Extensions/Mongo/TestCase.php), so in our case, it was a matter of moving the implementation into the trait method.

<script src="https://gist.github.com/cjsaylor/7243308.js"> </script>

Now that our test case has implemented the trait, we now have access to setup fixtures for both MySQL and Mongo and utilize both within the same test case.

### Conclusion

Using some of the "newer" features of PHP, we are able to make our test cases more flexable and easier to use without having to reimplement entirely what mongounit does into a dbunit extended class.
