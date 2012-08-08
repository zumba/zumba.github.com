---
layout: post
title: CakePHP and Code Coverage
description: How to ignore CakePHP core files from code coverage in Jenkins when testing the application.
tags: [cakephp, code-coverage, unit-test, phpunit, jenkins]
author: jrbasso
---

Recently we started a new API application in [CakePHP](http://www.cakephp.org) 2.2 and put some code and unit tests.
When we put the code in [Jenkins CI](http://jenkins-ci.org/) to a continuous integration we setup the code coverage
and in the reports we got couple CakePHP core files as not covered.

Our application doesn't care about cover Cake files, and we also don't want to include Cake core tests in our
<abbr title="Continuous Integration">CI</abbr>. Leaving these files in CI give reports that our code is not well
covered, which it is not true and hide the uncovered code from our app.

As CakePHP, we also use [PHPUnit](http://www.phpunit.de) in other project, but there we use the `phpunit.xml`
configuration file. Using the configuration file is easy to put folders/files on
[black and white lists](http://www.phpunit.de/manual/current/en/code-coverage-analysis.html), but it is not possible when
using CakePHP because it has their own runner system. Our solution was figure out a way using code. We changed our
test suite to do it, see below.

<script type="text/javascript" src="https://gist.github.com/3260166.js"> </script>

With the code above you can run in your console: `./Console/cake test app AllApp --coverage-html=./report`

You can replace the `--coverage-html` by `--coverage-clover` to use in Jenkins (or both, like in our case).
