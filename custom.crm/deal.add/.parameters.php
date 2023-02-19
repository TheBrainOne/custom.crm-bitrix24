<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule('socialnetwork');

$obRes = CSocNetGroup::GetList(
	$arOrder = array(
		'ID' => 'ASC',
	),
	$arFilter = array(
		'ACTIVE' => 'Y',
	),
	$arGroupBy = false,
	$arNavStartParams = false,
	$arSelectFields = array(
		'ID',
		'NAME',
	),
);

while ($arProject = $obRes->Fetch()) {
	$values[$arProject['ID']] = $arProject['NAME'];
}

$arComponentParameters = array(
	'PARAMETERS' => array(
		'PROJECT' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('LINKED_PROJECT'),
			'TYPE' => 'LIST',
			'VALUES' => $values ?? array(),
			'MULTIPLE' => 'N',
		),
	),
	'CACHE_TYPE' => 'N',
);
