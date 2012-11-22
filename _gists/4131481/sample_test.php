<?php

class SampleTest extends \PHPUnit_Framework_TestCase {

   public function testSayHello() {
      $sample = new Sample();
      $name = 'Chris';
      $replace = 'Goodbye, Chris!';
      SomeclassMock::expects($name, $replace);
      $this->assertEquals("Goodbye, Chris!", $sample->sayHello($name));
      SomeclassMock::cleanup();
   }

}
