<?php

public static function trigger($event, $data = array()) {
	if (!isset(static::$registry[$event])) {
		// Log no event registered here.
		return false;
	}
	foreach (static::$registry[$event] as $listener) {
		call_user_func_array($listener, array($data));
	}
	return true;
}