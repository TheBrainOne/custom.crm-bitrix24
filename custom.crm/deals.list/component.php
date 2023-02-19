<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Loader;
use Bitrix\Crm\Category\DealCategory;

if (!Loader::includeModule('crm')) {
	ShowError('Не подключен модуль CRM');
	return;
}

$obRes = CCrmDeal::GetList(
	$arOrder = array(
		'ID' => 'ASC',
	),
	$arFilter = array(
		'%STAGE_ID' => 'C' . $arParams['DEAL_CATEGORY'],
		'CHECK_PERMISSIONS' => 'N',
	),
	$arSelectFields = array(
		'ID',
		'TITLE',
		'DATE_CREATE',
		'CREATED_BY',
	),
	$nPageTop = false
);

while ($arDeal = $obRes->Fetch()) {
	if ($arDeal['TITLE']) {
		$arDeal['TITLE'] = '<a target="_top" href="/crm/deal/details/' . $arDeal['ID'] . '/">' . $arDeal['TITLE'] . '</a>';
	}
	
	if ($arDeal['CREATED_BY']) {
		$user = CUser::GetByID($arDeal['CREATED_BY'])->Fetch();
		$arDeal['CREATED_BY'] = (empty($user['NAME']) || empty($user['LAST_NAME'])) ? $user['LOGIN'] : $user['NAME'] . ' '. $user['LAST_NAME'];
	}
	
	$arResult['DEALS'][] = array(
		'id' => $arDeal['ID'],
		'actions' => array(),
		'data' => $arDeal,
		'columns' => $arDeal
	);
}

$arResult['HEADERS'] = array(
	array(
		'id' => 'ID',
		'name' => 'ID',
		'sort' => 'ID',
		'default' => true,
	),
	array(
		'id' => 'TITLE',
		'name' => 'Название сделки',
		'default' => true,
	),
	array(
		'id' => 'DATE_CREATE',
		'name' => 'Дата создания',
		'default' => true,
	),
	array(
		'id' => 'CREATED_BY',
		'name' => 'Кто создал',
		'default' => true,
	),
);

$arResult['PAGE_TITLE'] = $arParams['PAGE_TITLE'];

$this->IncludeComponentTemplate();
