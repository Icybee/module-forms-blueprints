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

use ICanBoogie\HTTP\Request;
use ICanBoogie\Operation;

use Brickrouge\A;
use Brickrouge\Button;
use Brickrouge\Element;
use Brickrouge\Form;
use Brickrouge\Group;

class FormFactory
{
	public function __invoke(Blueprint $blueprint, Request $request)
	{
		$progress = $blueprint->progress;
		$page = $progress->page;

		$actions = $this->resolve_actions($progress);
		$children = $this->resolve_children($page);

		return new Form(array(

			Form::ACTIONS => $actions,
			Form::HIDDENS => array
			(
				'uuid' => $blueprint->uuid,
				Operation::DESTINATION => 'forms.blueprints',
				Operation::NAME => 'submit'
			),

			Form::RENDERER => 'Simple',
			Form::VALUES => $request->params + $progress->responses,

			Element::CHILDREN => $children,

			'name' => $blueprint->uuid
		));
	}

	protected function resolve_actions(Progress $progress)
	{
		$actions = array
		(
			new Button($progress->is_last_page ? "Submit" : "Continue", array(

				'class' => 'btn-primary',
				'type' => 'submit'
			))
		);

		if (!$progress->is_first_page)
		{
			array_unshift($actions, new A('Back', '?backtrack', array('class' => 'btn btn-backtrack')));
		}

		return $actions;
	}

	protected function resolve_children(Page $page)
	{
		$control_factory = new ControlFactory;
		$validator_factory = new ValidatorFactory;
		$children = array();

		foreach ($page as $item)
		{
			$control = $control_factory($item);

			$children[$item->uuid] = $control->to_element(array(

				Group::LABEL => $item->title,
				Element::REQUIRED => (bool) $item->is_required,
				Element::DESCRIPTION => $item->description,
				Element::VALIDATOR => array(function(\ICanBoogie\Errors $errors, Element $element, $value) use($item, $validator_factory) {

					$validator = $validator_factory($item);
					$error = $validator($value);

					if (!$error)
					{
						return;
					}

					$errors[$element['name']] = implode(' ', $error);

				})
			));
		}

		return $children;
	}
}