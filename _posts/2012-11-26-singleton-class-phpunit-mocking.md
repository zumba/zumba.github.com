---
layout: post
title: Mocking Singleton PHP classes with PHPUnit 
description: Convenient way to mock singleton classes for easy, reusable testing.
tags: [php, singleton, phpunit, testing]
author: cjsaylor
---

In many of our projects, utilities and vendor classes are implemented with a [singleton pattern](http://en.wikipedia.org/wiki/Singleton_pattern).  If you're not familiar, a singleton pattern looks something like:

<script src="https://gist.github.com/4131481.js?file=singleton.php"> </script>

In this post, we'll cover a nice way to inject a PHPUnit mock object for use in testing methods that utilize singleton classes.

### Inception

First, we need to identify how this sort of mechanism is mocked.  The key aspect of the singleton class is the protected static self attribute.  This is what we're most interested in for injecting our mock object.  In our example singleton class, the `self` attribute is protected (which is usually the case), so we'll need the use of the reflection class in order to "unprotect" and inject.

### Mock Class

Now we will look at the code to do the above.  First, a sample class that implements our singleton as part of a normal method:

<script src="https://gist.github.com/4131481.js?file=sample_class.php"> </script>

In this exercise, we will mock `Someclass`'s `hello` method to make it return a different string.  This is a super-simplified example, normally you would want to do this sort of thing for classes that do network based things, such as an emailer, REST service connector, etc.

Let's create our mock class:

<script src="https://gist.github.com/4131481.js?file=someclass_mock.php"> </script>

The `expects` method creates the mock object and injects that mock object into the `self` attribute.  The method you test that utilizes the singleton will get the mock object when they call the `getInstance` method.

### Example Use

Here is our PHPUnit test case.  We instantiate the class we want to test, mock the singleton object, and alter the output of the method.

<script src="https://gist.github.com/4131481.js?file=sample_test.php"> </script>

### Conclusion

This technique is really nice for common utility classes. We typically use them in the `setUp` and `tearDown` methods, so we can test the other parts of the method that are important for their logic, and leave a single test to test the actual functionality of the singleton class we're mocking.

