<?php
 
App::uses('CakeRoute', 'Routing/Route');
 
/**
 * Just a wrap of CakeRoute to support var_export
 */
class ZumbaRoute extends CakeRoute {
 
	public static function __set_state($fields) {
		$class = get_called_class();
		$obj = new $class('');
 
		foreach ($fields as $field => $value) {
			$obj->$field = $value;
		}
		return $obj;
	}
 
}
