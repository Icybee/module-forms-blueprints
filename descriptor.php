<?php

namespace Icybee\Modules\Forms\Blueprints;

use ICanBoogie\Module;
use ICanBoogie\ActiveRecord\Model;

return array
(
	Module::T_CATEGORY => 'feedback',
	Module::T_DESCRIPTION => "A tool to design forms",
	Module::T_EXTENDS => 'nodes',
	Module::T_MODELS => array
	(
		'primary' => array
		(
			Model::EXTENDING => 'nodes',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'uuid' => array('char', 36),
					'description' => 'text',
					'has_progress_bar' => 'boolean'
				)
			)
		),

		'items' => array
		(
			Model::BELONGS_TO => 'forms.blueprints',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'item_id' => 'serial',
					'nid' => 'foreign',
					'uuid' => array('char', 36),
					'type' => array('varchar', 64),
					'title' => 'varchar',
					'description' => 'text',
					'serialized_options' => 'text',
					'serialized_validation_options' => 'text',
					'is_required' => 'boolean',
					'weight' => array('integer', 'unsigned' => true)
				)
			)
		),

		'results' => array
		(
			Model::BELONGS_TO => 'forms.blueprints',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'result_id' => 'serial',
					'nid' => 'foreign',
					'uid' => 'foreign',
					'created_at' => 'datetime',
					'updated_at' => 'datetime',
					'serialized_responses' => array('text', 'long')
				)
			)
		)
	),

	Module::T_NAMESPACE => __NAMESPACE__,
	Module::T_TITLE => 'Form blueprints'
);