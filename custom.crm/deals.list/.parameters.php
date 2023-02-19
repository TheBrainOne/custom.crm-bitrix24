<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Crm\Category\DealCategory;

CModule::IncludeModule('crm');

foreach (DealCategory::getAll(true) as $dealCategory) {
	$values[$dealCategory['ID']] = $dealCategory['NAME'];
}

$arComponentParameters = array(
	'PARAMETERS' => array(
		'PAGE_TITLE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('PAGE_TITLE'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'Список сделок'
		),
		'DEAL_CATEGORY' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('DEAL_CATEGORY'),
			'TYPE' => 'LIST',
			'VALUES' => $values ?? array(),
			'MULTIPLE' => 'N',
		)
	),
);
