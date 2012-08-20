<?php

public function addItem(Item $item, $quantity) {
	// Trigger event before the item is added
	EventManager::trigger('cart.before-add', compact('item', 'quantity'));
	// Some cart logic here to add the item
	// Trigger event after the item is added
	EventManager::trigger('cart.after-add', compact('item', 'quantity'));
}