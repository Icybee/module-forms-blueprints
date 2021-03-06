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

return array
(
	'admin:forms.blueprints/results' => array
	(
		'pattern' => '/admin/forms.blueprints/<\d+>/results',
		'controller' => 'Icybee\BlockController',
		'block' => 'results'
	)
);