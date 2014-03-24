<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Blueprints;

$hooks = __NAMESPACE__ . '\Hooks::';

return array
(
	'events' => array
	(
		'Icybee\Modules\Users\LogoutOperation::process' => $hooks . 'on_user_logout'
	),

	'prototypes' => array
	(
		'Icybee\Modules\Forms\Blueprints\Blueprint::get_page_list' => $hooks . 'blueprint_get_page_list',
		'Icybee\Modules\Forms\Blueprints\Blueprint::get_progress' => $hooks . 'blueprint_get_progress',
		'Icybee\Modules\Forms\Blueprints\Blueprint::to_element' => $hooks . 'blueprint_to_element',
		'Icybee\Modules\Forms\Blueprints\Item::get_control' => $hooks . 'item_get_control'
	)
);