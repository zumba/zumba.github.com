---
layout: post
title: Enforce code standards with composer, git hooks, and phpcs
description: Reduce number of back-and-forths in pull requests by enforcing code quality at the commit level.
tags: [quality, php, phpcs, composer, git]
author: cjsaylor
---

Maintaining code quality on projects where there are many developers contributing
is a tough assignment. How many times have you tried to contribute to an open-source project
only to find the maintainer rejecting your pull request on the grounds of some invisible coding
standard? How many times as a maintainer of an open-source project (or internal) have you had a
hard time reading code because there were careless tabs/spaces mixed, `if` statements with no brackets,
and other such things. Luckily there are tools that can assist maintainers. In this post,
I'll be going over how to use [composer](http://getcomposer.org), git hooks, and [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) to
enforce code quality rules.

There are a couple of things to keep in mind. First, you want this process to be as simple as possible.
Secondly, you want it to be easy to run when necessary. Finally, you want
it to be universally accepted as part of your contribution procedure.

### There Is No Catch

What if I told you that it could be done without the developer even knowing it's happening?

Most modern PHP projects use composer as their dependency manager. Before you can make anything work, you need to run `composer install`.
This is where the magic happens.

### Phpcs Dependency

First, we need a development dependency specified to install phpcs. It looks something like this:

```
{
    "require-dev": [
        "squizlabs/php_codesniffer": "2.0.*@dev"
    ]
}
```

### Install Scripts

Composer has a handy schema entry called `scripts`. It supports a script hook
`post-install-cmd`. We will use this to install a git pre-commit hook. Adding to
our example above:

```
{
    "require-dev": [
        "squizlabs/php_codesniffer": "2.0.*@dev"
    ],
    "scripts": {
        "post-install-cmd": [
            "bash contrib/setup.sh"
        ]
    }
}
```

This will run a bash script called `setup.sh` when the command `composer install` is run.

### Setup the Git Pre-commit Hook

In our `setup.sh`, we will need to copy a `pre-commit` script into the `.git/hooks` directory:

```bash
#!/bin/sh

cp contrib/pre-commit .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

This will copy our pre-commit script from the `contrib` directory to the hooks section
of the special git directory and make it executable.

### Create the Pre-commit Hook

Whenever a contributing developer attempts to commit their code, it will run our `pre-commit` script.
Now all we need to do is run the code sniffer rules on relavent files specific to this commit:

<script src="https://gist.github.com/cjsaylor/10503398.js"> </script>

This script will get the staged files of the commit, run a php lint check (always nice), and apply the
code sniffer rules to the staged files.

If there is a code standards violation, the phpcs process will return a non-zero exit status which will
tell git to abort the commit.

### Bringing it all together

With all of these things in place, the workflow is as follows:

* Developer runs `composer install`.
* PHP Code Sniffer is installed via a dev dependency.
* The post-install command executes automatically copying the pre-commit hook into the developer's
local git hooks.
* When the developer commits code, the pre-commit hook fires and checks the staged files for coding standards violations and lint checks.

This is a relatively simple setup that can save pull request code reviews a significant amount of time preventing
back-and-forth on simple things such as mixed tabs/spaces, bracket placement, etc.
