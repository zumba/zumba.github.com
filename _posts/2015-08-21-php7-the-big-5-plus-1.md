---
layout: post
title: "What's New in PHP 7 (PHPng) with Cal Evans"
description: How Zumbatech met with Cal Evans to Discuss new Features and Changes of PHP 7.
tags: [php7, phpng, CalEvans, features]
author: ZurabWeb
---

On August 19, 2015, a team of engineers from ZumbaTech (#TeamZumba) met with Cal Evans to discuss the features and improvements of PHP 7 or PHPng (NextGen). The release of this version is planned for November of this year. Cal, being close to the PHP core team, was able to explain new features and benefits introduced in PHP 7.

---

Many of us - PHP developers - remember how hard it was to up date PHP from `4.x` to version `5.x` when it was released. Backwards compatibility was limited and a lot of code needed to be adjusted to run smoothly on this brand new version of PHP back in the day. After the update, however, a lot of new features became available and made coding easier and much more fun.

_PHP 7 is going to be 100% backwards compatible_, claims [Cal Evans](http://calevans.com) - the founder of [Nomad PHP](https://nomadphp.com/), a member of [Zend](http://www.zend.com/) team, author of multiple books and articles and a guru of software development.

## Important Improvements

One of the biggest improvements PHP 7 brings to software development world is the performance boost. Depending on the code logic, 40-95% performance increase is expected with the update to the latest version. Most likely, however, 95% performance increase can only be seen performing some trivial tasks (mostly loops), not exactly used in modern software development.

Zend Technologies ran some perfrmance tests with PHPng which yielded [some interesting results](https://pages.zend.com/rs/zendtechnologies/images/PHP7-Performance%20Infographic.pdf).

<img alt="Zend Technologies PHP7 Perfrmance Test Results" class="img-responsive" src="/img/blog/zend_benchmark.jpg">

The new `Throwable Interface` would be another major improvement of this version. It would allow us to catch and handle `Exceptions` as well as `Errors` including `Fatal` ones which are not catchable, generally unrecoverable and very hard to handle.

Another feature of PHPng discussed on the meetup is the strict mode. By adding `declare(strict_types=1);` as the first line of each file, PHP would validate that each method in that file, that has declared request/response parameter types, would receive/return values with the matching types. Otherwise the script execution will stop and a catchable fatal error will be raised. This is a feature, fighting over which the PHP core team lost a rockstar member, Cal mentioned.

PHP 7 also intends to improve the random numbers and bytes generation logic. Functions like `rand()` were not so reliable and random since... well since they were implemented. PHPng will implement two new functions to solve this problem: `random_bytes()` and `random_int()`. These functions will be obtaining and returning appropriate values from the operating system of the runtime environment, and thus increasing _randomness_ of the values.

## [not so] Important Features

PHP 7 implements a new operator called the `Spaceship Operator` that looks like this: `<=>`. Although the name is exciting, the usage cases are not so. The functionality of the operator is that it compares the value to the left of it to the value on the right of it. If the value on the left is less than the value on the right, the result of the comparison would be `-1`. If the values are equal, then the result is `0`, and if the value on the left is greated than the value on the right, then the result of the operation would be `1`.

As Cal mentioned, he only sees the effective usage of this operator in the `usort()` function callback.

## Planned Release Timeline

PHP core team is planning to release this new version somewhere in the mid-November, according to [PHP RFC: PHP 7.0 timeline](https://wiki.php.net/rfc/php7timeline) created by [Zeev Suraski](https://twitter.com/zeevs) back in 2014, however the team will not rush the process and push the new release, unless it's stable enough to let general public access it. We can only hope everything goes as planned.

## Keep in Touch
Have something to add or clarify? Leave a comment below and I'll keep in touch!
