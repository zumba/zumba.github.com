---
layout: post
title: "Handling Asynchronism with Promises"
description: Using the async library in Node.js for combining multiple MongoDB aggregation queries into a single list without blocking the event queue.
tags: [mongodb, nodejs, async, promises, javascript]
author: cjsaylor
---

While experimenting with Node.js for a coding game we are working on called [Node Defender](https://node-defender.herokuapp.com)<sup>1</sup> for the [Ultimate Developer Conference](http://ultimatedeveloperevent.com/boston-2013/), many asynchronous problems arose that we were unaccustomed to dealing with since we are primarily a PHP shop (read: synchronous). The examples covered in this post are specific to MongoDB, but the essence can be applied to any asynchronous process.

### Intro

First, let's discuss the problem. The game server is a Node.js app that hosts both the websocket communication as well as a leaderboard of top scores and top categories. In the backend, we use MongoDB to store all the games that occur and use MongoDB's [aggregation framework](http://docs.mongodb.org/manual/aggregation/) to get the top 10 scores and the top scores in each category: Kills, damage, highest round achieved, and "wave clears". Retrieving the top score for each category requires separate queries to MongoDB; each query is asynchronous. How would we go about sending one request to the leaderboard that executes these 4 queries and returns them all without causing the event loop of Node.js to hang waiting for synchronous requests? The answer is "promises." [Martin Fowler](http://martinfowler.com/aboutMe.html) does a good writeup about what a promise is in javascript in [this post](http://martinfowler.com/bliki/JavascriptPromise.html).

### The Aggregate

Each game is represented in MongoDB as a document containing various values for calculating the score. In order to get the highest value in various categories the following aggregate query needs to be run:

<script src="https://gist.github.com/cjsaylor/7323403.js?file=category_aggregate.js"> </script>

For a quick explanation: 

* The `sorter` controls which category by which we're going to sort; descending in this case.
* The `$project` is the projection of the aggregate we'd like MongoDB to return. In this case: the player's name and the value of the category.
* Finally, the `$limit` of 1, we just want the top value.

### Async All the Things

Where does the promise come into play? With the [async](https://npmjs.org/package/async) library, we can use a mapping to get the above aggregate for all required categories, execute in parallel, and return the results to one callback called the promise. In typical promise setups, there would be separate functions for a success, failure, and always. In our case, we're going to setup our promise to receive all conditions and let that method determine how to handle the success and failure results.

We use the async "map" method to accomplish this. It allows us to pass an array of categories to the above aggregate, run the getTopCategory method against each one, compile the results, and then call our promise.

<script src="https://gist.github.com/cjsaylor/7323403.js?file=promise.js"> </script>

Explanation:

* The `map` array contains the categories we want to run with the aggregate queries.
* We bind the `db` (which is the connector to MongoDB) to the `getTopCategory` method, which allows this method to have direct access to the `db` instance without having to pass it in as a parameter.
* Finally, the promise anonymous method attached to the `Async.map` parameter gets the results (or errors) from all of the category aggregates and compiles them into a single list to be consumed by the calling method.

### Conclusion

Using the "promise" pattern with the `async` library, we can make concurrent asynchronous requests and return the results of asynchronous queries into one unified usable list back to the callee. This prevents our request from blocking other requests to Node because the event loop isn't waiting on a series of synchronous queries to MongoDB.

### Footnotes

1. Node Defender is a javascript programming game where you defend against waves of murderous server side code that wants nothing more than to kill and disconnect your client. The client code is open source, and we will be doing a series of blog posts about the construction of the project as well as the infrastructure used to run it.
