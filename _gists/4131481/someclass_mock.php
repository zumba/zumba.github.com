<?php

class SomeclassMock {

	/**
	 * Generates a mock object on the singleton Someclass util object.
	 *
	 * @param array $name
	 * @return void
	 */
	public static function expects($name, $replace) {
		// Mock the object
		$mock = \PHPUnit_Framework_MockObject_Generator::getMock(
			'Someclass',
			array('hello'),
			array(),
			'',
			false
		);

		// Replace protected self reference with mock object
		$ref = new \ReflectionProperty('Someclass', 'self');
		$ref->setAccessible(true);
		$ref->setValue(null, $mock);

		// Set expectations and return values
		$mock
			->expects(new \PHPUnit_Framework_MockObject_Matcher_InvokedCount(1))
			->method('hello')
			->with(
				\PHPUnit_Framework_Assert::equalTo($name)
			)
			->will(new \PHPUnit_Framework_MockObject_Stub_Return($replace));
	}

	public static function cleanup() {
		$ref = new \ReflectionProperty('Someclass', 'self');
		$ref->setAccessible(true);
		$ref->setValue(null, null);
	}

}
