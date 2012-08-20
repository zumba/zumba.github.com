<?php

public static function register($events, $callback) {
	if (!is_callable($callback)) {
		throw new \Exception('Registration callback is not callable.');
	}
	$events = (array)$events;
	foreach ($events as $event) {
		static::$registry[$event][] = $callback;
	}
}