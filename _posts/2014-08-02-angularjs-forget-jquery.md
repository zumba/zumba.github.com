---
layout: post
title: Developing With AngularJS? Forget jQuery Exists.
description: Understanding how jQuery's power and familiarity can unintentionally subvert AngularJS' goals.
tags: [javascript, jquery, angularjs, directive, dom, tutorial, beginner]
author: young-steveo
---

Before I begin, take a moment to remember how hard our lives were before [jQuery](http://jquery.com/) ironed out the treacherous wrinkles of cross-browser development.  Client-side Javascript is to jQuery as mammals are to sharks with frickin' laser beams attached to their heads.  **Zumba&reg; Tech** engineers are big fans of jQuery.

Now, if you are writing an AngularJS application, do us all a favor and **forget jQuery exists**.

Here's the rub &mdash; the power of simple jQuery scripts can sometimes be incongruent with the goals and maintainability of an [AngularJS](https://angularjs.org/) application.  jQuery is a library with a lot going on under the hood, but it is primarily used for these things:

1. Performing AJAX operations
2. Animating HTML elements
3. Handling browser events
4. Querying, traversing, and manipulating the DOM

There are caveats when using jQuery to execute *any* the above actions within an AngularJS app, but this post is focused on the last two:  Events and DOM interactions.

## Separation of Concerns
Querying for CSS selectors is very difficult to do without implicitly tying your code to the DOM; it's nigh impossible.  This can lead to brittle code in the long run.  For example, when you write `$('.soso')` you create an implied contract that the HTML template will contain an element with the `soso` class.  If you later remove the `soso` class and add a new `awesome` class to the element, you have broken the contract and the Javascript may stop working.

At a fundamental level, the principle of separation of concerns was violated.  The `soso` class was given *meaning* outside of its implied styling.  Worse still, nothing in the HTML template indicated that the `soso` class was more than just a boring presentational element of the page.

DOM traversal is also problematic.  For example, using jQuery you can query for a specific element, get that element's siblings, find any links that are children of those siblings, and bind a click event to those links.  This kind of script is easy to write, but it is tied to the structure of the template.  Adding or removing DOM elements in the hierarchy can very easily break the script.

## Manually Querying the DOM Is Like Writing SQL
Here's some pseudo code for you.  Use your imagination.

~~~
SELECT DOMElement FROM document WHERE document.id = "#navBar"
~~~

This is conceptually equivalent to writing `$('#navBar')`.

Querying the DOM is a low level task that is akin to writing SQL statements.  You would never sprinkle SQL statements around your backend codebase, so why do the same thing inside your AngularJS directives?

## Indigestion
One of the awesome features of AngularJS is [two way data binding](https://docs.angularjs.org/guide/databinding):

> Any changes to the view are immediately reflected in the model, and any changes in the model are propagated to the view.

AngularJS periodically loops over the properties of the "model" and updates the DOM if the data has changed.  This is called the $digest cycle.  When you use `ngClick` or `scope.$watch`, or even the `$timeout` service, AngularJS will automatically kick-off a $digest cycle for you.

However, when you manually bind click events via `$(element).on()`, AngularJS is not aware of those event handlers.  Data in the model could be updated, but the view will likely remain stale.  You could manually call `scope.$digest` or `scope.$apply`, but this quickly becomes messy and bug-prone.  If you use lots of manual $digest calls, you are bound to start getting AngularJS errors about trying to start a digest cycle when one is already in progress.  Trust me.

## Refactoring a Problematic Directive
Breaking away from the jQuery methodology is hard.  I figure that the best way to illustrate these concepts is by example. So, I've cooked up a brittle, jQuery-style directive that I'm going to refactor into a resilient, reusable "AngularJS Way" component.

### The Template

<script src="https://gist.github.com/young-steveo/29dec391126238005e5e.js?file=a.html"></script>

Let's say we want the content paragraphs to toggle visibility when the user clicks on the corresponding links in the list, and we want the `li` elements to indicate the active paragraph.  The following directive gets the job done.

### The Brittle Directive

<script src="https://gist.github.com/young-steveo/29dec391126238005e5e.js?file=a.js"></script>

The above code is somewhat clean on the surface, but there are a lot of implied dependencies on the DOM.  For example, the directive will only work if the links remain children of `li` tags.  The directive will break if the DOM is modified to put the links inside of a `div` or `p` tag.

Every time a link is clicked, the code traverses the DOM.  That's expensive in a large system.  It could be refactored to cache the DOM traversal, but doing this introduces a new dependency on the state of the DOM.  For example:  What if some of the HTML gets changed to be inserted dynamically?  Suddenly the variables will be empty at linking time, yet again breaking the directive.  Event delegation mitigates this, but we still don't solve the problem of hidden functionality.  When examining the HTML, it is not clear that there is behavior attached to the links and paragraphs.

### Use the Scope
We need to divorce the data/state from the template's attributes and classes.  To do that we can introduce `ngClass`, `ngClick`, and `ngIf` to the template. We can then keep track of the links' states inside the directive scope, and leave the DOM manipulation to Angular.

### The New and Improved Template &amp; Directive
<script src="https://gist.github.com/young-steveo/29dec391126238005e5e.js?file=c.html"></script>
<script src="https://gist.github.com/young-steveo/29dec391126238005e5e.js?file=c.js"></script>

1. There are no dependencies on the DOM at all.  It's just a directive that wraps an object called `scope.active` that contains some boolean values.  The booleans get flipped on and off when the `select` function is called. This directive is relatively immune to DOM updates.  You could change all of the classes in the template; you could delete and add new HTML; you could change `a` tags into `div` tags or `p` tags into `span` tags.  **Nothing will break in the JS file**.  There are no classes being toggled in the directive.  If a developer decides to change the classes on the `li` elements from `active` to `awesomesauce`, *everything still works*. This is awesome.
2.  There is no DOM traversal happening at all.  This is awesome; and it's fast.
3.  Looking at the HTML reveals how this widget works.  It is declarative, which is awesome. (there's a theme here)
4.  Since all of the click operations are handled by `ngClick`, everything will remain inside the digest cycle, and I don't have to use `scope.$apply` anywhere.  It will just work.

### jQuery Under the Hood
AngularJS ships with [jqLite](https://docs.angularjs.org/api/ng/function/angular.element):

> jqLite is a tiny, API-compatible subset of jQuery that allows Angular to manipulate the DOM in a cross-browser compatible way. jqLite implements only the most commonly needed functionality with the goal of having a very small footprint.

The interesting thing here is that Angular uses jqLite to perform DOM manipulation such as adding and removing classes for the `ngClass` directive.  This allows `ngClass` and other built-in directives to be an abstraction that separates the queries from your code.

## Summary
jQuery is a badass tool for scripting interactions with the DOM.  It's a **global** hammer that you can whip out anywhere in the code and smash out your feature on the spot.  This is awesome, but it leads to brittle, non-reusable, hard to maintain code (inside AngularJS, at least).

#### TL;DR
When trying to solve a problem or add functionality to an AngularJS app, start by forgetting about jQuery solutions.  Reach for directives like `ngClick` and `ngClass`.  Doing so will likely result in a more elegant solution.

