<?php

use \Zumba\Symbiosis\Plugin\PluginManager;

// Somewhere in your application bootstrap, load your plugins
PluginManager::loadPlugins(
    '/path/to/your/plugin/directory', // Path to where you stored your plugins
    'YourApp\Plugin'                  // namespace defined in your plugins (see example above)
);