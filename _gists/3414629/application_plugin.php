<?php

namespace \YourApp\Plugin;

use \Zumba\Symbiosis\Framework\Plugin,
    \Zumba\Symbiosis\Event\EventManager;

class SamplePlugin extends Plugin {

  public function registerEvents() {
    EventManager::register('sample.someevent', function($event) {
      print_r($event->data());
    });
  }

}