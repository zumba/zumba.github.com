---
layout: post
title: "Zumbatech takes on #hackforchange"
description: How Zumbatech contributed to Hackforchange utilizing opensource tools.
tags: [hackathon, civic coding, opensource, elasticsearch, kibana, nodejs]
author: cjsaylor
---

On June 6, 2015, a team of engineers from Zumbatech decided to contribute in
an all-day hackathon event called [Hackforchange](http://hackforchange.org/).
This is a national effort for civic hacking that brings engineers and designers
together to make a positive impact in our communities.

## Let's not re-invent the wheel

The day before the event, our team got together to figure out what we were going to work
on that would give the most impact to our community. We chose to work on generating visualizations
of Florida vendor transactions. The first thing we noticed is that a couple of projects had
already been underway to create restful APIs and alternate data formats for this data. We decided
that an API that is specific to this data set wouldn't be very reusable for other data sets, *and*
it would still take an engineer's effort to visualize the data from those APIs.

We wanted to make something that is generic enough to work with any sort of data set,
be flexible enough for other engineers to create tools and visualizations via an API,
and be easy enough for non-engineers to construct visualizations that fit their needs.
A daunting task, especially for it to be _mostly_ completed in a single hackathon.
After some planning and discussion, we came up with a solution ready for hacking!

## Hackathon

Bright and early on that Saturday morning, we arrived in the [LAB Miami](http://thelabmiami.com/) offices to
work on a project we called [Datamnom](https://github.com/cjsaylor/datamnom). The idea
of the project is to make a generic ingestion program that can take in multiple data sources and
populate an [Elasticsearch](https://www.elastic.co/products/elasticsearch) index. Once the data
is in Elasticsearch, a tool called [Kibana](https://www.elastic.co/products/kibana) can be hooked
up to the Elasticsearch index we populated to create visualizations.

After writing a prototype [nodejs](https://nodejs.org) program and setting up a [Vagrant](https://www.vagrantup.com/)
environment, we had Kibana up and running with data to visualize:

<img alt="Kibana running FL Vendor data" class="img-responsive" src="/img/blog/visualization1.png">

Here is team Zumba demoing our work to the Florida CFO, Jeff Atwater:

<img alt="Team Zumba demoing Datamnom to Jeff Atwater and others" class="img-responsive" src="/img/blog/miamiherald-hackathon.jpg">

via [Miami Herald](http://miamiherald.typepad.com/the-starting-gate/2015/06/florida-cfo-jeff-atwater-spent-the-morning-with-a-coworking-space-full-of-young-hackers-this-is-dress-down-day-for-me.html)

## Presentation and Reception

After importing about 8 years worth of Florida Vendor transactions, the team presented our idea and applications
to the group. Other groups that were working with this data set decided to use our tools to make their own visualizations.

<div class="row">
    <div class="col-md-6">
        <blockquote class="twitter-tweet" lang="en"><p lang="en" dir="ltr">Team <a href="https://twitter.com/zumbatech">@zumbatech</a> presents FL State Payments API and visualization app. <a href="https://twitter.com/hashtag/hackforchange?src=hash">#hackforchange</a> <a href="http://t.co/R48vs6AnUZ">pic.twitter.com/R48vs6AnUZ</a></p>&mdash; Code For Miami (@CodeForMiami) <a href="https://twitter.com/CodeForMiami/status/607296202191872000">June 6, 2015</a></blockquote>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <div class="col-md-6">
        <blockquote class="twitter-tweet" lang="en"><p lang="en" dir="ltr">Using <a href="https://twitter.com/zumbatech">@zumbatech</a>&#39;s Payments API, <a href="https://twitter.com/robdotd">@robdotd</a> and team visualize printing costs across FL departments. <a href="https://twitter.com/hashtag/hackforchange?src=hash">#hackforchange</a> <a href="http://t.co/eB0BpAgpyV">pic.twitter.com/eB0BpAgpyV</a></p>&mdash; Code For Miami (@CodeForMiami) <a href="https://twitter.com/CodeForMiami/status/607297271928131585">June 6, 2015</a></blockquote>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <blockquote class="twitter-tweet" lang="en"><p lang="en" dir="ltr">State challenge group is visualizing Vendor Data in a bunch of different ways and automating new viz. <a href="https://twitter.com/hashtag/hackforchange?src=hash">#hackforchange</a> <a href="http://t.co/ZGZYnUrcS6">pic.twitter.com/ZGZYnUrcS6</a></p>&mdash; Code For Miami (@CodeForMiami) <a href="https://twitter.com/CodeForMiami/status/607218433437089792">June 6, 2015</a></blockquote>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <div class="col-md-6">
        <blockquote class="twitter-tweet" lang="en"><p lang="en" dir="ltr">Great presentation from <a href="https://twitter.com/CodeforFTL">@CodeforFTL</a> and group! <a href="https://twitter.com/hashtag/hackforchange?src=hash">#hackforchange</a> <a href="https://twitter.com/knightfdn">@knightfdn</a> <a href="https://twitter.com/CFJBLaw">@CFJBLaw</a> <a href="https://twitter.com/wyncode">@wyncode</a> <a href="https://twitter.com/socrata">@socrata</a> <a href="http://t.co/sEidId7pE9">pic.twitter.com/sEidId7pE9</a></p>&mdash; Code For Miami (@CodeForMiami) <a href="https://twitter.com/CodeForMiami/status/607297689525481473">June 6, 2015</a></blockquote>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

# Conclusion

We had a fun time at LAB Miami hacking together a project we think can really help
lawmakers, researchers, and reporters visualize public data in a way that allows them
to ask the right questions and help our communities.
