<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UI\Extension;

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 */

$projectName = $arResult['LINKED_PROJECT'] ? 'для проекта "' . $arResult['LINKED_PROJECT']['NAME'] . '"' : '';

$APPLICATION->SetTitle("Добавление сделки $projectName");

Extension::load(array('ui.forms'));

?>
<form class="adding-deal-form" name="addingDealForm">
  <div class="adding-deal-form__field">
    <label class="adding-deal-form__label" for="dealTitle">Название сделки</label>
    <input class="adding-deal-form__input ui-ctl ui-ctl-element" type="text" id="dealTitle"
           name="dealTitle">
  </div>
  <div class="adding-deal-form__field">
    <label class="adding-deal-form__label" for="dealResponsiblePerson">Ответственный</label>
		<?php
			$APPLICATION->IncludeComponent('bitrix:main.user.selector', '', array(
					'ID' => 'dealResponsiblePerson',
					'API_VERSION' => 3,
					'LIST' => array_keys($crmQueueSelected),
					'INPUT_NAME' => 'dealResponsiblePerson',
					'USE_SYMBOLIC_ID' => true,
					'BUTTON_SELECT_CAPTION' => 'Добавьте ответственного',
					'SELECTOR_OPTIONS' => array(),
				)
			);
		?>
  </div>
  <div class="adding-deal-form__field">
    <label class="adding-deal-form__label" for="dealHeading">Направление сделки</label>
    <select class="adding-deal-form__select" type="text" id="dealHeading" name="dealHeading">
      <option value selected="selected">Не выбрано</option>
			<?php foreach ($arResult['DEAL_CATEGORY'] as $key => $value) { ?>
        <option value="<?= $key ?>"><?= $value ?></option>
			<?php } ?>
    </select>
  </div>
  <div class="adding-deal-form__field">
    <label class="adding-deal-form__label" for="dealContact">Контакт</label>
		<?php
			$APPLICATION->IncludeComponent('bitrix:main.user.selector', '', array(
					'ID' => 'dealContact',
					'API_VERSION' => 3,
					'LIST' => array_keys($crmQueueSelected),
					'INPUT_NAME' => 'dealContact',
					'USE_SYMBOLIC_ID' => true,
					'BUTTON_SELECT_CAPTION' => 'Добавьте контакт',
					'SELECTOR_OPTIONS' => array(
						'contextCode' => '',
						'enableUsers' => 'N',
						'enableDepartments' => 'N',
						'enableCrm' => 'Y',
						'crmPrefixType' => 'SHORT',
						'enableCrmContacts' => 'Y',
						'addTabCrmContacts' => 'Y',
					),
				)
			);
		?>
  </div>
  <button class="ui-btn ui-btn-primary" type="submit">Создать сделку</button>
</form>

<script type="text/javascript">
  const addingDealForm = document.forms.addingDealForm;

  addingDealForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const { dealTitle, dealResponsiblePerson, dealHeading, dealContact } = Object.fromEntries(
      formData.entries());

    const linkedProject = <?= $arResult['LINKED_PROJECT']['ID'] ?>;
    formData.append('linkedProject', linkedProject);

    if (!dealTitle || !dealResponsiblePerson || !dealHeading || !dealContact) {
      return;
    }

    try {
      const response = await fetch('<?= $arResult['COMPONENT_DIRECTORY'] ?>submit.form.ajax.php', {
        method: 'POST',
        body: formData,
      });

      window.location.href = response.url;
    }
    catch (error) {
      console.error(error);
    }
  });
</script>
 