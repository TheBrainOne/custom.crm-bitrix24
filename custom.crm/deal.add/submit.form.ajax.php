<?php
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application;

CModule::IncludeModule('crm');
CModule::IncludeModule('tasks');

$request = Application::getInstance()->getContext()->getRequest();

try {
	$dealTitle = strip_tags($request->getPost('dealTitle'));
	$dealResponsiblePerson = strip_tags($request->getPost('dealResponsiblePerson'));
	$dealHeading = strip_tags($request->getPost('dealHeading'));
	$dealContact = strip_tags($request->getPost('dealContact'));
	$linkedProject = strip_tags($request->getPost('linkedProject'));
	
	if (!$dealTitle || !$dealResponsiblePerson || empty($dealHeading) || !$dealContact || !$linkedProject) {
		http_response_code(400);
		throw new Exception('Неверно переданы поля.');
	}
	
	$userId = str_replace('U', '', $dealResponsiblePerson);
	$contactId = str_replace('C_', '', $dealContact);
	
	$arDealFields = array(
		'TITLE' => $dealTitle,
		'ASSIGNED_BY_ID' => $userId,
		'CATEGORY_ID' => $dealHeading,
		'CONTACT_ID' => $contactId,
	);
	
	$newDeal = new CCrmDeal(false);
	$newDealId = $newDeal->Add(
		$arDealFields,
		$bUpdateSearch = true,
		$options = array(),
	);
	
	if (!$newDealId) {
		http_response_code(500);
		throw new Exception('Произошла ошибка при создании сделки.');
	}
	
	$deadlineDate = mktime(
		date('H'),
		date('i'),
		date('s'),
		date('m'),
		date('d') + 7,
		date('Y')
	);
	
	$arTaskFields = array(
		'TITLE' => $dealTitle,
		'RESPONSIBLE_ID' => $userId,
		'DEADLINE' => date('d.m.Y H:i:s', $deadlineDate),
	'GROUP_ID' => $linkedProject,
	'UF_CRM_TASK' => 'D_' . $newDealId,
);

$newTask = new CTasks();
$newTaskId = $newTask->Add(
	$arTaskFields,
	$arParams = array(),
);

if (!$newTaskId) {
	http_response_code(500);
	throw new Exception('Произошла ошибка при создании задачи.');
}

header('Location: /crm/deal/details/' . $newDealId . '/');
echo json_encode(array(), JSON_UNESCAPED_UNICODE);
} catch (Exception $error) {
echo json_encode(array('message' => $error->getMessage()), JSON_UNESCAPED_UNICODE);
}
