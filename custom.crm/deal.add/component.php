<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Crm\Category\DealCategory;

CModule::IncludeModule('socialnetwork');

$obRes = CSocNetGroup::GetList(
	$arOrder = array(
		'ID' => 'ASC',
	),
	$arFilter = array(
		'ID' => $arParams['PROJECT'],
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
	$arResult['LINKED_PROJECT'] = $arProject;
}

foreach (DealCategory::getAll(true) as $dealCategory) {
	$arResult['DEAL_CATEGORY'][$dealCategory['ID']] = $dealCategory['NAME'];
}

$arResult['COMPONENT_DIRECTORY'] = $this->GetPath().'/';

$this->IncludeComponentTemplate();
