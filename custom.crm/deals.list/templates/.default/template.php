<?php
defined('B_PROLOG_INCLUDED') || die;

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 */

$APPLICATION->SetTitle($arResult['PAGE_TITLE']);

$APPLICATION->IncludeComponent(
	'bitrix:crm.interface.grid',
	'',
	array(
		'GRID_ID' => 'custom-crm__deals-list',
		'HEADERS' => $arResult['HEADERS'],
		'ROWS' => $arResult['DEALS'],
		'PAGINATION' => array(),
		'SORT' => array(),
		'FILTER' => array(),
		'FILTER_PRESETS' => array(),
		'IS_EXTERNAL_FILTER' => false,
		'ENABLE_LIVE_SEARCH' => 'N',
		'DISABLE_SEARCH' => 'Y',
		'ENABLE_ROW_COUNT_LOADER' => true,
		'AJAX_ID' => '',
		'AJAX_OPTION_JUMP' => 'N',
		'AJAX_OPTION_HISTORY' => 'N',
		'AJAX_LOADER' => null,
		'ACTION_PANEL' => array(),
		'EXTENSION' => array(),
	),
	$this->getComponent(),
	array('HIDE_ICONS' => 'Y',)
);
