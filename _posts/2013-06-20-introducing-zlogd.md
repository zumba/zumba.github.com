---
layout: post
title: Introducing Zlogd - An open source universal logging agent
description: Socket server for external apps to ship logs in a non-blocking fashion.
tags: [nodejs, logging, agent]
author: cjsaylor
---

Logging is a critical part to an application's life-cycle. It helps identify problems when they occur and track trends of events.

There are many ways and products to accomplish this depending on your goal, but today we're introducing our open-source logging agent to help: [Zlogd](https://npmjs.org/package/zlogd).

## Use case

In many instances in web applications, multiple servers are involved, each involving one or many log files. When tracking down a problem or examining for trends, this becomes very problematic.

Zlogd is meant to solve this problem as being a universal logging agent. Zlogd runs locally on each server and listens to a socket file. The application then will start logging output to the socket file where Zlogd will package and ship the log message to a central logging location.

## Zlogd Workflow

In our proposed stack configuration, our central logging server will contain the following:

* Logstash agent for receiving all messages from all the Zlogd instances.
* Elastic search for Logstash to store the messages
* Kibana3 to have one interface to examine the logs

The workflow would then lend itself to this configuration:

![Zlogd Workflow]({{ site.url }}/img/blog/zlogd_workflow.jpg)

## Benefits

Since our stack is mostly PHP, that means each request is synchronous. If there are multiple loggers enabled (ie, write to file, ship to newrelic on warning/error, etc), the customer is on the hook for waiting for that log event to process through all those loggers. This shortens the logging time during the request by only having to write to a single logger (the Zlogd sock file) thereby increasing application performance.

This also facilitates the central logging paradigm, which allows the consolidation of all application logs.

## Conclusion

Zlogd hopes to solve the problem of fractured logging and be flexible enough to work with any log collecting apparatus. This is a relatively new system, and as such we will be working the kinks out of this first version release. Feel free to fork and open a pull request to implement your flavor of log transport (graylog2, splunk, loggly, etc).

## Reference

* [Nodejs NPM package](https://npmjs.org/package/zlogd)
* [Github repo](https://github.com/zumba/zlogd)
