---
layout: post
title: "Symbiosis: Instanced Dispatcher Support Added"
description: New version of Symbiosis (v1.2)
tags: [events, plugins, add-ons, modules, open-source, symbiosis]
author: cjsaylor
---

A new version of Symbiosis [v1.2](https://github.com/zumba/symbiosis/releases/tag/v1.2) has been released.

### Introducing Instanced Dispatchers

Prior to v1.2, all events were globally registered via a [statically defined event manager](https://github.com/zumba/symbiosis/blob/v1.1.5/Zumba/Symbiosis/Event/EventManager.php#L19). This posed issues when some models needed to have events contained to themselves, instead of available in the global event space.

To solve this issue, we've added an [Event Registry](https://github.com/zumba/symbiosis/blob/v1.2/src/Zumba/Symbiosis/Event/EventRegistry.php). This has the same API and functionality of the Event Manager, but in an instanced state. Now you can create an Event Registry anywhere and register events specifically to it. The Event Manager remains backwards compatible, but under the hood, it is using a static instance of the new Event Registry system.

### Composer update

We've also improved the composer setup to properly use the [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) standard. As such, the autoloader has been removed. If you were using Symbiosis prior to v1.2 and were using the autoloader directly, you will need to update to use the composer autoloader.

### Conclusion

Symbiosis is now more flexable to implement. Our next steps will be to improve the plugin system to be more (and less) coupled to the event system.

See the full changeset: [https://github.com/zumba/symbiosis/pull/15/files](https://github.com/zumba/symbiosis/pull/15/files)
