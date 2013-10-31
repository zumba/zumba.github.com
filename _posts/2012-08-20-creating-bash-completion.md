---
layout: post
title: Creating bash completion to your console application
description: Shows how to create a file compatible with bash_completion.d and interact with user application
tags: [console, bash, terminal, completion, autocomplete, php, cronjob, tutorial]
author: jrbasso
---

The number of console applications are growing more and more in web application environment. Many frameworks of
many languages uses it and save a lot of time from developers and sysops to do some operations or even create
cron jobs.

In our company it is not different. We use tons of jobs to do many operations and sometimes makes hard to
remember the exactly name of the jobs. To simplify a little bit, we implemented support to
[bash completion](http://bash-completion.alioth.debian.org/).

Our jobs has a "starter" (common executable file, which load the configurations, basic stuffs, and run the
target operation), similar the frameworks. In our case, we call `/app_folder/job ClassName [methodName]` and
the `job` is just a shell script to execute `php job.php $@`. The `job.php` do the bootstrap part and loads
the classname from the first parameter in a specific namespace. For example, our base namespace is
`Zumba\Job`, if you pass `job Engineering` it will try to load the class `Zumba\Job\Engineering`.
By default we call the method `execute`, but if you pass the second parameter we try to run that method
instead of `execute`, making one job class reusable for multiple actions.

This weekend I saw the [bash completion for CakePHP](https://github.com/AD7six/cakephp-completion) from
[Andy Dawson](http://ad7six.com/) and had an idea to do the same for our service application, because
we frequently forget the exactly job class or method name and add extra steps to verify these names
before execute the job. I read his code, made some research and finally get our bash completion working
fine.

First thing you need to do is make your application returns the available options for the first and
second parameter. It means you will be able to get the available options from console by executing some
command. PS: If your application do not change often or you don't want or can update your app, you can have
the parameters hard coded in the bash completion script.

In our case, I could add a job class to get that informaiton, but I prefered to use a symbolic method and
parse with an `if` in the `job.php` file. I used that way to avoid create a job class for this proposal and
be one more in the list and share the structure from the others methods, which is a little complicated
(we have some logs, register execution, etc.). But few free to do the way you want. In the end, you can run
my script like `job __check__` to get the available classes or `job __check__ SpecificJobClass` to get
the available methods.

The PHP portion is basically that:

<script type="text/javascript" src="https://gist.github.com/3398491.js"></script>

<noscript>The code is available on <a href="https://gist.github.com/3398491">https://gist.github.com/3398491</a></noscript>

With that, from the console we are able to execute the check (`job __check__`) and the list of available jobs:
`Job1 MyCustom MyApp TopSecret StopTheCompany`

This was the first step from the script. The second part is get a list of the available methods, ie when
execute the `job __check__ StopTheCompany` we get something like: `shutdownServers dropDatabase removeAppCode`

Now is time to make the bash interact with your code. You need to create a script in your
`/etc/bash_completion.d/` folder, with permission 0644. It will be like the code below.

<script type="text/javascript" src="https://gist.github.com/3398516.js"></script>

<noscript>The code is available on <a href="https://gist.github.com/3398516">https://gist.github.com/3398516</a></noscript>

To explain a bit, the last line will tell bash to complete the executable `job` using the function
`_my_application` (defined few lines above). The function basically test the number of parameters and
call your application with the current parameters and transmit to the bash completion. In our case, we have
just two parameters, as you can see.

After save the file in the `/etc/bash_completion.d` restart your bash/console/terminal and you can try to
use the completion. I guess I don't need to put some examples how to use or how it looks like. If you never
used bash completion it is not the place to get started.
