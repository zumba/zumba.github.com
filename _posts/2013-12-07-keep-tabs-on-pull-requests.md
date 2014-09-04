---
layout: post
title: "Tame Stale Pull Requests with Drill Sergeant"
description: Get notified via email when github pull requests become stale.
tags: [github, git-flow, drill-sergeant]
author: cjsaylor
---

Our tech team uses a process similar to the [Github Flow](http://scottchacon.com/2011/08/31/github-flow.html), whereby all changes are pushed to the main branch
of a repo by way of Github pull requests. We use this internally, but it is also the most common mechanism for open source projects to get community contributions on Github. We think it's a great way to encourage code reviews and incremental improvements prior to going into a main production pushable branch, however it's not without its pain points.

### Stale Pull Requests `==` Death to Open Source

How many times have you come across an open source project that does _almost_ what you need? How many of these have pull requests that are one or more months old? It's discouraging when you know that you could contribute and fix whatever problem may exist with the project but you know that the maintainer has abandoned or is not responsive to merging pull requests. As both a maintainer of open source projects, it's critical to stay up-to-date and aware of open pull requests.

### Introducing Drill Sergeant

As a part of our development lifecycle, stale pull requests mean that QA doesn't have the opportunity to begin testing until it is merged. Therefore, it is vital that the dev team know about pull requests to be reviewed and merged as soon as possible. We developed an open source tool called [Drill Sergeant](https://github.com/zumba/drill-sergeant) to send reports via email of any pull request older than a specified period. 

### Reporting for Duty

An example report from running Drill Sergeant against the CakePHP project configured for one week staleness looks something like this:

![Drill Sergeant Report]({{ site.url }}/img/blog/drill-sergeant.png)

The command for the above:

~~~
GITHUB_TOKEN=atokenhere drillsergeant -e "myemail@address" -r "cakephp/cakephp" -s 168 # 24 * 7
~~~

### Schedule It with Crontab

This tool is meant to be run on a schedule and it's easy to setup to get daily reports:

~~~
0 0 * * *	GITHUB_TOKEN=atokenhere drillsergeant -e "myemail@address" -r "cakephp/cakephp" -s 168
~~~

### Install It

The full instructions can be found in the [readme of the project](https://npmjs.org/package/drill-sergeant)
