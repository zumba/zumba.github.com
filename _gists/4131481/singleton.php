<?php

class Someclass {

   protected static $self;

   protected __construct() {
   }

   public static function getInstance() {
      if (empty(static::$self)) {
         static::$self = new Someclass();
      }
      return static::$self;
   }

   public function hello($name) {
      return "hello, $name!";
   }

}
