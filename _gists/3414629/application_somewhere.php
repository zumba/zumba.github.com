<?php

use \Zumba\Symbiosis\Event\Event;

// Somewhere in your app, trigger plugins listening to event
$event = new Event('sample.someevent', array('ping' => 'pong'));
$event->trigger();