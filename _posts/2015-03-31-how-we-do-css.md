---
layout: post
title: How We Do CSS at Zumba
description: This is how we do CSS at Zumba.
tags: [technology, css, sass, front end, engineering]
author: neptunz
---

As you may or may not know Zumba's website consists of a robust app that includes a fully custom ecommerce shop that supports international transactions, class and training search and registration, Zumba Instructor Network (ZIN) admin portal and many other apps. Our in-house tech department is responsible for managing the interactive products, developing, testing and deploying the projects.

I was inspired by the teams at <a href="http://dev.ghost.org/css-at-ghost/" target="_blank">Ghost</a> and <a href="https://github.com/styleguide/css" target="_blank">Github</a> to write this article to give you an idea of how we do CSS at Zumba.

### Intro - Browser and Device Support
We try to keep our code as light, modular and DRY as possible. We use Modernizr, Autoprefixer and some Foundation components. We try to keep our nesting no more than 4 levels deep and we try to make sure that  our naming convention lends itself to reusable components.

We support the last few versions of popular browsers (Chrome, Safari and Firefox). At the time of writing this we currently support IE 8+. About 2% of our users still use IE 8; we are not out of the woods yet.

We made the leap to a responsive application with our recent redesign of the site. Therefore, we support a wide range of desktop, tablet and mobile devices. At the time of writing this we don’t currently support smart watches. We will soon, though… so, "watch" out for that... sorry.

### Preprocessor
We use Sass with Compass as our preprocessor. Our team is proficient and has much training on this popular pre-processor and it’s large following helps.

### Folder/Sandwich Structure
Here’s the fun stuff - we structured our css based on a few important factors:

#### + Modularity and Reusability
Develop components that can be reused throughout the application.

#### + CSS Rules
Consider the size of the compiled stylesheets per section of the site to not exceed IE9’s rules limit of 4,095. Our previous site was compiled into two massive stylesheets and we learned the hard way. We currently break it down per section of the site. See examples below.

#### + Light stylesheets
Keeping the stylesheet declaration low kills two birds with one stone. We break the stylesheets down into individual sheets that contain only the rules for each section of the site—this has the added benefit of avoiding unnecessary or redundant styles per section. Doing this helps us keep our stylesheets light.

Can I have my sandwich with a side of css?
Zumba is a happy and energetic fitness lifestyle company. That doesn’t mean we can’t have our sandwich and eat it too. We decided to structure our css like a sandwich order.

<img src="/img/blog/sandwich-breakdown.jpg" alt="sandwich"/>

#### Plate
The plate represents the foundation of the code and is reused throughout the site.
Example:

`plate
|— _angular.scss
|— _animations.scss
|— _fonts.scss
|— _icons.scss
|— _mixins.scss
|— _typography.scss
|— _variables.scss`

#### Toppings
These can be added to your sandwich to make it as delicious as you want it. These consist of mini components that can be reused throughout the site, but is not necessary for every page.
Example:

`toppings
|— _button.scss
|— _input.scss
|— _shares.scss
|— _tooltip.scss`

#### Sandwich
These nom noms can contain a combination of toppings to make a complete sandwich or component. These are usually a bit more complex and a little more specific. Sandwiches can be used throughout the entire site and can be customized per section of the site to meet that section's needs or requirements.
Example:

`sandwich
|— _accordion.scss
|— _featured.scss
|— _form.scss
|— _hero-slider.scss
|— _modal.scss
|— _pagination.scss
|— _rangeslider.scss`

#### Example of our overall structure:
`assets-build/css-blt
|— checkout/
|— classes/
|— consumer/
|— header-footer/
|— plate/
|— sandwiches/
|— shop/
|— toppings/
|— _settings.scss
|— classes.scss
|— consumer.scss
|— header-footer.scss
|— main.scss
|— shop.scss`

#### main.scss - Consists of the basics of our pages’ layout.

<script src="https://gist.github.com/neptunz/0d6bfe832eb85b6e73a7.js"></script>

### CSS structure
This is an example of how we expect our stylesheets to be laid out. This is not an actual file.

<script src="https://gist.github.com/neptunz/6b55d2e0db2d0190c540.js"></script>

#### + Each file is named after the page or the page module it supports
#### + We never style ID’s only Classes
#### + Keep nesting down to a minimum and no deeper than 4 levels including pseudo selectors
#### + Group related properties wherever possible
#### + Media queries go after properties and the order should reflect mobile first

### Naming

#### Variables and Mixins
Our variables and mixing naming is pretty specific in order to avoid any confusion. We have been here long enough to understand that the company likes to make simple to drastic changes to support the business in general. We have to develop keeping scalability in mind and this variable/mixin strategy just makes more sense for us.

#### Mixin

<script src="https://gist.github.com/neptunz/65b4c6cc19a4c4ad2fd6.js"></script>

#### Color Variables

<script src="https://gist.github.com/neptunz/c473d1fb7056fb22ef46.js"></script>

#### Classes
Our preferred technique is a more descriptive naming convention over deep nesting.

<script src="https://gist.github.com/neptunz/2c49168fb55be1cbbd25.js"></script>

#### Media Queries
For the most part we target based on viewport width. We have a feature or two that depends on the detection of touch. We stick to three basic breakpoints and rarely make exceptions for custom breakpoints. We don’t want to compromise code quality to consider every viewport width consideration.

<script src="https://gist.github.com/neptunz/b1467ce5f11c61b22297.js"></script>

#### Typography

<script src="https://gist.github.com/neptunz/d2ce9353c6f1025922df.js"></script>

#### Linting
Currently our linting consists of pull request code reviews. This is what we look for:

+ Levels of nesting
+ Indentation
+ Flag the use of ID's
+ Spacing after selectors and properties
+ Formatting of properties
+ Code that's commented out
+ Formatting of selectors - lowercase and hyphened preferred
+ Null values should be 0 or none instead of 0px
+ Use of color names should use variables
+ Duplicate selectors or properties

#### The fun never ends
This post and our style guide that is soon to come will never be a done deal written in stone. What we build today is cutting edge and future proof until the future is now and we realize how crazy we were when we developed using archaic methods and tools. The tech world moves at an insane pace and that's what makes our job fun. New technologies will emerge and we will use them to make our applications and our lives as developers better. Therefore, this is relevant for the time being and I hope that it covers us for a very long time, but we all can't be surprised if we have to come back and revise this to support new new. Until then, we will enjoy this sandwich.