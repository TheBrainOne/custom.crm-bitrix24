<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('COMPONENT_NAME'),
	'DESCRIPTION' => GetMessage('COMPONENT_DESCRIPTION'),
	'SORT' => 10,
	'PATH' => array(
		'ID' => 'custom-crm',
		'NAME' => GetMessage('VISUAL_EDITOR_PATH_NAME'),
		'CHILD' => array(
			'ID' => 'deals-list',
			'NAME' => GetMessage('VISUAL_EDITOR_CHILD_NAME')
		),
	),
	'CACHE_PATH' => 'Y',
);
